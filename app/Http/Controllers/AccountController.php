<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AccountController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user()->load([
            'orders.restaurant',
            'orders.items',
        ]);

        $orders = $user->orders()
            ->with(['restaurant', 'items'])
            ->latest()
            ->get();

        $totalSpent = $orders->sum('total_amount');

        return view('account.index', [
            'user' => $user,
            'orders' => $orders,
            'totalSpent' => $totalSpent,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'default_address' => ['nullable', 'string', 'max:255'],
        ]);

        $request->user()->update($validated);

        return back()->with('success', 'Профиль обновлён.');
    }
}
