@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-6">
	<h1 class="text-2xl font-bold mb-4">My Bills</h1>
	<div class="bg-white rounded shadow">
		<table class="min-w-full divide-y divide-gray-200">
			<thead class="bg-gray-50">
				<tr>
					<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Month</th>
					<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cubic Meters</th>
					<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rate</th>
					<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
					<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Balance</th>
					<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
				</tr>
			</thead>
			<tbody class="bg-white divide-y divide-gray-200">
				@forelse($bills as $bill)
				<tr>
					<td class="px-6 py-4">{{ $bill->billing_month->format('M Y') }}</td>
					<td class="px-6 py-4">{{ number_format($bill->cubic_meters_used, 2) }}</td>
					<td class="px-6 py-4">₱{{ number_format($bill->rate_per_cubic_meter, 2) }}</td>
					<td class="px-6 py-4">₱{{ number_format($bill->total_amount, 2) }}</td>
					<td class="px-6 py-4">₱{{ number_format($bill->balance, 2) }}</td>
					<td class="px-6 py-4 capitalize">{{ str_replace('_',' ', $bill->status) }}</td>
				</tr>
				@empty
				<tr><td colspan="6" class="px-6 py-4 text-gray-500">No bills yet</td></tr>
				@endforelse
			</tbody>
		</table>
	</div>
</div>
@endsection



