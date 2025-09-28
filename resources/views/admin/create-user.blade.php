@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-6">
	<h1 class="text-2xl font-bold mb-4">Create User</h1>
	<form method="POST" action="{{ route('admin.store-user') }}" class="space-y-4">
		@csrf
		<div>
			<label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
			<select name="role" required class="w-full border px-3 py-2 rounded">
				<option value="customer">Customer</option>
				<option value="plumber">Plumber</option>
				<option value="accountant">Accountant</option>
			</select>
		</div>
		<div class="grid grid-cols-2 gap-4">
			<div>
				<label class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
				<input type="text" name="first_name" required class="w-full border px-3 py-2 rounded">
			</div>
			<div>
				<label class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
				<input type="text" name="last_name" required class="w-full border px-3 py-2 rounded">
			</div>
		</div>
		<div>
			<label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
			<input type="email" name="email" required class="w-full border px-3 py-2 rounded">
		</div>
		<div class="grid grid-cols-2 gap-4">
			<div>
				<label class="block text-sm font-medium text-gray-700 mb-1">Age</label>
				<input type="number" name="age" min="18" max="120" required class="w-full border px-3 py-2 rounded">
			</div>
			<div>
				<label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
				<input type="text" name="phone_number" required class="w-full border px-3 py-2 rounded">
			</div>
		</div>
		<div>
			<label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
			<textarea name="address" rows="3" required class="w-full border px-3 py-2 rounded"></textarea>
		</div>
		<div>
			<label class="block text-sm font-medium text-gray-700 mb-1">Temporary Password</label>
			<input type="text" name="password" required class="w-full border px-3 py-2 rounded">
		</div>
		<div class="text-right">
			<button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Create</button>
		</div>
	</form>
</div>
@endsection



