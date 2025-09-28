@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-6">
	<h1 class="text-2xl font-bold mb-4">My Profile</h1>
	<form method="POST" action="{{ route('customer.update-profile') }}" class="space-y-4">
		@csrf
		<div class="grid grid-cols-2 gap-4">
			<div>
				<label class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
				<input type="text" name="first_name" value="{{ auth()->user()->first_name }}" class="w-full border px-3 py-2 rounded">
			</div>
			<div>
				<label class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
				<input type="text" name="last_name" value="{{ auth()->user()->last_name }}" class="w-full border px-3 py-2 rounded">
			</div>
		</div>
		<div>
			<label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
			<textarea name="address" rows="3" class="w-full border px-3 py-2 rounded">{{ auth()->user()->address }}</textarea>
		</div>
		<div>
			<label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
			<input type="text" name="phone_number" value="{{ auth()->user()->phone_number }}" class="w-full border px-3 py-2 rounded">
		</div>
		<div class="text-right">
			<button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Save</button>
		</div>
	</form>
</div>
@endsection



