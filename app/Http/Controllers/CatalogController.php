<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Dish;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CatalogController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q', ''));
        $restaurantId = $request->integer('restaurant_id');
        $categoryId = $request->integer('category_id');
        $priceFrom = $request->query('price_from');
        $priceTo = $request->query('price_to');
        $sort = (string) $request->query('sort', 'popular');

        $restaurants = Restaurant::query()
            ->active()
            ->orderBy('name')
            ->get();

        $categories = Category::query()
            ->when($restaurantId, fn ($query) => $query->where('restaurant_id', $restaurantId))
            ->orderBy('name')
            ->get();

        $dishesQuery = Dish::query()
            ->available()
            ->with(['restaurant', 'category'])
            ->when($restaurantId, fn ($query) => $query->where('restaurant_id', $restaurantId))
            ->when($categoryId, fn ($query) => $query->where('category_id', $categoryId))
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($searchQuery) use ($search): void {
                    $searchQuery
                        ->where('name', 'like', '%' . $search . '%')
                        ->orWhere('description', 'like', '%' . $search . '%')
                        ->orWhereHas('restaurant', fn ($restaurantQuery) => $restaurantQuery->where('name', 'like', '%' . $search . '%'));
                });
            })
            ->when(is_numeric($priceFrom), fn ($query) => $query->where('price', '>=', (float) $priceFrom))
            ->when(is_numeric($priceTo), fn ($query) => $query->where('price', '<=', (float) $priceTo));

        if ($sort === 'price_asc') {
            $dishesQuery->orderBy('price');
        } elseif ($sort === 'price_desc') {
            $dishesQuery->orderByDesc('price');
        } elseif ($sort === 'new') {
            $dishesQuery->orderByDesc('id');
        } else {
            $dishesQuery->orderByDesc('id');
        }

        $dishes = $dishesQuery->get();

        return view('catalog.index', [
            'dishes' => $dishes,
            'restaurants' => $restaurants,
            'categories' => $categories,
            'filters' => [
                'q' => $search,
                'restaurant_id' => $restaurantId ?: null,
                'category_id' => $categoryId ?: null,
                'price_from' => $priceFrom,
                'price_to' => $priceTo,
                'sort' => $sort,
            ],
        ]);
    }
}
