@extends('layouts.admin')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ __('admin.deliveries_management') }}</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('admin.view_track_deliveries') }}</p>
    </div>
</div>

<div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden transition-colors">
    <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 bg-gray-50 dark:bg-slate-800/50 flex justify-between items-center">
        <form action="{{ url('/admin/deliveries') }}" method="GET" class="w-full max-w-md flex items-center">
            <div class="relative w-full">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" class="bg-white dark:bg-slate-900 border border-gray-300 dark:border-slate-600 text-gray-900 dark:text-white text-sm rounded-lg focus:ring-primary focus:border-primary block w-full pl-10 p-2.5 transition-colors" placeholder="{{ __('admin.search_deliveries') }}">
            </div>
            <button type="submit" class="ml-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg text-sm px-4 py-2.5">{{ __('admin.search') }}</button>
            @if(request('search'))
                <a href="{{ url('/admin/deliveries') }}" class="ml-2 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 text-sm">{{ __('admin.clear') }}</a>
            @endif
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-gray-600 dark:text-gray-300">
            <thead class="bg-gray-50 dark:bg-slate-800/50 text-gray-500 dark:text-gray-400 uppercase text-xs">
                <tr>
                    <th class="px-6 py-4">{{ __('admin.id') }}</th>
                    <th class="px-6 py-4">{{ __('admin.sender') }}</th>
                    <th class="px-6 py-4">{{ __('admin.courier') }}</th>
                    <th class="px-6 py-4">{{ __('admin.status') }}</th>
                    <th class="px-6 py-4">{{ __('admin.date') }}</th>
                    <th class="px-6 py-4 text-right">{{ __('admin.actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                @forelse($deliveries as $delivery)
                <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/50 transition">
                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                        #{{ substr($delivery->id, 0, 8) }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $delivery->sender->name ?? __('admin.not_available') }}
                    </td>
                    <td class="px-6 py-4 text-gray-500 dark:text-gray-400">
                        {{ $delivery->courier->name ?? __('admin.pending') }}
                    </td>
                    <td class="px-6 py-4">
                        @if($delivery->status == 'COMPLETED')
                            <span class="bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400 text-xs px-2.5 py-1 rounded-full font-medium">{{ __('admin.completed') }}</span>
                        @elseif($delivery->status == 'CANCELLED')
                            <span class="bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-400 text-xs px-2.5 py-1 rounded-full font-medium">{{ __('admin.cancelled') }}</span>
                        @else
                            <span class="bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-400 text-xs px-2.5 py-1 rounded-full font-medium">{{ __('admin.pending') }}</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-gray-500 dark:text-gray-400">
                        {{ $delivery->created_at->format('M d, Y H:i') }}
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ url('/admin/deliveries/'.$delivery->id) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300 font-medium">{{ __('admin.view_details') }}</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">{{ __('admin.no_deliveries_found') }}</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($deliveries->hasPages())
    <div class="px-6 py-4 border-t border-gray-100 dark:border-slate-700 bg-white dark:bg-slate-800">
        {{ $deliveries->links() }}
    </div>
    @endif
</div>
@endsection
