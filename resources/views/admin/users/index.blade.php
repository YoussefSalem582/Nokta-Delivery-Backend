@extends('layouts.admin')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ __('admin.users_management') }}</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('admin.view_manage_users') }}</p>
    </div>
</div>

<div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden transition-colors">
    <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 bg-gray-50 dark:bg-slate-800/50 flex justify-between items-center">
        <form action="{{ url('/admin/users') }}" method="GET" class="w-full max-w-md flex items-center">
            <div class="relative w-full">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" class="bg-white dark:bg-slate-900 border border-gray-300 dark:border-slate-600 text-gray-900 dark:text-white text-sm rounded-lg focus:ring-primary focus:border-primary block w-full pl-10 p-2.5 transition-colors" placeholder="{{ __('admin.search_users') }}">
            </div>
            <button type="submit" class="ml-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg text-sm px-4 py-2.5">{{ __('admin.search') }}</button>
            @if(request('search'))
                <a href="{{ url('/admin/users') }}" class="ml-2 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 text-sm">{{ __('admin.clear') }}</a>
            @endif
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-gray-600 dark:text-gray-300">
            <thead class="bg-gray-50 dark:bg-slate-800/50 text-gray-500 dark:text-gray-400 uppercase text-xs">
                <tr>
                    <th class="px-6 py-4">{{ __('admin.user') }}</th>
                    <th class="px-6 py-4">{{ __('admin.role') }}</th>
                    <th class="px-6 py-4">{{ __('admin.status') }}</th>
                    <th class="px-6 py-4">{{ __('admin.joined') }}</th>
                    <th class="px-6 py-4 text-right">{{ __('admin.actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                @forelse($users as $user)
                <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/50 transition">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 flex items-center justify-center font-bold">
                                {{ strtoupper(substr($user->name, 0, 2)) }}
                            </div>
                            <div>
                                <div class="font-medium text-gray-900 dark:text-white">{{ $user->name }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">{{ $user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-400 text-xs px-2.5 py-1 rounded-full font-medium">{{ $user->role }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="flex items-center gap-1.5 text-green-600 dark:text-green-400 font-medium">
                            <span class="w-2 h-2 rounded-full bg-green-500"></span> {{ __('admin.active') }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-gray-500 dark:text-gray-400">
                        {{ $user->created_at->format('M d, Y') }}
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ url('/admin/users/'.$user->id) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300 font-medium">{{ __('admin.view_details') }}</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">{{ __('admin.no_users_found') }}</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($users->hasPages())
    <div class="px-6 py-4 border-t border-gray-100 dark:border-slate-700 bg-white dark:bg-slate-800">
        {{ $users->links() }}
    </div>
    @endif
</div>
@endsection
