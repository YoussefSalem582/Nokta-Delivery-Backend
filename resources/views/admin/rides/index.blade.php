@extends('layouts.admin')

@section('content')
<div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Rides Management</h2>
        <p class="text-sm text-gray-500">View and track all ride activities.</p>
    </div>
    <form method="GET" action="{{ url('/admin/rides') }}" class="flex">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by ID or Rider..." class="border border-gray-300 rounded-l-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 w-64">
        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-r-lg hover:bg-indigo-700 transition">
            Search
        </button>
        @if(request('search'))
            <a href="{{ url('/admin/rides') }}" class="ml-2 text-gray-500 hover:text-gray-700 px-4 py-2 flex items-center">Clear</a>
        @endif
    </form>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b">
                <tr>
                    <th class="px-6 py-4">ID</th>
                    <th class="px-6 py-4">Rider</th>
                    <th class="px-6 py-4">Driver</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4">Date</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rides as $ride)
                    <tr class="bg-white border-b hover:bg-gray-50 transition">
                        <td class="px-6 py-4 font-medium text-gray-900">
                            #{{ substr($ride->id, 0, 8) }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $ride->rider->name ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 text-gray-500">
                            {{ $ride->driver->name ?? 'Pending' }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-1 text-xs font-medium rounded-full 
                                {{ $ride->status === 'COMPLETED' ? 'bg-green-100 text-green-800' : 
                                   ($ride->status === 'PENDING' ? 'bg-yellow-100 text-yellow-800' : 
                                   'bg-gray-100 text-gray-800') }}">
                                {{ $ride->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-500">
                            {{ $ride->created_at->format('M d, Y H:i') }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ url('/admin/rides/' . $ride->id) }}" class="text-indigo-600 hover:text-indigo-900 font-medium text-sm">View Details</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                            No rides found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($rides->hasPages())
        <div class="p-4 border-t border-gray-100 bg-gray-50">
            {{ $rides->links() }}
        </div>
    @endif
</div>
@endsection
