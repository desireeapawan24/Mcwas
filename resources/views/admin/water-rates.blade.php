@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
	<div class="mb-6 flex items-center justify-between">
		<div>
			<h1 class="text-2xl font-bold text-gray-900">Water Rate Management</h1>
			<p class="text-gray-600">Set the water rate per cubic meter</p>
		</div>
		<a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300">
			Back to Dashboard
		</a>
	</div>

	@if (session('success'))
		<div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
			{{ session('success') }}
		</div>
	@endif

	@if ($errors->any())
		<div class="mb-4 p-4 bg-red-50 border border-red-300 text-red-700 rounded">
			<ul class="list-disc pl-5 space-y-1">
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif

	<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
		<!-- Current Rate and Set Form -->
		<div class="bg-white rounded-lg shadow">
			<div class="px-6 py-4 border-b border-gray-200">
				<h3 class="text-lg font-medium text-gray-900">Set New Water Rate</h3>
			</div>
			<div class="p-6 space-y-6">
				@php
					$currentRate = $rates->firstWhere('is_active', true);
				@endphp
				<div>
					<p class="text-sm text-gray-600">Current Active Rate:</p>
					<p class="text-2xl font-bold text-blue-600">₱{{ $currentRate ? number_format($currentRate->rate_per_cubic_meter, 2) : '0.00' }} per m³</p>
					@if($currentRate)
						<p class="text-xs text-gray-500 mt-1">Effective since {{ $currentRate->effective_date->format('M d, Y') }}</p>
					@endif
				</div>

				<form method="POST" action="{{ route('admin.set-water-rate') }}" class="space-y-4">
					@csrf
					<div>
						<label for="rate_per_cubic_meter" class="block text-sm font-medium text-gray-700 mb-1">Rate per cubic meter (₱)</label>
						<input id="rate_per_cubic_meter" name="rate_per_cubic_meter" type="number" step="0.01" min="0" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" placeholder="e.g. 25.00" />
					</div>
					<div>
						<label for="effective_date" class="block text-sm font-medium text-gray-700 mb-1">Effective date</label>
						<input id="effective_date" name="effective_date" type="date" value="{{ now()->toDateString() }}" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" />
					</div>
					<div>
						<button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Save New Rate</button>
					</div>
				</form>
			</div>
		</div>

		<!-- Rate History -->
		<div class="bg-white rounded-lg shadow">
			<div class="px-6 py-4 border-b border-gray-200">
				<h3 class="text-lg font-medium text-gray-900">Rate History</h3>
			</div>
			<div class="p-6">
				@if($rates->count() === 0)
					<p class="text-gray-500">No rates set yet.</p>
				@else
					<div class="overflow-x-auto">
						<table class="min-w-full divide-y divide-gray-200">
							<thead class="bg-gray-50">
								<tr>
									<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rate (₱/m³)</th>
									<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Effective Date</th>
									<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">End Date</th>
									<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
								</tr>
							</thead>
							<tbody class="bg-white divide-y divide-gray-200">
								@foreach($rates as $rate)
									<tr>
										<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">₱{{ number_format($rate->rate_per_cubic_meter, 2) }}</td>
										<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ optional($rate->effective_date)->format('M d, Y') }}</td>
										<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $rate->end_date ? $rate->end_date->format('M d, Y') : '-' }}</td>
										<td class="px-6 py-4 whitespace-nowrap text-sm">
											@if($rate->is_active)
												<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Active</span>
											@else
												<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">Inactive</span>
											@endif
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				@endif
			</div>
		</div>
	</div>
</div>
@endsection






