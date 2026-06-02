@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ __('admin.system_settings') }}</h2>
    <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('admin.configure_global') }}</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-4 gap-6">
    
    <!-- Settings Navigation -->
    <div class="md:col-span-1">
        <nav class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 flex flex-col p-2 space-y-1 transition-colors">
            <a href="#" class="px-4 py-2 rounded-lg bg-indigo-50 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-400 font-medium flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                {{ __('admin.general') }}
            </a>
            <a href="#" class="px-4 py-2 rounded-lg text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-slate-700 hover:text-gray-900 dark:hover:text-gray-200 font-medium flex items-center gap-2 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                {{ __('admin.security') }}
            </a>
            <a href="#" class="px-4 py-2 rounded-lg text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-slate-700 hover:text-gray-900 dark:hover:text-gray-200 font-medium flex items-center gap-2 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                {{ __('admin.notifications') }}
            </a>
            <a href="#" class="px-4 py-2 rounded-lg text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-slate-700 hover:text-gray-900 dark:hover:text-gray-200 font-medium flex items-center gap-2 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                {{ __('admin.billing_tiers') }}
            </a>
        </nav>
    </div>

    <!-- Settings Content -->
    <div class="md:col-span-3 space-y-6">
        
        <!-- Platform Settings -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden transition-colors">
            <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 bg-gray-50 dark:bg-slate-800/50">
                <h3 class="font-bold text-gray-800 dark:text-gray-100">{{ __('admin.platform_configurations') }}</h3>
            </div>
            <div class="p-6">
                <div class="space-y-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-sm font-medium text-gray-900 dark:text-white">{{ __('admin.accept_new_drivers') }}</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('admin.allow_new_drivers') }}</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" value="" class="sr-only peer" checked>
                            <div class="w-11 h-6 bg-gray-200 dark:bg-slate-600 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                        </label>
                    </div>
                    
                    <div class="flex items-center justify-between pt-6 border-t border-gray-100 dark:border-slate-700">
                        <div>
                            <h4 class="text-sm font-medium text-gray-900 dark:text-white">{{ __('admin.maintenance_mode') }}</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('admin.temporarily_disable') }}</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" value="" class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 dark:bg-slate-600 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                        </label>
                    </div>

                    <div class="flex items-center justify-between pt-6 border-t border-gray-100 dark:border-slate-700">
                        <div>
                            <h4 class="text-sm font-medium text-gray-900 dark:text-white">{{ __('admin.surge_pricing') }}</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('admin.manually_trigger') }}</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" value="" class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 dark:bg-slate-600 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Localization Settings -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden transition-colors">
            <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 bg-gray-50 dark:bg-slate-800/50">
                <h3 class="font-bold text-gray-800 dark:text-gray-100">{{ __('admin.localization') }}</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('admin.default_language') }}</label>
                        <select class="w-full bg-white dark:bg-slate-900 border border-gray-300 dark:border-slate-600 rounded-lg px-4 py-2 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
                            <option>English</option>
                            <option>Arabic</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('admin.currency_format') }}</label>
                        <select class="w-full bg-white dark:bg-slate-900 border border-gray-300 dark:border-slate-600 rounded-lg px-4 py-2 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
                            <option>EGP (Egyptian Pound)</option>
                            <option>USD ($)</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <form action="{{ url('/admin/settings') }}" method="POST">
            @csrf
            <div class="flex justify-end">
                <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg shadow-sm hover:bg-indigo-700 transition">
                    {{ __('admin.save_all_settings') }}
                </button>
            </div>
        </form>

    </div>
</div>
@endsection
