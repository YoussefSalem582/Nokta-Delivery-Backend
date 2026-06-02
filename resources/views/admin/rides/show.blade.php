@extends('layouts.admin')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div class="flex items-center gap-4">
        <a href="{{ url('/admin/rides') }}" class="text-gray-500 hover:text-indigo-600 transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Ride Details</h2>
            <p class="text-sm text-gray-500">View detailed information about this ride.</p>
        </div>
    </div>
    <div class="flex gap-2">
        @if($ride->status !== 'COMPLETED' && $ride->status !== 'CANCELLED')
            <button class="bg-red-50 text-red-600 border border-red-100 px-4 py-2 rounded-lg shadow-sm hover:bg-red-100 transition">Cancel Ride</button>
        @endif
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6">
    <div class="p-6">
        <div class="flex flex-col md:flex-row justify-between items-start gap-4 mb-6 pb-6 border-b border-gray-100">
            <div>
                <h3 class="text-xl font-bold text-gray-900 mb-1">Ride #{{ $ride->id }}</h3>
                <p class="text-gray-500 text-sm">Created at {{ $ride->created_at->format('F d, Y H:i:s') }}</p>
            </div>
            <span class="px-3 py-1 text-sm font-medium rounded-full 
                {{ $ride->status === 'COMPLETED' ? 'bg-green-100 text-green-800' : 
                   ($ride->status === 'PENDING' ? 'bg-yellow-100 text-yellow-800' : 
                   'bg-gray-100 text-gray-800') }}">
                {{ $ride->status }}
            </span>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Rider & Driver Info -->
            <div>
                <h4 class="font-bold text-gray-800 mb-4 uppercase text-xs tracking-wider">Participants</h4>
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold">R</div>
                        <div>
                            <p class="text-sm text-gray-500">Rider</p>
                            <p class="font-medium text-gray-900">
                                @if($ride->rider)
                                    <a href="{{ url('/admin/users/' . $ride->rider->id) }}" class="text-indigo-600 hover:underline">{{ $ride->rider->name }}</a>
                                @else
                                    N/A
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold">D</div>
                        <div>
                            <p class="text-sm text-gray-500">Driver</p>
                            <p class="font-medium text-gray-900">
                                @if($ride->driver)
                                    <a href="{{ url('/admin/users/' . $ride->driver->id) }}" class="text-indigo-600 hover:underline">{{ $ride->driver->name }}</a>
                                @else
                                    <span class="text-gray-400 italic">Unassigned</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Route Info -->
            <div>
                <h4 class="font-bold text-gray-800 mb-4 uppercase text-xs tracking-wider">Route Details</h4>
                <div class="relative pl-6 space-y-4">
                    <!-- A vertical line to connect the dots -->
                    <div class="absolute left-2.5 top-2 bottom-2 w-0.5 bg-gray-200"></div>
                    
                    <div class="relative">
                        <div class="absolute -left-6 top-1 w-3 h-3 rounded-full bg-blue-500 border-2 border-white"></div>
                        <p class="text-sm text-gray-500">Pickup Location</p>
                        <p class="font-medium text-gray-900">{{ $ride->pickup_address ?? 'Address not available' }}</p>
                    </div>
                    <div class="relative">
                        <div class="absolute -left-6 top-1 w-3 h-3 rounded-full bg-green-500 border-2 border-white"></div>
                        <p class="text-sm text-gray-500">Dropoff Location</p>
                        <p class="font-medium text-gray-900">{{ $ride->dropoff_address ?? 'Address not available' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 pt-6 mt-6 border-t border-gray-100">
            <div>
                <p class="text-sm text-gray-500 mb-1">Distance</p>
                <p class="font-medium text-gray-900">{{ $ride->distance_km ?? '0' }} km</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 mb-1">Estimated Fare</p>
                <p class="font-medium text-gray-900">{{ number_format($ride->estimated_fare ?? 0, 2) }} EGP</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 mb-1">Actual Fare</p>
                <p class="font-medium text-gray-900">{{ $ride->actual_fare ? number_format($ride->actual_fare, 2) . ' EGP' : 'Pending' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 mb-1">Tier</p>
                <p class="font-medium text-gray-900">{{ ucfirst($ride->tier ?? 'Economy') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
