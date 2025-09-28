@extends('layouts.guest')

@section('content')
<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
	<div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
		<div class="mb-6 text-center">
			<h2 class="text-2xl font-bold text-gray-900">Admin Registration</h2>
			<p class="text-sm text-gray-600 mt-2">Create an admin account</p>
		</div>

		<form method="POST" action="{{ route('admin.register.store') }}" class="space-y-4">
			@csrf

			<!-- Email -->
			<div>
				<label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
				<input id="email" type="email" name="email" value="{{ old('email') }}" required 
					   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
				@error('email')
					<p class="mt-1 text-sm text-red-600">{{ $message }}</p>
				@enderror
			</div>

			<!-- Password -->
			<div>
				<label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password *</label>
				<input id="password" type="password" name="password" required 
					   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
				@error('password')
					<p class="mt-1 text-sm text-red-600">{{ $message }}</p>
				@enderror
			</div>

			<!-- Confirm Password -->
			<div>
				<label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password *</label>
				<input id="password_confirmation" type="password" name="password_confirmation" required 
					   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
			</div>

			<!-- Submit Button -->
			<div>
				<button type="submit" 
						class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
					Create Admin
				</button>
			</div>
		</form>
	</div>
</div>
@endsection





