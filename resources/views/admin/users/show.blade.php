@extends('layouts.admin')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div class="flex items-center gap-4">
        <a href="{{ url('/admin/users') }}" class="text-gray-500 hover:text-indigo-600 transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <div>
            <h2 class="text-2xl font-bold text-gray-800">User Details</h2>
            <p class="text-sm text-gray-500">View detailed information about this user.</p>
        </div>
    </div>
    <div class="flex gap-2">
        <button class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg shadow-sm hover:bg-gray-50 transition">Edit</button>
        <button class="bg-red-50 text-red-600 border border-red-100 px-4 py-2 rounded-lg shadow-sm hover:bg-red-100 transition">Suspend</button>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6">
    <div class="p-6 md:flex items-start gap-8">
        <div class="shrink-0 mb-4 md:mb-0">
            <img class="w-24 h-24 rounded-full bg-gray-200 border-4 border-white shadow" src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random&size=128" alt="{{ $user->name }}">
        </div>
        <div class="flex-1">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-4">
                <div>
                    <h3 class="text-xl font-bold text-gray-900">{{ $user->name }}</h3>
                    <p class="text-gray-500">{{ $user->email }}</p>
                </div>
                <span class="px-3 py-1 text-sm font-medium rounded-full bg-indigo-50 text-indigo-700 w-max">
                    {{ ucfirst($user->role) }}
                </span>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-gray-100">
                <div>
                    <p class="text-sm text-gray-500 mb-1">User ID</p>
                    <p class="font-medium text-gray-900">{{ $user->id }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-1">Joined Date</p>
                    <p class="font-medium text-gray-900">{{ $user->created_at->format('F d, Y H:i:s') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-1">Phone (if applicable)</p>
                    <p class="font-medium text-gray-900">{{ $user->phone ?? 'Not provided' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-1">Last Updated</p>
                    <p class="font-medium text-gray-900">{{ $user->updated_at->format('F d, Y H:i:s') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="font-bold text-gray-800 mb-4 pb-2 border-b">Recent Activity</h3>
        <p class="text-gray-500 text-sm">Activity logs will be displayed here.</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="font-bold text-gray-800 mb-4 pb-2 border-b">Related Items</h3>
        <p class="text-gray-500 text-sm">Associated rides or deliveries will be shown here.</p>
    </div>
</div>
@endsection
