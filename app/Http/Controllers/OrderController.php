<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;
use App\Models\OrderAttachment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class OrderController extends Controller
{
    public function index(Request $request): Response
    {
        $orders = Order::forUser($request->user()->id)
            ->withCount('attachments')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Dashboard/Orders/Index', [
            'orders' => $orders,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Dashboard/Orders/Create');
    }

    public function store(StoreOrderRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $order = $request->user()->orders()->create([
            'title' => $validated['title'],
            'service_type' => $validated['service_type'],
            'description' => $validated['description'],
            'budget_range' => $validated['budget_range'] ?? null,
            'deadline' => $validated['deadline'] ?? null,
        ]);

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                // Store on private local disk rather than public
                $path = $file->store('order_attachments', 'local');
                $originalName = $file->getClientOriginalName();
                $cleanName = Str::substr(preg_replace('/[^\p{L}\p{N}_\-\.\s]/u', '', $originalName), 0, 150) ?: 'attachment';

                $order->attachments()->create([
                    'file_name' => $cleanName,
                    'file_path' => $path,
                    'file_size' => $file->getSize(),
                    'mime_type' => $file->getMimeType(),
                ]);
            }
        }

        return redirect()->route('orders.show', $order)->with('success', 'سفارش شما با موفقیت ثبت شد.');
    }

    public function show(Order $order): Response
    {
        Gate::authorize('view', $order);

        $order->load(['attachments' => fn ($q) => $q->select(['id', 'order_id', 'file_name', 'file_size', 'mime_type', 'created_at'])]);
        $order->makeHidden('admin_notes');

        return Inertia::render('Dashboard/Orders/Show', [
            'order' => $order,
        ]);
    }

    public function downloadAttachment(Order $order, OrderAttachment $attachment): StreamedResponse
    {
        Gate::authorize('view', $order);

        if ($attachment->order_id !== $order->id) {
            abort(404);
        }

        if (Storage::disk('local')->exists($attachment->file_path)) {
            return Storage::disk('local')->download($attachment->file_path, $attachment->file_name);
        }

        if (Storage::disk('public')->exists($attachment->file_path)) {
            return Storage::disk('public')->download($attachment->file_path, $attachment->file_name);
        }

        abort(404, 'فایل در سرور یافت نشد.');
    }
}
