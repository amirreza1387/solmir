<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(Request $request): Response
    {
        $userId = $request->user()->id;

        return Inertia::render('Dashboard/Index', [
            'stats' => [
                'activeOrders' => Order::where('user_id', $userId)
                    ->whereNotIn('status', ['completed', 'cancelled'])
                    ->count(),
                'totalOrders' => Order::where('user_id', $userId)->count(),
                'openTickets' => Ticket::where('user_id', $userId)
                    ->whereNotIn('status', ['closed'])
                    ->count(),
                'totalTickets' => Ticket::where('user_id', $userId)->count(),
            ],
            'latestOrders' => Order::where('user_id', $userId)->latest()->limit(5)->get(),
            'latestTickets' => Ticket::where('user_id', $userId)->latest()->limit(5)->get(),
        ]);
    }
}
