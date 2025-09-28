@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
	<div class="mb-6 flex items-center justify-between">
		<h1 class="text-2xl font-bold text-gray-900">Customer History</h1>
		<a href="{{ route('plumber.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300">Back to Dashboard</a>
	</div>

	@if ($connections->count() === 0)
		<p class="text-gray-600">No completed setups yet.</p>
	@else
		<div class="overflow-x-auto bg-white rounded-lg shadow">
			<table class="min-w-full divide-y divide-gray-200">
				<thead class="bg-gray-50">
					<tr>
						<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
						<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Address</th>
						<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Completed On</th>
					</tr>
				</thead>
				<tbody class="bg-white divide-y divide-gray-200">
					@foreach ($connections as $connection)
						<tr>
							<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $connection->customer->full_name }}</td>
							<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $connection->customer->address }}</td>
							<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ optional($connection->completion_date)->format('M d, Y') }}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	@endif
</div>
@endsection






