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

        $recentRides = Ride::with(['rider', 'driver'])->latest()->take(5)->get();
        $recentDeliveries = Delivery::with(['sender', 'courier'])->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'usersCount',
            'ridesCount',
            'deliveriesCount',
            'recentRides',
            'recentDeliveries'
        ));
    }

    /**
     * Show all users.
     */
    public function users()
    {
        $users = User::latest()->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show all rides.
     */
    public function rides()
    {
        $rides = Ride::with(['rider', 'driver'])->latest()->paginate(15);
        return view('admin.rides.index', compact('rides'));
    }

    /**
     * Show all deliveries.
     */
    public function deliveries()
    {
        $deliveries = Delivery::with(['sender', 'courier'])->latest()->paginate(15);
        return view('admin.deliveries.index', compact('deliveries'));
    }
}
