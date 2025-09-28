<?php

namespace App\Services;

use App\Models\WaterBill;
use App\Models\WaterConnection;
use App\Models\WaterRate;
use App\Models\MeterReading;
use Carbon\Carbon;

class BillingService
{
	/**
	 * Default assumed daily consumption in cubic meters.
	 * In a real system, replace with actual meter readings.
	 */
    private float $defaultDailyUsage = 1.0;
    /**
     * Pricing: First 10 m³ = ₱160; Excess = ₱5.3333333333333 per m³
     */
    private float $excessRatePerCubicMeter = 5.3333333333333;

	/**
	 * Recalculate the current-month bill for a customer based on
	 * completion date and water rate history up to today.
	 */
	public function recalculateCurrentBillForCustomer(int $customerId): void
	{
		$connection = WaterConnection::where('customer_id', $customerId)
			->completed()
			->latest('completion_date')
			->first();

		if (!$connection) {
			return;
		}

        $today = Carbon::now()->startOfDay();
        $monthStart = Carbon::now()->copy()->startOfMonth();
        $monthEnd = Carbon::now()->copy()->endOfMonth();
		$startDate = Carbon::parse($connection->completion_date)->startOfDay();
		if ($startDate->lessThan($monthStart)) {
			$startDate = $monthStart;
		}
		if ($startDate->greaterThan($today)) {
			$startDate = $today;
		}

        // Prefer actual meter readings for the current month (mid/end), otherwise fallback to default
        $totalConsumption = MeterReading::where('customer_id', $customerId)
            ->whereBetween('reading_date', [$monthStart->toDateString(), $monthEnd->toDateString()])
            ->sum('used_cubic_meters');

        if ($totalConsumption <= 0) {
            // Fallback to default estimation if no readings yet
            $days = $startDate->diffInDays($today) + 1;
            if ($days < 1) {
                $days = 1;
            }
            $totalConsumption = $days * $this->defaultDailyUsage;
        }

        // Pricing rules:
        // - First 10 m³ costs a flat ₱160 total
        // - Any consumption above 10 m³ uses the current per-m³ rate (fallback to 0.56 if none)
        // Use fixed excess rate per requirement
        $currentRate = $this->excessRatePerCubicMeter;
        if ($totalConsumption <= 0) {
            $totalAmount = 0.0;
        } elseif ($totalConsumption <= 10) {
            $totalAmount = 160.0;
        } else {
            $excess = $totalConsumption - 10.0;
            $totalAmount = 160.0 + ($excess * (float) $currentRate);
        }
        $totalAmount = round($totalAmount, 2);

		$billingMonth = $monthStart->format('Y-m-d');
		$dueDate = Carbon::now()->copy()->addMonth()->startOfMonth()->format('Y-m-d');

		$bill = WaterBill::firstOrCreate(
			[
				'customer_id' => $customerId,
				'billing_month' => $billingMonth,
			],
			[
				'cubic_meters_used' => 0,
				'rate_per_cubic_meter' => optional(WaterRate::current()->first())->rate_per_cubic_meter ?? 0,
				'total_amount' => 0,
				'balance' => 0,
				'due_date' => $dueDate,
				'status' => 'unpaid',
			]
		);

        $bill->cubic_meters_used = $totalConsumption;
        $bill->total_amount = $totalAmount;
		$bill->balance = $bill->total_amount - ($bill->amount_paid ?? 0);
		if ($bill->balance <= 0) {
			$bill->status = 'paid';
			$bill->paid_date = Carbon::now();
		} elseif (($bill->amount_paid ?? 0) > 0) {
			$bill->status = 'partially_paid';
		} else {
			$bill->status = 'unpaid';
		}
        // Store rate used for excess calculation
        $bill->rate_per_cubic_meter = (float) $currentRate;
		$bill->save();
	}

	/**
	 * Compute amount over a date range using effective water rate changes.
	 */
	private function computeAmountByRateSegments(Carbon $startDate, Carbon $endDate, float $dailyUsage): float
	{
		$rates = WaterRate::where('effective_date', '<=', $endDate->toDateString())
			->orderBy('effective_date', 'asc')
			->get();

		if ($rates->isEmpty()) {
			return 0.0;
		}

		$total = 0.0;
		$segmentStart = $startDate->copy();

		for ($i = 0; $i < $rates->count(); $i++) {
			$rate = $rates[$i];
			$rateStart = Carbon::parse($rate->effective_date)->startOfDay();
			$nextStart = $i + 1 < $rates->count()
				? Carbon::parse($rates[$i + 1]->effective_date)->startOfDay()
				: null;

			// Segment applies from max(segmentStart, rateStart) to min(endDate, day before nextStart)
			$curStart = $segmentStart->greaterThan($rateStart) ? $segmentStart->copy() : $rateStart->copy();
			$curEnd = $endDate->copy();
			if ($nextStart) {
				$curEnd = $curEnd->min($nextStart->copy()->subDay());
			}

			if ($curStart->greaterThan($curEnd)) {
				continue;
			}

			$daysInSegment = $curStart->diffInDays($curEnd) + 1;
			$total += $daysInSegment * $dailyUsage * (float) $rate->rate_per_cubic_meter;

			if (!$nextStart || $curEnd->equalTo($endDate)) {
				break;
			}
			$segmentStart = $nextStart->copy();
		}

		return round($total, 2);
	}
}





