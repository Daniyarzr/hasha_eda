<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class RestaurantController extends Controller
{
    public function index(): View
    {
        $restaurants = Restaurant::query()
            ->withCount(['dishes', 'orders'])
            ->orderByDesc('id')
            ->get();

        return view('admin.restaurants.index', [
            'restaurants' => $restaurants,
        ]);
    }

    public function create(): View
    {
        return view('admin.restaurants.create', [
            'restaurant' => new Restaurant(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $payload = $this->validatedPayload($request);
        Restaurant::query()->create($payload);

        return redirect()->route('admin.restaurants.index')->with('success', 'Ресторан добавлен.');
    }

    public function show(Restaurant $restaurant): View
    {
        $restaurant->loadCount(['dishes', 'orders', 'reviews']);

        return view('admin.restaurants.show', [
            'restaurant' => $restaurant,
        ]);
    }

    public function edit(Restaurant $restaurant): View
    {
        return view('admin.restaurants.edit', [
            'restaurant' => $restaurant,
        ]);
    }

    public function update(Request $request, Restaurant $restaurant): RedirectResponse
    {
        $payload = $this->validatedPayload($request, $restaurant);
        $restaurant->update($payload);

        return redirect()->route('admin.restaurants.index')->with('success', 'Ресторан обновлён.');
    }

    public function destroy(Restaurant $restaurant): RedirectResponse
    {
        $restaurant->delete();

        return redirect()->route('admin.restaurants.index')->with('success', 'Ресторан удалён.');
    }

    private function validatedPayload(Request $request, ?Restaurant $restaurant = null): array
    {
        $id = $restaurant?->id;

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('restaurants', 'slug')->ignore($id)],
            'description' => ['required', 'string', 'max:2000'],
            'cuisine' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'delivery_time' => ['required', 'integer', 'min:10', 'max:180'],
            'delivery_fee' => ['required', 'numeric', 'min:0'],
            'min_order_amount' => ['required', 'numeric', 'min:0'],
            'rating' => ['nullable', 'numeric', 'min:0', 'max:5'],
            'image' => ['nullable', 'string', 'max:255'],
            'image_file' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,svg', 'max:4096'],
        ]);

        $validated['slug'] = $this->resolveSlug($validated['slug'] ?: $validated['name'], $id);
        $validated['is_active'] = $request->boolean('is_active');
        $validated['rating'] = $validated['rating'] ?? 0;

        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $fileName = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/restaurants'), $fileName);
            $validated['image'] = '/images/restaurants/' . $fileName;
        }

        unset($validated['image_file']);

        return $validated;
    }

    private function resolveSlug(string $source, ?int $ignoreId = null): string
    {
        $slug = Str::slug($source);
        if ($slug === '') {
            $slug = 'restaurant';
        }

        $baseSlug = $slug;
        $counter = 1;

        while (
            Restaurant::query()
                ->where('slug', $slug)
                ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $counter++;
            $slug = $baseSlug . '-' . $counter;
        }

        return $slug;
    }
}
