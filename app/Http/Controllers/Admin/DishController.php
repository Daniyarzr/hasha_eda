<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dish;
use App\Models\Restaurant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class DishController extends Controller
{
    public function index(): View
    {
        $dishes = Dish::query()
            ->with(['restaurant'])
            ->orderByDesc('id')
            ->get();

        return view('admin.dishes.index', [
            'dishes' => $dishes,
        ]);
    }

    public function create(): View
    {
        return view('admin.dishes.create', [
            'dish' => new Dish(),
            'restaurants' => Restaurant::query()->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $payload = $this->validatedPayload($request);
        Dish::query()->create($payload);

        return redirect()->route('admin.dishes.index')->with('success', 'Блюдо добавлено.');
    }

    public function show(Dish $dish): View
    {
        $dish->load(['restaurant']);

        return view('admin.dishes.show', [
            'dish' => $dish,
        ]);
    }

    public function edit(Dish $dish): View
    {
        return view('admin.dishes.edit', [
            'dish' => $dish,
            'restaurants' => Restaurant::query()->orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Dish $dish): RedirectResponse
    {
        $payload = $this->validatedPayload($request);
        $dish->update($payload);

        return redirect()->route('admin.dishes.index')->with('success', 'Блюдо обновлено.');
    }

    public function destroy(Dish $dish): RedirectResponse
    {
        $dish->delete();

        return redirect()->route('admin.dishes.index')->with('success', 'Блюдо удалено.');
    }

    private function validatedPayload(Request $request): array
    {
        $validated = $request->validate([
            'restaurant_id' => ['required', 'integer', 'exists:restaurants,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'price' => ['required', 'numeric', 'min:0'],
            'weight_grams' => ['nullable', 'integer', 'min:0'],
            'image' => ['nullable', 'string', 'max:255'],
            'image_file' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,svg', 'max:4096'],
        ]);

        $validated['is_available'] = $request->boolean('is_available');

        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $fileName = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/dishes'), $fileName);
            $validated['image'] = '/images/dishes/' . $fileName;
        }

        unset($validated['image_file']);

        return $validated;
    }
}
