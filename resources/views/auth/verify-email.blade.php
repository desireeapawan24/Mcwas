@extends('layouts.guest')

@section('content')
<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
        <div class="mb-6 text-center">
            <h2 class="text-2xl font-bold text-blue-600">Verify Email</h2>
            <p class="text-sm text-gray-600 mt-2">Please verify your email address</p>
        </div>

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <div class="text-center space-y-4">
            <p class="text-gray-600">
                Before proceeding, please check your email for a verification link.
            </p>

            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" 
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Resend Verification Email
                </button>
            </form>

            <div class="pt-4 border-t">
                <a href="{{ route('dashboard') }}" class="text-sm text-blue-600 hover:text-blue-500">
                    Back to Dashboard
                </a>
            </div>
        </div>
    </div>
</div>
@endsection




