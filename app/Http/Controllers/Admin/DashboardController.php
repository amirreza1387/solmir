<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Order;
use App\Models\Ticket;
use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/Dashboard', [
            'usersCount' => User::count(),
            'ordersCount' => Order::count(),
            'openTicketsCount' => Ticket::where('status', '!=', 'closed')->count(),
            'unreadContactsCount' => Contact::where('is_read', false)->count(),
            'latestOrders' => Order::with('user')->latest()->take(5)->get(),
            'latestTickets' => Ticket::with('user')->latest()->take(5)->get(),
        ]);
    }
}
