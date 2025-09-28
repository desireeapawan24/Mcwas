@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">
	<h1 class="text-2xl font-bold mb-4 capitalize">{{ $role }} Records</h1>

	@if(session('created_user'))
		@php($cu = session('created_user'))
		<div class="mb-4 bg-green-50 border border-green-200 rounded p-4">
			<div class="flex items-start justify-between">
				<div>
					<p class="text-green-800 font-semibold">New {{ ucfirst($cu['role']) }} created</p>
					<p class="text-sm text-green-700">Provide these temporary credentials to the user.</p>
				</div>
				<button onclick="window.printCredentials()" class="px-3 py-1 text-sm bg-green-600 text-white rounded hover:bg-green-700">Print</button>
			</div>
			<div id="printableCredentials" class="mt-3 bg-white border rounded p-4">
				<h2 class="text-lg font-bold mb-2">Temporary Account</h2>
				<div class="text-sm space-y-1">
					<p><span class="font-medium">Name:</span> {{ $cu['name'] }}</p>
					<p><span class="font-medium">Role:</span> {{ ucfirst($cu['role']) }}</p>
					<p><span class="font-medium">Email:</span> {{ $cu['email'] }}</p>
					<p><span class="font-medium">Temporary Password:</span> {{ $cu['password'] }}</p>
					<p class="text-xs text-gray-500">Advise the user to log in and change the password immediately.</p>
				</div>
			</div>
		</div>
	@endif

	<a href="{{ route('admin.create-user') }}" class="inline-block mb-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Create {{ ucfirst($role) }}</a>

	<div class="bg-white rounded shadow">
		<table class="min-w-full divide-y divide-gray-200">
			<thead class="bg-gray-50">
				<tr>
					<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
					<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
					<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Address</th>
					<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Phone</th>
					<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Temp Password</th>
				</tr>
			</thead>
			<tbody class="bg-white divide-y divide-gray-200">
				@forelse($users as $u)
				<tr>
					<td class="px-6 py-4">{{ $u->full_name }}</td>
					<td class="px-6 py-4">{{ $u->email }}</td>
					<td class="px-6 py-4">{{ $u->address }}</td>
					<td class="px-6 py-4">{{ $u->phone_number }}</td>
					<td class="px-6 py-4">{{ $u->plain_password }}</td>
				</tr>
				@empty
				<tr><td colspan="5" class="px-6 py-4 text-gray-500">No records</td></tr>
				@endforelse
			</tbody>
		</table>
	</div>
</div>
@endsection

@push('scripts')
<script>
window.printCredentials = function() {
    const content = document.getElementById('printableCredentials');
    if (!content) return;
    const w = window.open('', '', 'height=600,width=420');
    w.document.write('<html><head><title>Temporary Account</title>');
    w.document.write('</head><body>');
    w.document.write(content.outerHTML);
    w.document.write('</body></html>');
    w.document.close();
    w.focus();
    w.print();
    w.close();
}
</script>
@endpush



