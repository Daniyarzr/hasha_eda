<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateCheckoutData($request);
        $user = $request->user();
        $cartItems = $user->cartItems()->with('dish.restaurant')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Корзина пуста.');
        }

        $itemsByRestaurant = $this->groupItemsByRestaurant($cartItems);

        if ($itemsByRestaurant->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Не удалось оформить заказ: блюда недоступны.');
        }

        DB::transaction(function () use ($user, $itemsByRestaurant, $validated, $cartItems): void {
            
            $this->createOrdersFromCart($user, $itemsByRestaurant, $validated);

          
            $this->updateUserContacts($user, $validated);

           
            $this->clearCart($cartItems);
        });

        return redirect()->route('account.index')->with('success', 'Заказ успешно оформлен.');
    }

    private function validateCheckoutData(Request $request): array
    {
        return $request->validate([
            'delivery_address' => ['required', 'string', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:50'],
            'comment' => ['nullable', 'string', 'max:1000'],
        ]);
    }

    private function groupItemsByRestaurant(Collection $cartItems): Collection
    {
        return $cartItems
            ->filter(fn (Cart $item) => $item->dish && $item->dish->restaurant)
            ->groupBy(fn (Cart $item) => $item->dish->restaurant->id);
    }

    private function createOrdersFromCart(User $user, Collection $itemsByRestaurant, array $validated): void
    {
        foreach ($itemsByRestaurant as $restaurantId => $restaurantItems) {
            $restaurant = $restaurantItems->first()->dish->restaurant;
            $deliveryFee = (float) $restaurant->delivery_fee;

            $subtotal = 0.0;
            foreach ($restaurantItems as $item) {
                $subtotal += (float) $item->price * $item->quantity;
            }

            $order = $this->createOrder(
                $user,
                (int) $restaurantId,
                $validated,
                $subtotal,
                $deliveryFee
            );

            $this->createOrderItems($order, $restaurantItems);
        }
    }

    private function createOrder(
        User $user,
        int $restaurantId,
        array $validated,
        float $subtotal,
        float $deliveryFee
    ): Order {
        return $user->orders()->create([
            'restaurant_id' => $restaurantId,
            'status' => 'new',
            'delivery_address' => $validated['delivery_address'],
            'customer_phone' => $validated['customer_phone'],
            'comment' => $validated['comment'] ?? null,
            'total_amount' => $subtotal + $deliveryFee,
            'delivery_fee' => $deliveryFee,
            'ordered_at' => now(),
        ]);
    }

    private function createOrderItems(Order $order, Collection $restaurantItems): void
    {
        foreach ($restaurantItems as $item) {
            $order->items()->create([
                'dish_id' => $item->dish_id,
                'dish_name' => $item->dish?->name ?? 'Неизвестное блюдо',
                'quantity' => $item->quantity,
                'price' => $item->price,
            ]);
        }
    }

    private function updateUserContacts(User $user, array $validated): void
    {
        $user->update([
            'phone' => $validated['customer_phone'],
            'default_address' => $validated['delivery_address'],
        ]);
    }

    private function clearCart(Collection $cartItems): void
    {
        Cart::query()->whereIn('id', $cartItems->pluck('id'))->delete();
    }
}
