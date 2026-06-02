@extends('layouts.admin')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <h2 class="text-2xl font-bold mb-6 border-b pb-2">Users</h2>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100 text-gray-700">
                    <th class="p-3 border-b">ID</th>
                    <th class="p-3 border-b">Name</th>
                    <th class="p-3 border-b">Email</th>
                    <th class="p-3 border-b">Role</th>
                    <th class="p-3 border-b">Registered At</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr class="hover:bg-gray-50 border-b">
                    <td class="p-3 text-sm text-gray-500">{{ substr($user->id, 0, 8) }}</td>
                    <td class="p-3 font-semibold">{{ $user->name }}</td>
                    <td class="p-3">{{ $user->email }}</td>
                    <td class="p-3">
                        <span class="px-2 py-1 text-xs rounded bg-blue-100 text-blue-800">
                            {{ $user->role }}
                        </span>
                    </td>
                    <td class="p-3 text-sm text-gray-500">{{ $user->created_at->format('M d, Y H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $users->links() }}
    </div>
</div>
@endsection
