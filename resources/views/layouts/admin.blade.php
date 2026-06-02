<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}" class="{{ session('theme', 'light') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nokta Admin Dashboard</title>
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/logo.svg') }}">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#4f46e5', // Indigo 600
                        sidebar: '#1e293b', // Slate 800
                    }
                }
            }
        }
    </script>
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-50 dark:bg-slate-900 text-gray-800 dark:text-gray-200 transition-colors duration-200">

    <div x-data="{ sidebarOpen: false, dropdownOpen: false }" class="flex h-screen overflow-hidden">
        
        <!-- Mobile Sidebar Overlay -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-20 bg-black bg-opacity-50 lg:hidden transition-opacity" style="display: none;"></div>

        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : (document.dir === 'rtl' ? 'translate-x-full' : '-translate-x-full')" class="fixed inset-y-0 z-30 w-64 bg-sidebar text-white transition-transform duration-300 lg:static lg:translate-x-0 flex flex-col ltr:left-0 rtl:right-0">
            <div class="flex items-center justify-center h-20 border-b border-gray-700 bg-white dark:bg-slate-800">
                <a href="{{ url('/admin/dashboard') }}" class="flex items-center justify-center w-full h-full p-4">
                    <img src="{{ asset('assets/logo.svg') }}" alt="Nokta Logo" class="h-10 w-auto object-contain">
                </a>
            </div>

            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                <a href="{{ url('/admin/dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->is('admin/dashboard') ? 'bg-primary text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white transition' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    {{ __('admin.dashboard') }}
                </a>
                
                <a href="{{ url('/admin/users') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->is('admin/users*') ? 'bg-primary text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white transition' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    {{ __('admin.users') }}
                </a>

                <a href="{{ url('/admin/rides') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->is('admin/rides*') ? 'bg-primary text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white transition' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    {{ __('admin.rides') }}
                </a>

                <a href="{{ url('/admin/deliveries') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->is('admin/deliveries*') ? 'bg-primary text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white transition' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    {{ __('admin.deliveries') }}
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="h-20 bg-white dark:bg-slate-800 border-b border-gray-200 dark:border-slate-700 flex items-center justify-between px-6 z-10 transition-colors">
                <button @click="sidebarOpen = true" class="text-gray-500 dark:text-gray-400 focus:outline-none lg:hidden">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                
                <div class="flex-1 flex justify-end items-center gap-4">
                    
                    <!-- Theme Toggle -->
                    <a href="{{ url('/admin/theme/' . (session('theme') == 'dark' ? 'light' : 'dark')) }}" class="p-2 rounded-full text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-slate-700 transition" title="{{ session('theme') == 'dark' ? __('admin.theme_light') : __('admin.theme_dark') }}">
                        @if(session('theme') == 'dark')
                            <!-- Sun icon -->
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        @else
                            <!-- Moon icon -->
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                        @endif
                    </a>

                    <!-- Language Toggle -->
                    <div class="relative" x-data="{ langOpen: false }">
                        <button @click="langOpen = !langOpen" class="flex items-center gap-2 p-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-700 transition font-medium">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path></svg>
                            {{ strtoupper(app()->getLocale()) }}
                        </button>
                        <div x-show="langOpen" @click.away="langOpen = false" class="absolute {{ app()->getLocale() == 'ar' ? 'left-0' : 'right-0' }} mt-2 w-32 bg-white dark:bg-slate-800 rounded-md shadow-lg py-1 z-50 border dark:border-slate-700" style="display: none;">
                            <a href="{{ url('/admin/locale/en') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-700 transition {{ app()->getLocale() == 'en' ? 'font-bold' : '' }}">English</a>
                            <a href="{{ url('/admin/locale/ar') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-700 transition {{ app()->getLocale() == 'ar' ? 'font-bold' : '' }}">العربية</a>
                        </div>
                    </div>

                    <div class="border-l border-gray-300 dark:border-slate-600 h-6 mx-2"></div>

                    <!-- Profile Dropdown -->
                    <div class="relative" x-data="{ dropdownOpen: false }">
                        <button @click="dropdownOpen = !dropdownOpen" class="flex items-center gap-3 focus:outline-none">
                            <div class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold">
                                AU
                            </div>
                            <div class="hidden md:block text-left {{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }}">
                                <p class="text-sm font-medium text-gray-700 dark:text-gray-200">Admin</p>
                            </div>
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        
                        <div x-show="dropdownOpen" @click.away="dropdownOpen = false" class="absolute {{ app()->getLocale() == 'ar' ? 'left-0' : 'right-0' }} mt-2 w-48 bg-white dark:bg-slate-800 rounded-md shadow-lg py-1 z-50 border dark:border-slate-700" style="display: none;">
                            <a href="{{ url('/admin/profile') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-700 transition">{{ __('admin.profile') }}</a>
                            <a href="{{ url('/admin/settings') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-700 transition">{{ __('admin.settings') }}</a>
                            <hr class="dark:border-slate-700">
                            <a href="{{ url('/admin/logout') }}" class="block px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-slate-700 transition">{{ __('admin.logout') }}</a>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main section -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 dark:bg-slate-900 transition-colors p-6">
                
                @if(session('success'))
                    <div class="mb-6 p-4 rounded-lg bg-green-50 dark:bg-green-900/30 text-green-700 dark:text-green-400 border border-green-200 dark:border-green-800 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ session('success') }}
                        </div>
                        <button onclick="this.parentElement.style.display='none'" class="text-green-700 dark:text-green-400 hover:text-green-900 dark:hover:text-green-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
