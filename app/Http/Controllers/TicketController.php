<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTicketRequest;
use App\Models\Ticket;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;

class TicketController extends Controller
{
    public function index(Request $request): Response
    {
        $tickets = Ticket::forUser($request->user()->id)
            ->withCount('replies')
            ->latest()
            ->get();

        return Inertia::render('Dashboard/Tickets/Index', [
            'tickets' => $tickets,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Dashboard/Tickets/Create');
    }

    public function store(StoreTicketRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $ticket = $request->user()->tickets()->create([
            'title' => $validated['title'],
            'category' => $validated['category'],
            'priority' => $validated['priority'],
            'status' => 'open',
        ]);

        $ticket->replies()->create([
            'user_id' => $request->user()->id,
            'message' => $validated['message'],
            'is_admin' => false,
        ]);

        return redirect()->route('tickets.show', $ticket)->with('success', 'تیکت با موفقیت ثبت شد.');
    }

    public function show(Ticket $ticket): Response
    {
        Gate::authorize('view', $ticket);

        $ticket->load(['replies' => fn ($query) => $query->oldest()->with('user:id,name,avatar,role')]);

        return Inertia::render('Dashboard/Tickets/Show', [
            'ticket' => $ticket,
        ]);
    }

    public function reply(Request $request, Ticket $ticket): RedirectResponse
    {
        Gate::authorize('reply', $ticket);

        if ($ticket->status === 'closed') {
            return back()->with('error', 'این تیکت بسته شده است و امکان ارسال پاسخ وجود ندارد.');
        }

        $validated = $request->validate([
            'message' => ['required', 'string'],
        ], [
            'message.required' => 'متن پاسخ نمی‌تواند خالی باشد.',
        ]);

        $ticket->replies()->create([
            'user_id' => $request->user()->id,
            'message' => $validated['message'],
            'is_admin' => false,
        ]);

        if ($ticket->status === 'answered') {
            $ticket->update(['status' => 'in_progress']);
        }

        return redirect()->back()->with('success', 'پاسخ شما با موفقیت ارسال شد.');
    }
}
