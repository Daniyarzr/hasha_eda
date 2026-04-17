<?php

namespace App\Http\Controllers;

use App\Models\Dish;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        if (! $this->catalogTablesReady()) {
            return view('home', [
                'restaurants' => collect(),
                'featuredDishes' => collect(),
                'stats' => [
                    'restaurants' => 0,
                    'dishes' => 0,
                    'avgDelivery' => 0,
                ],
            ]);
        }

        $restaurants = Restaurant::query()
            ->active()
            ->withCount([
                'dishes as available_dishes_count' => fn ($query) => $query->where('is_available', true),
                'reviews',
            ])
            ->orderByDesc('rating')
            ->take(6)
            ->get();

        $featuredDishes = Dish::query()
            ->available()
            ->with('restaurant')
            ->orderByDesc('id')
            ->take(8)
            ->get();

        $stats = [
            'restaurants' => Restaurant::query()->where('is_active', true)->count(),
            'dishes' => Dish::query()->where('is_available', true)->count(),
            'avgDelivery' => (int) round(Restaurant::query()->where('is_active', true)->avg('delivery_time') ?? 0),
        ];

        return view('home', [
            'restaurants' => $restaurants,
            'featuredDishes' => $featuredDishes,
            'stats' => $stats,
        ]);
    }

    private function catalogTablesReady(): bool
    {
        return Schema::hasTable('restaurants')
            && Schema::hasTable('dishes');
    }
}
