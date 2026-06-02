<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Delivery;
use App\Models\Ride;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show the main admin dashboard.
     */
    public function index()
    {
        $usersCount = User::count();
        $ridesCount = Ride::count();
        $deliveriesCount = Delivery::count();

        // Trends: Last 30 days vs Previous 30 days
        $usersLastMonth = User::whereBetween('created_at', [now()->subDays(60), now()->subDays(30)])->count();
        $usersThisMonth = User::where('created_at', '>=', now()->subDays(30))->count();
        $usersTrend = $usersLastMonth > 0 ? round((($usersThisMonth - $usersLastMonth) / $usersLastMonth) * 100) : ($usersThisMonth > 0 ? 100 : 0);

        $ridesLastMonth = Ride::whereBetween('created_at', [now()->subDays(60), now()->subDays(30)])->count();
        $ridesThisMonth = Ride::where('created_at', '>=', now()->subDays(30))->count();
        $ridesTrend = $ridesLastMonth > 0 ? round((($ridesThisMonth - $ridesLastMonth) / $ridesLastMonth) * 100) : ($ridesThisMonth > 0 ? 100 : 0);

        $deliveriesLastMonth = Delivery::whereBetween('created_at', [now()->subDays(60), now()->subDays(30)])->count();
        $deliveriesThisMonth = Delivery::where('created_at', '>=', now()->subDays(30))->count();
        $deliveriesTrend = $deliveriesLastMonth > 0 ? round((($deliveriesThisMonth - $deliveriesLastMonth) / $deliveriesLastMonth) * 100) : ($deliveriesThisMonth > 0 ? 100 : 0);

        $recentRides = Ride::with(['rider', 'driver'])->latest()->take(5)->get();
        $recentDeliveries = Delivery::with(['sender', 'courier'])->latest()->take(5)->get();

        $startDate = now()->subDays(6)->startOfDay();

        // Get counts grouped by date
        $ridesByDate = Ride::where('created_at', '>=', $startDate)
            ->selectRaw('DATE(created_at) as date, count(*) as count')
            ->groupBy('date')
            ->pluck('count', 'date');

        $deliveriesByDate = Delivery::where('created_at', '>=', $startDate)
            ->selectRaw('DATE(created_at) as date, count(*) as count')
            ->groupBy('date')
            ->pluck('count', 'date');

        $chartLabels = [];
        $ridesData = [];
        $deliveriesData = [];

        // Build array ensuring all 7 days have a data point (even if 0)
        for ($i = 6; $i >= 0; $i--) {
            $dateObj = now()->subDays($i);
            $dateKey = $dateObj->format('Y-m-d');
            
            $chartLabels[] = $dateObj->format('M d');
            $ridesData[] = $ridesByDate->get($dateKey, 0);
            $deliveriesData[] = $deliveriesByDate->get($dateKey, 0);
        }

        return view('admin.dashboard', compact(
            'usersCount',
            'ridesCount',
            'deliveriesCount',
            'usersTrend',
            'ridesTrend',
            'deliveriesTrend',
            'recentRides',
            'recentDeliveries',
            'chartLabels',
            'ridesData',
            'deliveriesData'
        ));
    }

    /**
     * Show all users.
     */
    public function users(Request $request)
    {
        $query = User::latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('role', 'like', "%{$search}%");
        }

        $users = $query->paginate(15)->withQueryString();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show a single user.
     */
    public function showUser(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show all rides.
     */
    public function rides(Request $request)
    {
        $query = Ride::with(['rider', 'driver'])->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('id', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%")
                  ->orWhereHas('rider', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
        }

        $rides = $query->paginate(15)->withQueryString();
        return view('admin.rides.index', compact('rides'));
    }

    /**
     * Show a single ride.
     */
    public function showRide(Ride $ride)
    {
        $ride->load(['rider', 'driver']);
        return view('admin.rides.show', compact('ride'));
    }

    /**
     * Show all deliveries.
     */
    public function deliveries(Request $request)
    {
        $query = Delivery::with(['sender', 'courier'])->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('id', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%")
                  ->orWhereHas('sender', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
        }

        $deliveries = $query->paginate(15)->withQueryString();
        return view('admin.deliveries.index', compact('deliveries'));
    }

    /**
     * Show a single delivery.
     */
    public function showDelivery(Delivery $delivery)
    {
        $delivery->load(['sender', 'courier']);
        return view('admin.deliveries.show', compact('delivery'));
    }
}
