<form method="POST" action="{{ $action }}" class="card" enctype="multipart/form-data">
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
                    <option value="{{ $restaurant->id }}" @selected((int) old('restaurant_id', $dish->restaurant_id) === $restaurant->id)>
                        {{ $restaurant->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="name">Название блюда</label>
            <input id="name" type="text" name="name" required value="{{ old('name', $dish->name) }}">
        </div>

        <div class="form-group">
            <label for="price">Цена, ₽</label>
            <input id="price" type="number" min="0" step="0.01" name="price" required value="{{ old('price', $dish->price) }}">
        </div>

        <div class="form-group">
            <label for="weight_grams">Вес, г</label>
            <input id="weight_grams" type="number" min="0" name="weight_grams" value="{{ old('weight_grams', $dish->weight_grams) }}">
        </div>

        <div class="form-group">
            <label for="image_file">Картинка (файл)</label>
            <input id="image_file" type="file" name="image_file" accept=".jpg,.jpeg,.png,.webp,.svg">
            @if($dish->image)
                <small class="help">Текущий файл: <code>{{ $dish->image }}</code></small>
            @endif
        </div>

        <div class="form-group form-span-2">
            <label for="description">Описание</label>
            <textarea id="description" name="description">{{ old('description', $dish->description) }}</textarea>
        </div>

        <div class="form-group form-span-2">
            <label class="checkbox-field">
                <input type="checkbox" name="is_available" value="1" @checked((bool) old('is_available', $dish->is_available ?? true))>
                Блюдо доступно для заказа
            </label>
        </div>
    </div>

    <div class="actions-row">
        <button type="submit" class="btn btn-primary">{{ $submitLabel }}</button>
        <a href="{{ route('admin.dishes.index') }}" class="btn btn-ghost">Отмена</a>
    </div>
</form>
