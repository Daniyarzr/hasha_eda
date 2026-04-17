<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Dish;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(Request $request): View
    {
        $items = $request->user()
            ->cartItems()
            ->with('dish.restaurant')
            ->orderByDesc('created_at')
            ->get();

        $subtotal = 0.0;
        foreach ($items as $item) {
            $subtotal += (float) $item->price * $item->quantity;
        }

        $restaurants = $items
            ->pluck('dish.restaurant')
            ->filter()
            ->unique('id');

        $deliveryFee = (float) $restaurants->sum('delivery_fee');

        return view('cart.index', [
            'items' => $items,
            'subtotal' => $subtotal,
            'deliveryFee' => $deliveryFee,
            'total' => $subtotal + $deliveryFee,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'dish_id' => ['required', 'integer', 'exists:dishes,id'],
            'quantity' => ['nullable', 'integer', 'min:1', 'max:20'],
        ]);

        $dish = Dish::query()->where('is_available', true)->findOrFail($validated['dish_id']);
        $quantity = $validated['quantity'] ?? 1;

        $item = Cart::query()->firstOrNew([
            'user_id' => $request->user()->id,
            'dish_id' => $dish->id,
        ]);

        $item->price = $dish->price;
        if ($item->exists) {
            $item->quantity = min(99, $item->quantity + $quantity);
        } else {
            $item->quantity = $quantity;
        }

        $item->save();

        return back()->with('success', 'Блюдо добавлено в корзину.');
    }

    public function update(Request $request, Cart $cart): RedirectResponse
    {
        $this->assertOwnership($request, $cart);

        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:99'],
        ]);

        $cart->update([
            'quantity' => $validated['quantity'],
            'price' => $cart->dish?->price ?? $cart->price,
        ]);

        return back()->with('success', 'Корзина обновлена.');
    }

    public function destroy(Request $request, Cart $cart): RedirectResponse
    {
        $this->assertOwnership($request, $cart);
        $cart->delete();

        return back()->with('success', 'Блюдо удалено из корзины.');
    }

    private function assertOwnership(Request $request, Cart $cart): void
    {
        if ($cart->user_id !== $request->user()->id) {
            abort(403);
        }
    }
}
