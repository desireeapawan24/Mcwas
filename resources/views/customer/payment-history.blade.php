@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
	<div class="mb-6 flex items-center justify-between">
		<h1 class="text-2xl font-bold text-gray-900">Payment History</h1>
		<a href="{{ route('customer.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300">Back to Dashboard</a>
	</div>

	@if ($payments->count() === 0)
		<p class="text-gray-600">No payments yet.</p>
	@else
		<div class="overflow-x-auto bg-white rounded-lg shadow">
			<table class="min-w-full divide-y divide-gray-200">
				<thead class="bg-gray-50">
					<tr>
						<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
						<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Billing Month</th>
						<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
						<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Method</th>
						<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reference</th>
					</tr>
				</thead>
				<tbody class="bg-white divide-y divide-gray-200">
					@foreach ($payments as $payment)
						<tr>
							<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $payment->created_at->format('M d, Y') }}</td>
							<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ optional($payment->waterBill->billing_month)->format('Y-m') }}</td>
							<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">₱{{ number_format($payment->amount_paid, 2) }}</td>
							<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $payment->payment_method }}</td>
							<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $payment->reference_number ?: '-' }}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		<div class="mt-4">
			{{ $payments->links() }}
		</div>
	@endif
</div>
@endsection






