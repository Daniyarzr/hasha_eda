<form method="POST" action="{{ $action }}" class="card">
    @csrf
    @isset($method)
        @method($method)
    @endisset

    <div class="form-grid form-grid-2">
        <div class="form-group">
            <label for="restaurant_id">Ресторан</label>
            <select id="restaurant_id" name="restaurant_id" required>
                <option value="">Выберите ресторан</option>
                @foreach($restaurants as $restaurant)
                    <option value="{{ $restaurant->id }}" @selected((int) old('restaurant_id', $category->restaurant_id) === $restaurant->id)>
                        {{ $restaurant->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="name">Название категории</label>
            <input id="name" type="text" name="name" required value="{{ old('name', $category->name) }}">
        </div>

        <div class="form-group">
            <label for="slug">Slug (необязательно)</label>
            <input id="slug" type="text" name="slug" value="{{ old('slug', $category->slug) }}">
        </div>

        <div class="form-group">
            <label for="sort_order">Порядок</label>
            <input id="sort_order" type="number" min="0" max="9999" name="sort_order" value="{{ old('sort_order', $category->sort_order ?? 0) }}">
        </div>
    </div>

    <div class="actions-row">
        <button type="submit" class="btn btn-primary">{{ $submitLabel }}</button>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-ghost">Отмена</a>
    </div>
</form>
