@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ __('admin.my_profile') }}</h2>
    <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('admin.manage_account') }}</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <!-- Profile Card -->
    <div class="col-span-1">
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 text-center transition-colors">
            <div class="relative w-32 h-32 mx-auto mb-4">
                <img class="w-full h-full rounded-full border-4 border-indigo-50 dark:border-slate-700 shadow-sm" src="https://ui-avatars.com/api/?name=Admin+User&background=4f46e5&color=fff&size=256" alt="Admin Avatar">
                <button class="absolute bottom-0 right-0 bg-white dark:bg-slate-700 border border-gray-200 dark:border-slate-600 p-2 rounded-full shadow-sm hover:bg-gray-50 dark:hover:bg-slate-600 text-gray-600 dark:text-gray-300 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </button>
            </div>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white">Admin User</h3>
            <p class="text-indigo-600 dark:text-indigo-400 font-medium text-sm mb-4">{{ __('admin.super_admin') }}</p>
            <div class="border-t border-gray-100 dark:border-slate-700 pt-4 mt-4 flex justify-between text-sm">
                <span class="text-gray-500 dark:text-gray-400">{{ __('admin.status') }}</span>
                <span class="text-green-600 dark:text-green-400 font-medium flex items-center gap-1">
                    <span class="w-2 h-2 rounded-full bg-green-500"></span> {{ __('admin.active') }}
                </span>
            </div>
            <div class="flex justify-between text-sm mt-2">
                <span class="text-gray-500 dark:text-gray-400">{{ __('admin.joined') }}</span>
                <span class="text-gray-900 dark:text-gray-200 font-medium">May 2026</span>
            </div>
        </div>
    </div>

    <!-- Edit Form -->
    <div class="col-span-1 lg:col-span-2">
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden transition-colors">
            <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 bg-gray-50 dark:bg-slate-800/50">
                <h3 class="font-bold text-gray-800 dark:text-gray-100">{{ __('admin.personal_info') }}</h3>
            </div>
            <div class="p-6">
                <form action="{{ url('/admin/profile') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('admin.first_name') }}</label>
                            <input type="text" value="Admin" class="w-full bg-gray-50 dark:bg-slate-900 border border-gray-300 dark:border-slate-600 rounded-lg px-4 py-2 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" disabled>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('admin.last_name') }}</label>
                            <input type="text" value="User" class="w-full bg-gray-50 dark:bg-slate-900 border border-gray-300 dark:border-slate-600 rounded-lg px-4 py-2 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" disabled>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('admin.email_address') }}</label>
                            <input type="email" value="admin@noktadelivery.com" class="w-full bg-gray-50 dark:bg-slate-900 border border-gray-300 dark:border-slate-600 rounded-lg px-4 py-2 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" disabled>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('admin.phone') }}</label>
                            <input type="text" placeholder="+20 100 123 4567" class="w-full bg-white dark:bg-slate-900 border border-gray-300 dark:border-slate-600 rounded-lg px-4 py-2 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('admin.timezone') }}</label>
                            <select class="w-full bg-white dark:bg-slate-900 border border-gray-300 dark:border-slate-600 rounded-lg px-4 py-2 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
                                <option>Cairo (UTC+3)</option>
                                <option>UTC</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex justify-end pt-4 border-t border-gray-100 dark:border-slate-700">
                        <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg shadow-sm hover:bg-indigo-700 transition">
                            {{ __('admin.save_changes') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
