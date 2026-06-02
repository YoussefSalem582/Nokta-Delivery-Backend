@extends('layouts.admin')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ __('admin.overview') }}</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('admin.welcome_back') }}</p>
    </div>
    
    <form action="{{ url('/admin/export') }}" method="POST">
        @csrf
        <button type="submit" class="bg-primary hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition flex items-center gap-2 shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
            {{ __('admin.export') }}
        </button>
    </form>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <!-- Users Card -->
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 flex items-center justify-between transition-colors">
        <div>
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('admin.total_users') }}</p>
            <h3 class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ number_format($usersCount) }}</h3>
            <p class="text-sm mt-2 {{ $usersTrend > 0 ? 'text-green-600 dark:text-green-400' : 'text-gray-500 dark:text-gray-400' }}">
                @if($usersTrend > 0)
                    <span class="flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                        {{ $usersTrend }}% {{ __('admin.from_last_month') }}
                    </span>
                @else
                    <span>0% {{ __('admin.from_last_month') }}</span>
                @endif
            </p>
        </div>
        <div class="w-14 h-14 rounded-full bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
        </div>
    </div>

    <!-- Rides Card -->
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 flex items-center justify-between transition-colors">
        <div>
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('admin.total_rides') }}</p>
            <h3 class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ number_format($ridesCount) }}</h3>
            <p class="text-sm mt-2 {{ $ridesTrend > 0 ? 'text-green-600 dark:text-green-400' : 'text-gray-500 dark:text-gray-400' }}">
                @if($ridesTrend > 0)
                    <span class="flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                        {{ $ridesTrend }}% {{ __('admin.from_last_month') }}
                    </span>
                @else
                    <span>0% {{ __('admin.from_last_month') }}</span>
                @endif
            </p>
        </div>
        <div class="w-14 h-14 rounded-full bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600 dark:text-indigo-400">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
        </div>
    </div>

    <!-- Deliveries Card -->
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 flex items-center justify-between transition-colors">
        <div>
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('admin.total_deliveries') }}</p>
            <h3 class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ number_format($deliveriesCount) }}</h3>
            <p class="text-sm mt-2 {{ $deliveriesTrend > 0 ? 'text-green-600 dark:text-green-400' : 'text-gray-500 dark:text-gray-400' }}">
                @if($deliveriesTrend > 0)
                    <span class="flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                        {{ $deliveriesTrend }}% {{ __('admin.from_last_month') }}
                    </span>
                @else
                    <span>0% {{ __('admin.from_last_month') }}</span>
                @endif
            </p>
        </div>
        <div class="w-14 h-14 rounded-full bg-purple-50 dark:bg-purple-900/30 flex items-center justify-center text-purple-600 dark:text-purple-400">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
        </div>
    </div>
</div>

<!-- Chart Section -->
<div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 mb-6 transition-colors">
    <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-4">{{ __('admin.activity_overview') }}</h3>
    <div class="w-full h-72">
        <canvas id="activityChart"></canvas>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Rides -->
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden transition-colors">
        <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 flex justify-between items-center bg-gray-50 dark:bg-slate-800/50">
            <h3 class="font-bold text-gray-800 dark:text-gray-100">{{ __('admin.recent_rides') }}</h3>
            <a href="{{ url('/admin/rides') }}" class="text-sm text-primary hover:text-indigo-700 dark:hover:text-indigo-400 font-medium">{{ __('admin.view_all') }} &rarr;</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600 dark:text-gray-300">
                <thead class="bg-gray-50 dark:bg-slate-800/50 text-gray-500 dark:text-gray-400 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-3">{{ __('admin.id') }}</th>
                        <th class="px-6 py-3">{{ __('admin.rider_driver') }}</th>
                        <th class="px-6 py-3">{{ __('admin.status') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                    @forelse($recentRides as $ride)
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/50 cursor-pointer transition" onclick="window.location='{{ url('/admin/rides/'.$ride->id) }}'">
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">#{{ substr($ride->id, 0, 8) }}</td>
                        <td class="px-6 py-4">
                            <div><span class="font-medium text-gray-800 dark:text-gray-200">{{ $ride->rider->name ?? __('admin.not_available') }}</span></div>
                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $ride->driver->name ?? __('admin.pending') }}</div>
                        </td>
                        <td class="px-6 py-4">
                            @if($ride->status == 'COMPLETED')
                                <span class="bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400 text-xs px-2 py-1 rounded-full font-medium">{{ __('admin.completed') }}</span>
                            @elseif($ride->status == 'CANCELLED')
                                <span class="bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-400 text-xs px-2 py-1 rounded-full font-medium">{{ __('admin.cancelled') }}</span>
                            @else
                                <span class="bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-400 text-xs px-2 py-1 rounded-full font-medium">{{ __('admin.pending') }}</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">{{ __('admin.no_rides_found') }}</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Recent Deliveries -->
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden transition-colors">
        <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 flex justify-between items-center bg-gray-50 dark:bg-slate-800/50">
            <h3 class="font-bold text-gray-800 dark:text-gray-100">{{ __('admin.recent_deliveries') }}</h3>
            <a href="{{ url('/admin/deliveries') }}" class="text-sm text-primary hover:text-indigo-700 dark:hover:text-indigo-400 font-medium">{{ __('admin.view_all') }} &rarr;</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600 dark:text-gray-300">
                <thead class="bg-gray-50 dark:bg-slate-800/50 text-gray-500 dark:text-gray-400 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-3">{{ __('admin.id') }}</th>
                        <th class="px-6 py-3">{{ __('admin.sender_courier') }}</th>
                        <th class="px-6 py-3">{{ __('admin.status') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                    @forelse($recentDeliveries as $delivery)
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/50 cursor-pointer transition" onclick="window.location='{{ url('/admin/deliveries/'.$delivery->id) }}'">
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">#{{ substr($delivery->id, 0, 8) }}</td>
                        <td class="px-6 py-4">
                            <div><span class="font-medium text-gray-800 dark:text-gray-200">{{ $delivery->sender->name ?? __('admin.not_available') }}</span></div>
                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $delivery->courier->name ?? __('admin.pending') }}</div>
                        </td>
                        <td class="px-6 py-4">
                            @if($delivery->status == 'COMPLETED')
                                <span class="bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400 text-xs px-2 py-1 rounded-full font-medium">{{ __('admin.completed') }}</span>
                            @elseif($delivery->status == 'CANCELLED')
                                <span class="bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-400 text-xs px-2 py-1 rounded-full font-medium">{{ __('admin.cancelled') }}</span>
                            @else
                                <span class="bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-400 text-xs px-2 py-1 rounded-full font-medium">{{ __('admin.pending') }}</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">{{ __('admin.no_deliveries_found') }}</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('activityChart').getContext('2d');
        const isDark = document.documentElement.classList.contains('dark');
        const textColor = isDark ? '#9ca3af' : '#6b7280';
        const gridColor = isDark ? '#374151' : '#f3f4f6';

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($chartLabels) !!},
                datasets: [
                    {
                        label: '{{ __("admin.rides") }}',
                        data: {!! json_encode($ridesData) !!},
                        borderColor: '#4f46e5',
                        backgroundColor: 'rgba(79, 70, 229, 0.1)',
                        borderWidth: 2,
                        tension: 0.4,
                        fill: true
                    },
                    {
                        label: '{{ __("admin.deliveries") }}',
                        data: {!! json_encode($deliveriesData) !!},
                        borderColor: '#8b5cf6',
                        backgroundColor: 'rgba(139, 92, 246, 0.1)',
                        borderWidth: 2,
                        tension: 0.4,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: { color: textColor }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: gridColor },
                        ticks: { color: textColor }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: textColor }
                    }
                }
            }
        });
    });
</script>
@endsection
