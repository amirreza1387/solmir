<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TicketController extends Controller
{
    public function index(): Response
    {
        $tickets = Ticket::with('user')->withCount('replies')->latest()->paginate(15);

        return Inertia::render('Admin/Tickets/Index', [
            'tickets' => $tickets,
        ]);
    }

    public function show(Ticket $ticket): Response
    {
        $ticket->load(['user', 'replies' => fn ($query) => $query->oldest()->with('user:id,name,avatar,role')]);

        return Inertia::render('Admin/Tickets/Show', [
            'ticket' => $ticket,
        ]);
    }

    public function reply(Request $request, Ticket $ticket): RedirectResponse
    {
        $validated = $request->validate([
            'message' => ['required', 'string'],
        ], [
            'message.required' => 'متن پاسخ الزامی است.',
        ]);

        $ticket->replies()->create([
            'user_id' => auth()->id(),
            'message' => $validated['message'],
            'is_admin' => true,
        ]);

        if ($ticket->status !== 'closed') {
            $ticket->update(['status' => 'answered']);
        }

        return back()->with('success', 'پاسخ با موفقیت ارسال شد.');
    }

    public function updateStatus(Request $request, Ticket $ticket): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'string', 'in:open,in_progress,answered,closed'],
            'priority' => ['sometimes', 'required', 'string', 'in:low,medium,high,urgent'],
        ]);

        $ticket->update($validated);

        return back()->with('success', 'وضعیت تیکت با موفقیت بروزرسانی شد.');
    }

    public function destroy(Ticket $ticket): RedirectResponse
    {
        $ticket->delete();

        return redirect()->route('admin.tickets.index')->with('success', 'تیکت با موفقیت حذف شد.');
    }
}
