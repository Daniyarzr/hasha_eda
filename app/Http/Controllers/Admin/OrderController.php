<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class OrderController extends Controller
{
    private const STATUSES = ['new', 'processing', 'delivered', 'cancelled'];

    public function index(): View
    {
        $orders = Order::query()
            ->with(['user', 'restaurant'])
            ->withCount('items')
            ->latest()
            ->get();

        return view('admin.orders.index', [
            'orders' => $orders,
        ]);
    }

    public function create(): View
    {
        return view('admin.orders.create', [
            'order' => new Order([
                'status' => 'new',
                'total_amount' => 0,
                'delivery_fee' => 0,
                'ordered_at' => now(),
            ]),
            'users' => User::query()->orderBy('name')->get(['id', 'name', 'email']),
            'restaurants' => Restaurant::query()->orderBy('name')->get(['id', 'name']),
            'statuses' => self::STATUSES,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $payload = $this->validatedPayload($request);
        Order::query()->create($payload);

        return redirect()->route('admin.orders.index')->with('success', 'Заказ добавлен.');
    }

    public function show(Order $order): View
    {
        $order->load(['user', 'restaurant', 'items', 'review']);

        return view('admin.orders.show', [
            'order' => $order,
        ]);
    }

    public function edit(Order $order): View
    {
        return view('admin.orders.edit', [
            'order' => $order,
            'users' => User::query()->orderBy('name')->get(['id', 'name', 'email']),
            'restaurants' => Restaurant::query()->orderBy('name')->get(['id', 'name']),
            'statuses' => self::STATUSES,
        ]);
    }

    public function update(Request $request, Order $order): RedirectResponse
    {
        $payload = $this->validatedPayload($request, $order);
        $order->update($payload);

        return redirect()->route('admin.orders.show', $order)->with('success', 'Заказ обновлён.');
    }

    public function destroy(Order $order): RedirectResponse
    {
        $order->delete();

        return redirect()->route('admin.orders.index')->with('success', 'Заказ удалён.');
    }

    private function validatedPayload(Request $request, ?Order $order = null): array
    {
        $validated = $request->validate([
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'restaurant_id' => ['required', 'integer', 'exists:restaurants,id'],
            'status' => ['required', 'string', Rule::in(self::STATUSES)],
            'delivery_address' => ['required', 'string', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:50'],
            'comment' => ['nullable', 'string', 'max:1000'],
            'total_amount' => ['required', 'numeric', 'min:0'],
            'delivery_fee' => ['required', 'numeric', 'min:0'],
            'ordered_at' => ['nullable', 'date'],
        ]);

        $validated['ordered_at'] = $validated['ordered_at'] ?? $order?->ordered_at ?? now();

        return $validated;
    }
}
