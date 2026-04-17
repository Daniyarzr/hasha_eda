<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Restaurant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(Request $request): View
    {
        $restaurantId = $request->integer('restaurant_id');
        $search = trim((string) $request->query('q', ''));

        $categories = Category::query()
            ->with(['restaurant'])
            ->withCount('dishes')
            ->when($restaurantId, fn ($query) => $query->where('restaurant_id', $restaurantId))
            ->when($search !== '', fn ($query) => $query->where('name', 'like', '%' . $search . '%'))
            ->orderBy('restaurant_id')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('admin.categories.index', [
            'categories' => $categories,
            'restaurants' => Restaurant::query()->orderBy('name')->get(),
            'restaurantId' => $restaurantId ?: null,
            'search' => $search,
        ]);
    }

    public function create(): View
    {
        return view('admin.categories.create', [
            'category' => new Category(),
            'restaurants' => Restaurant::query()->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $payload = $this->validatedPayload($request);
        Category::query()->create($payload);

        return redirect()->route('admin.categories.index')->with('success', 'Категория добавлена.');
    }

    public function show(Category $category): View
    {
        $category->load(['restaurant', 'dishes']);

        return view('admin.categories.show', [
            'category' => $category,
        ]);
    }

    public function edit(Category $category): View
    {
        return view('admin.categories.edit', [
            'category' => $category,
            'restaurants' => Restaurant::query()->orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $payload = $this->validatedPayload($request, $category);
        $category->update($payload);

        return redirect()->route('admin.categories.index')->with('success', 'Категория обновлена.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Категория удалена.');
    }

    private function validatedPayload(Request $request, ?Category $category = null): array
    {
        $id = $category?->id;
        $restaurantId = (int) $request->input('restaurant_id');

        $validated = $request->validate([
            'restaurant_id' => ['required', 'integer', 'exists:restaurants,id'],
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('categories', 'slug')
                    ->where(fn ($query) => $query->where('restaurant_id', $restaurantId))
                    ->ignore($id),
            ],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
        ]);

        $validated['slug'] = $this->resolveSlug(
            $validated['slug'] ?: $validated['name'],
            $restaurantId,
            $id
        );
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        return $validated;
    }

    private function resolveSlug(string $source, int $restaurantId, ?int $ignoreId = null): string
    {
        $slug = Str::slug($source);
        if ($slug === '') {
            $slug = 'category';
        }

        $baseSlug = $slug;
        $counter = 1;

        while (
            Category::query()
                ->where('restaurant_id', $restaurantId)
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
