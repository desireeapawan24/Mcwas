@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Notifications</h1>
                <p class="text-gray-600">Manage your notifications and assignments</p>
            </div>
            <div class="flex space-x-2">
                <form action="{{ route('plumber.mark-all-notifications-read') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Mark All as Read
                    </button>
                </form>
                <a href="{{ route('plumber.dashboard') }}" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500">
                    Back to Dashboard
                </a>
            </div>
        </div>
    </div>

    <!-- Notifications List -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">
                All Notifications 
                @if(auth()->user()->unreadNotifications->count() > 0)
                    <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                        {{ auth()->user()->unreadNotifications->count() }} unread
                    </span>
                @endif
            </h3>
        </div>
        <div class="p-6">
            @if($notifications->count() > 0)
                <div class="space-y-4">
                    @foreach($notifications as $notification)
                        <div class="border rounded-lg p-4 {{ $notification->read_at ? 'border-gray-200 bg-gray-50' : 'border-blue-200 bg-blue-50' }}">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            @if($notification->read_at)
                                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            @else
                                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            @endif
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium {{ $notification->read_at ? 'text-gray-900' : 'text-blue-900' }}">
                                                New Customer Assignment
                                            </p>
                                            <p class="text-sm {{ $notification->read_at ? 'text-gray-600' : 'text-blue-700' }} mt-1">
                                                {{ $notification->data['message'] }}
                                            </p>
                                            <div class="mt-2 text-xs {{ $notification->read_at ? 'text-gray-500' : 'text-blue-600' }}">
                                                <strong>Customer:</strong> {{ $notification->data['customer_name'] }} ({{ $notification->data['customer_number'] }})<br>
                                                <strong>Address:</strong> {{ $notification->data['customer_address'] }}<br>
                                                <strong>Phone:</strong> {{ $notification->data['customer_phone'] }}<br>
                                                <strong>Email:</strong> {{ $notification->data['customer_email'] }}
                                            </div>
                                            <div class="mt-2 text-xs text-gray-500">
                                                {{ $notification->created_at->diffForHumans() }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if(!$notification->read_at)
                                    <div class="ml-4 flex-shrink-0">
                                        <form action="{{ route('plumber.mark-notification-read', $notification->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                Mark as Read
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $notifications->links() }}
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No notifications</h3>
                    <p class="mt-1 text-sm text-gray-500">You don't have any notifications yet.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection




