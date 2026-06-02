<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nokta Admin Dashboard</title>
    <!-- Simple tailwind CDN for educational purposes -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans text-gray-900">

    <!-- Top Navigation -->
    <nav class="bg-blue-600 text-white p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-bold">Nokta Admin</h1>
            <div class="space-x-4">
                <a href="{{ url('/admin/dashboard') }}" class="hover:underline">Dashboard</a>
                <a href="{{ url('/admin/users') }}" class="hover:underline">Users</a>
                <a href="{{ url('/admin/rides') }}" class="hover:underline">Rides</a>
                <a href="{{ url('/admin/deliveries') }}" class="hover:underline">Deliveries</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container mx-auto p-4 mt-6">
        @yield('content')
    </main>

</body>
</html>
