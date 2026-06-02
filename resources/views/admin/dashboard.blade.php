@extends('layouts.admin')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Dashboard Overview</h2>
        <p class="text-sm text-gray-500">Welcome back, here is what's happening today.</p>
    </div>
    <div class="flex space-x-3">
        <button class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg shadow-sm hover:bg-gray-50 flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            Export
        </button>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Stat Cards -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between hover:shadow-md transition">
        <div>
            <h3 class="text-gray-500 text-sm font-medium">Total Users</h3>
            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $usersCount }}</p>
            <p class="text-sm {{ $usersTrend >= 0 ? 'text-green-600' : 'text-red-600' }} mt-2 flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    @if($usersTrend >= 0)
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    @else
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0v-8m0 8l-8-8-4 4-6-6"></path>
                    @endif
                </svg>
                <span>{{ abs($usersTrend) }}% from last month</span>
            </p>
        </div>
        <div class="p-4 bg-indigo-50 rounded-full text-indigo-600">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
        </div>
    </div>
    
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between hover:shadow-md transition">
        <div>
            <h3 class="text-gray-500 text-sm font-medium">Total Rides</h3>
            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $ridesCount }}</p>
            <p class="text-sm {{ $ridesTrend >= 0 ? 'text-green-600' : 'text-red-600' }} mt-2 flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    @if($ridesTrend >= 0)
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    @else
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0v-8m0 8l-8-8-4 4-6-6"></path>
                    @endif
                </svg>
                <span>{{ abs($ridesTrend) }}% from last month</span>
            </p>
        </div>
        <div class="p-4 bg-blue-50 rounded-full text-blue-600">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between hover:shadow-md transition">
        <div>
            <h3 class="text-gray-500 text-sm font-medium">Total Deliveries</h3>
            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $deliveriesCount }}</p>
            <p class="text-sm {{ $deliveriesTrend >= 0 ? 'text-green-600' : 'text-red-600' }} mt-2 flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    @if($deliveriesTrend >= 0)
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    @else
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0v-8m0 8l-8-8-4 4-6-6"></path>
                    @endif
                </svg>
                <span>{{ abs($deliveriesTrend) }}% from last month</span>
            </p>
        </div>
        <div class="p-4 bg-purple-50 rounded-full text-purple-600">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
        </div>
    </div>
</div>

<!-- Chart Section -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
    <h2 class="text-lg font-bold mb-4 text-gray-800">Activity Overview (Last 7 Days)</h2>
    <div class="relative h-72 w-full">
        <canvas id="activityChart"></canvas>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Recent Rides -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
            <h2 class="text-lg font-bold text-gray-800">Recent Rides</h2>
            <a href="{{ url('/admin/rides') }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">View All</a>
        </div>
        <div class="p-0">
            @if($recentRides->count())
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs text-gray-500 uppercase bg-white border-b">
                            <tr>
                                <th class="px-6 py-3">ID</th>
                                <th class="px-6 py-3">Rider/Driver</th>
                                <th class="px-6 py-3">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentRides as $ride)
                                <tr class="bg-white border-b hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 font-medium text-gray-900">
                                        <a href="{{ url('/admin/rides/' . $ride->id) }}" class="text-indigo-600 hover:underline">#{{ substr($ride->id, 0, 8) }}</a>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-gray-900 font-medium">{{ $ride->rider->name ?? 'N/A' }}</div>
                                        <div class="text-gray-500 text-xs">{{ $ride->driver->name ?? 'Pending' }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2.5 py-1 text-xs font-medium rounded-full 
                                            {{ $ride->status === 'COMPLETED' ? 'bg-green-100 text-green-800' : 
                                               ($ride->status === 'PENDING' ? 'bg-yellow-100 text-yellow-800' : 
                                               'bg-gray-100 text-gray-800') }}">
                                            {{ $ride->status }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-6 text-center text-gray-500">No recent rides found.</div>
            @endif
        </div>
    </div>

    <!-- Recent Deliveries -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
            <h2 class="text-lg font-bold text-gray-800">Recent Deliveries</h2>
            <a href="{{ url('/admin/deliveries') }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">View All</a>
        </div>
        <div class="p-0">
            @if($recentDeliveries->count())
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs text-gray-500 uppercase bg-white border-b">
                            <tr>
                                <th class="px-6 py-3">ID</th>
                                <th class="px-6 py-3">Sender/Courier</th>
                                <th class="px-6 py-3">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentDeliveries as $delivery)
                                <tr class="bg-white border-b hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 font-medium text-gray-900">
                                        <a href="{{ url('/admin/deliveries/' . $delivery->id) }}" class="text-indigo-600 hover:underline">#{{ substr($delivery->id, 0, 8) }}</a>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-gray-900 font-medium">{{ $delivery->sender->name ?? 'N/A' }}</div>
                                        <div class="text-gray-500 text-xs">{{ $delivery->courier->name ?? 'Pending' }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2.5 py-1 text-xs font-medium rounded-full 
                                            {{ $delivery->status === 'COMPLETED' ? 'bg-green-100 text-green-800' : 
                                               ($delivery->status === 'PENDING' ? 'bg-yellow-100 text-yellow-800' : 
                                               'bg-gray-100 text-gray-800') }}">
                                            {{ $delivery->status }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-6 text-center text-gray-500">No recent deliveries found.</div>
            @endif
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('activityChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($chartLabels) !!},
                datasets: [
                    {
                        label: 'Rides',
                        data: {!! json_encode($ridesData) !!},
                        borderColor: '#4f46e5',
                        backgroundColor: 'rgba(79, 70, 229, 0.1)',
                        borderWidth: 2,
                        tension: 0.4,
                        fill: true
                    },
                    {
                        label: 'Deliveries',
                        data: {!! json_encode($deliveriesData) !!},
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
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
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#f3f4f6'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    });
</script>
@endsection
