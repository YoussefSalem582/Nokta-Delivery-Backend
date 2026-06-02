@extends('layouts.admin')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ __('admin.ride_details') }} <span class="text-sm font-normal text-gray-500 dark:text-gray-400 ml-2">#{{ $ride->id }}</span></h2>
        <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('admin.view_detailed_info_ride') }}</p>
    </div>
    @if($ride->status !== 'CANCELLED' && $ride->status !== 'COMPLETED')
        <form action="{{ url('/admin/rides/'.$ride->id.'/cancel') }}" method="POST">
            @csrf
            @method('PATCH')
            <button type="submit" class="bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400 border border-red-200 dark:border-red-800 px-4 py-2 rounded-lg text-sm font-medium hover:bg-red-100 dark:hover:bg-red-900/50 transition">
                {{ __('admin.cancel_ride') }}
            </button>
        </form>
    @endif
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Overview Card -->
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 col-span-1 transition-colors">
        <h3 class="font-bold text-gray-800 dark:text-gray-100 mb-4 border-b border-gray-100 dark:border-slate-700 pb-2">{{ __('admin.overview') }}</h3>
        
        <div class="space-y-4">
            <div class="flex justify-between">
                <span class="text-gray-500 dark:text-gray-400 text-sm">{{ __('admin.status') }}</span>
                @if($ride->status == 'COMPLETED')
                    <span class="bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400 text-xs px-2 py-1 rounded-full font-medium">{{ __('admin.completed') }}</span>
                @elseif($ride->status == 'CANCELLED')
                    <span class="bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-400 text-xs px-2 py-1 rounded-full font-medium">{{ __('admin.cancelled') }}</span>
                @else
                    <span class="bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-400 text-xs px-2 py-1 rounded-full font-medium">{{ __('admin.pending') }}</span>
                @endif
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500 dark:text-gray-400 text-sm">{{ __('admin.created_at') }}</span>
                <span class="text-gray-900 dark:text-gray-200 text-sm font-medium">{{ $ride->created_at->format('M d, Y H:i') }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500 dark:text-gray-400 text-sm">{{ __('admin.distance') }}</span>
                <span class="text-gray-900 dark:text-gray-200 text-sm font-medium">{{ number_format($ride->distance_km, 1) }} km</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500 dark:text-gray-400 text-sm">{{ __('admin.tier') }}</span>
                <span class="text-gray-900 dark:text-gray-200 text-sm font-medium">{{ ucfirst($ride->tier) }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500 dark:text-gray-400 text-sm">{{ __('admin.estimated_fare') }}</span>
                <span class="text-gray-900 dark:text-gray-200 text-sm font-medium">EGP {{ number_format($ride->estimated_fare, 2) }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500 dark:text-gray-400 text-sm">{{ __('admin.actual_fare') }}</span>
                <span class="text-gray-900 dark:text-gray-200 text-sm font-medium">EGP {{ number_format($ride->actual_fare, 2) }}</span>
            </div>
        </div>
    </div>

    <!-- Participants & Route -->
    <div class="col-span-1 lg:col-span-2 space-y-6">
        
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 transition-colors">
            <h3 class="font-bold text-gray-800 dark:text-gray-100 mb-4 border-b border-gray-100 dark:border-slate-700 pb-2">{{ __('admin.participants') }}</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-slate-900 rounded-lg border border-gray-100 dark:border-slate-700">
                    <div class="w-10 h-10 rounded-full bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 flex items-center justify-center font-bold">
                        {{ $ride->rider ? strtoupper(substr($ride->rider->name, 0, 1)) : '?' }}
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('admin.rider') }}</p>
                        <p class="font-medium text-gray-900 dark:text-white">{{ $ride->rider->name ?? __('admin.not_available') }}</p>
                        @if($ride->rider)
                            <a href="{{ url('/admin/users/'.$ride->rider->id) }}" class="text-xs text-indigo-600 dark:text-indigo-400 hover:underline">{{ __('admin.view_details') }}</a>
                        @endif
                    </div>
                </div>

                <div class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-slate-900 rounded-lg border border-gray-100 dark:border-slate-700">
                    <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center font-bold">
                        {{ $ride->driver ? strtoupper(substr($ride->driver->name, 0, 1)) : '?' }}
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('admin.driver') }}</p>
                        <p class="font-medium text-gray-900 dark:text-white">{{ $ride->driver->name ?? __('admin.unassigned') }}</p>
                        @if($ride->driver)
                            <a href="{{ url('/admin/users/'.$ride->driver->id) }}" class="text-xs text-indigo-600 dark:text-indigo-400 hover:underline">{{ __('admin.view_details') }}</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 transition-colors">
            <h3 class="font-bold text-gray-800 dark:text-gray-100 mb-4 border-b border-gray-100 dark:border-slate-700 pb-2">{{ __('admin.route_details') }}</h3>
            
            <div class="relative pl-6 space-y-6 before:absolute before:inset-y-0 before:left-2.5 before:w-0.5 before:bg-gray-200 dark:before:bg-slate-700 before:z-0">
                <div class="relative z-10 flex gap-4">
                    <div class="w-5 h-5 rounded-full bg-green-500 border-4 border-white dark:border-slate-800 flex-shrink-0 -ml-8 mt-0.5"></div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('admin.pickup_location') }}</p>
                        <p class="text-gray-900 dark:text-white mt-1">{{ $ride->pickup_address ?? __('admin.address_not_available') }}</p>
                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">{{ $ride->pickup_lat }}, {{ $ride->pickup_lng }}</p>
                    </div>
                </div>
                
                <div class="relative z-10 flex gap-4">
                    <div class="w-5 h-5 rounded-full bg-red-500 border-4 border-white dark:border-slate-800 flex-shrink-0 -ml-8 mt-0.5"></div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('admin.dropoff_location') }}</p>
                        <p class="text-gray-900 dark:text-white mt-1">{{ $ride->dropoff_address ?? __('admin.address_not_available') }}</p>
                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">{{ $ride->dropoff_lat }}, {{ $ride->dropoff_lng }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
