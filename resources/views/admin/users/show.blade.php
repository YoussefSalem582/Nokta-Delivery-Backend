@extends('layouts.admin')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ __('admin.user_details') }}</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('admin.view_detailed_info_user') }}</p>
    </div>
    <div class="flex gap-2">
        <button class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 text-gray-700 dark:text-gray-200 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 dark:hover:bg-slate-700 transition">
            {{ __('admin.edit') }}
        </button>
        <form action="{{ url('/admin/users/'.$user->id.'/suspend') }}" method="POST">
            @csrf
            @method('PATCH')
            <button type="submit" class="bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400 border border-red-200 dark:border-red-800 px-4 py-2 rounded-lg text-sm font-medium hover:bg-red-100 dark:hover:bg-red-900/50 transition">
                {{ __('admin.suspend') }}
            </button>
        </form>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- User Info Card -->
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 col-span-1 transition-colors">
        <div class="flex flex-col items-center text-center mb-6">
            <div class="w-24 h-24 rounded-full bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 flex items-center justify-center font-bold text-3xl mb-4">
                {{ strtoupper(substr($user->name, 0, 2)) }}
            </div>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ $user->name }}</h3>
            <p class="text-gray-500 dark:text-gray-400">{{ $user->email }}</p>
            <span class="mt-3 bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-400 text-xs px-3 py-1 rounded-full font-medium">{{ $user->role }}</span>
        </div>

        <div class="border-t border-gray-100 dark:border-slate-700 pt-4 space-y-4">
            <div class="flex justify-between">
                <span class="text-gray-500 dark:text-gray-400 text-sm">{{ __('admin.status') }}</span>
                <span class="text-green-600 dark:text-green-400 text-sm font-medium flex items-center gap-1">
                    <span class="w-2 h-2 rounded-full bg-green-500"></span> {{ __('admin.active') }}
                </span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500 dark:text-gray-400 text-sm">{{ __('admin.phone') }}</span>
                <span class="text-gray-900 dark:text-gray-200 text-sm font-medium">{{ $user->phone ?? __('admin.not_provided') }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500 dark:text-gray-400 text-sm">{{ __('admin.joined') }}</span>
                <span class="text-gray-900 dark:text-gray-200 text-sm font-medium">{{ $user->created_at->format('M d, Y') }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500 dark:text-gray-400 text-sm">{{ __('admin.last_updated') }}</span>
                <span class="text-gray-900 dark:text-gray-200 text-sm font-medium">{{ $user->updated_at->format('M d, Y') }}</span>
            </div>
        </div>
    </div>

    <!-- Activity Area -->
    <div class="col-span-1 lg:col-span-2 space-y-6">
        <!-- Stats -->
        <div class="grid grid-cols-2 gap-4">
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 transition-colors">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('admin.total_rides') }}</p>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $user->role == 'DRIVER' ? $user->driverRides()->count() : $user->riderRides()->count() }}</h3>
            </div>
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 transition-colors">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('admin.total_deliveries') }}</p>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $user->role == 'COURIER' ? $user->courierDeliveries()->count() : $user->senderDeliveries()->count() }}</h3>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 transition-colors">
            <h3 class="font-bold text-gray-800 dark:text-gray-100 mb-4">{{ __('admin.recent_activity') }}</h3>
            <div class="text-center py-8 text-gray-500 dark:text-gray-400 text-sm">
                {{ __('admin.activity_logs_here') }}
            </div>
        </div>
    </div>
</div>
@endsection
