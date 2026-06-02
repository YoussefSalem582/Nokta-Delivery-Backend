@extends('layouts.admin')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <h2 class="text-2xl font-bold mb-6 border-b pb-2">Rides</h2>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100 text-gray-700">
                    <th class="p-3 border-b">ID</th>
                    <th class="p-3 border-b">Rider</th>
                    <th class="p-3 border-b">Driver</th>
                    <th class="p-3 border-b">Status</th>
                    <th class="p-3 border-b">Fare</th>
                    <th class="p-3 border-b">Created At</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rides as $ride)
                <tr class="hover:bg-gray-50 border-b">
                    <td class="p-3 text-sm text-gray-500">{{ substr($ride->id, 0, 8) }}</td>
                    <td class="p-3 font-semibold">{{ $ride->rider->name ?? 'N/A' }}</td>
                    <td class="p-3">{{ $ride->driver->name ?? 'Pending' }}</td>
                    <td class="p-3">
                        <span class="px-2 py-1 text-xs rounded bg-green-100 text-green-800">
                            {{ $ride->status }}
                        </span>
                    </td>
                    <td class="p-3">${{ number_format($ride->estimated_fare, 2) }}</td>
                    <td class="p-3 text-sm text-gray-500">{{ $ride->created_at->format('M d, Y H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $rides->links() }}
    </div>
</div>
@endsection
