@extends('layouts.admin')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Stat Cards -->
    <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-blue-500">
        <h3 class="text-gray-500 text-sm font-semibold uppercase">Total Users</h3>
        <p class="text-3xl font-bold text-gray-800">{{ $usersCount }}</p>
    </div>
    <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-green-500">
        <h3 class="text-gray-500 text-sm font-semibold uppercase">Total Rides</h3>
        <p class="text-3xl font-bold text-gray-800">{{ $ridesCount }}</p>
    </div>
    <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-purple-500">
        <h3 class="text-gray-500 text-sm font-semibold uppercase">Total Deliveries</h3>
        <p class="text-3xl font-bold text-gray-800">{{ $deliveriesCount }}</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Recent Rides -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-bold mb-4 border-b pb-2">Recent Rides</h2>
        @if($recentRides->count())
            <ul class="space-y-3">
                @foreach($recentRides as $ride)
                    <li class="border-b pb-2">
                        <span class="font-semibold">#{{ substr($ride->id, 0, 8) }}</span>
                        - <span class="bg-gray-200 text-gray-800 px-2 py-1 text-xs rounded">{{ $ride->status }}</span>
                        <div class="text-sm text-gray-600 mt-1">
                            Rider: {{ $ride->rider->name ?? 'N/A' }} | Driver: {{ $ride->driver->name ?? 'Pending' }}
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-500">No recent rides found.</p>
        @endif
        <div class="mt-4">
            <a href="{{ url('/admin/rides') }}" class="text-blue-500 hover:underline">View All Rides &rarr;</a>
        </div>
    </div>

    <!-- Recent Deliveries -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-bold mb-4 border-b pb-2">Recent Deliveries</h2>
        @if($recentDeliveries->count())
            <ul class="space-y-3">
                @foreach($recentDeliveries as $delivery)
                    <li class="border-b pb-2">
                        <span class="font-semibold">#{{ substr($delivery->id, 0, 8) }}</span>
                        - <span class="bg-gray-200 text-gray-800 px-2 py-1 text-xs rounded">{{ $delivery->status }}</span>
                        <div class="text-sm text-gray-600 mt-1">
                            Sender: {{ $delivery->sender->name ?? 'N/A' }} | Courier: {{ $delivery->courier->name ?? 'Pending' }}
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-500">No recent deliveries found.</p>
        @endif
        <div class="mt-4">
            <a href="{{ url('/admin/deliveries') }}" class="text-blue-500 hover:underline">View All Deliveries &rarr;</a>
        </div>
    </div>
</div>
@endsection
