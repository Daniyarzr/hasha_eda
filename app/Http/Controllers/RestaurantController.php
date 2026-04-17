<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class RestaurantController extends Controller
{
    public function index(): View
    {
        if (! $this->catalogTablesReady()) {
            return view('restaurants.index', ['restaurants' => collect()]);
        }

        $restaurants = Restaurant::query()
            ->active()
            ->withCount([
                'dishes as available_dishes_count' => fn ($query) => $query->where('is_available', true),
                'reviews',
            ])
            ->orderByDesc('rating')
            ->orderBy('delivery_time')
            ->get();

        return view('restaurants.index', ['restaurants' => $restaurants]);
    }

    public function show(Restaurant $restaurant): View
    {
        if (! $this->catalogTablesReady()) {
            abort(404);
        }

        $restaurant->load([
            'categories' => fn ($query) => $query->orderBy('sort_order')->orderBy('name'),
            'dishes' => fn ($query) => $query->available()->orderBy('name'),
            'reviews' => fn ($query) => $query->latest(),
            'reviews.user',
        ]);

        return view('restaurants.show', ['restaurant' => $restaurant]);
    }

    private function catalogTablesReady(): bool
    {
        return Schema::hasTable('restaurants')
            && Schema::hasTable('categories')
            && Schema::hasTable('dishes')
            && Schema::hasTable('reviews');
    }
}
