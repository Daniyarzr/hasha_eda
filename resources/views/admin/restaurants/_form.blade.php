<form method="POST" action="{{ $action }}" class="card" enctype="multipart/form-data">
    @csrf
    @isset($method)
        @method($method)
    @endisset

    <div class="form-grid form-grid-2">
        <div class="form-group">
            <label for="name">Название</label>
            <input id="name" type="text" name="name" required value="{{ old('name', $restaurant->name) }}">
        </div>

        <div class="form-group">
            <label for="slug">Slug (необязательно)</label>
            <input id="slug" type="text" name="slug" value="{{ old('slug', $restaurant->slug) }}">
        </div>

        <div class="form-group">
            <label for="cuisine">Кухня</label>
            <input id="cuisine" type="text" name="cuisine" required value="{{ old('cuisine', $restaurant->cuisine) }}">
        </div>

        <div class="form-group">
            <label for="rating">Рейтинг (0-5)</label>
            <input id="rating" type="number" min="0" max="5" step="0.1" name="rating" value="{{ old('rating', $restaurant->rating ?? 0) }}">
        </div>

        <div class="form-group">
            <label for="delivery_time">Время доставки, мин</label>
            <input id="delivery_time" type="number" min="10" max="180" name="delivery_time" required value="{{ old('delivery_time', $restaurant->delivery_time ?? 30) }}">
        </div>

        <div class="form-group">
            <label for="delivery_fee">Доставка, ₽</label>
            <input id="delivery_fee" type="number" min="0" step="0.01" name="delivery_fee" required value="{{ old('delivery_fee', $restaurant->delivery_fee ?? 0) }}">
        </div>

        <div class="form-group">
            <label for="min_order_amount">Мин. заказ, ₽</label>
            <input id="min_order_amount" type="number" min="0" step="0.01" name="min_order_amount" required value="{{ old('min_order_amount', $restaurant->min_order_amount ?? 0) }}">
        </div>

        <div class="form-group">
            <label for="image_file">Логотип (файл)</label>
            <input id="image_file" type="file" name="image_file" accept=".jpg,.jpeg,.png,.webp,.svg">
            @if($restaurant->image)
                <small class="help">Текущий файл: <code>{{ $restaurant->image }}</code></small>
            @endif
        </div>

        <div class="form-group form-span-2">
            <label for="address">Адрес</label>
            <input id="address" type="text" name="address" required value="{{ old('address', $restaurant->address) }}">
        </div>

        <div class="form-group form-span-2">
            <label for="description">Описание</label>
            <textarea id="description" name="description" required>{{ old('description', $restaurant->description) }}</textarea>
        </div>

        <div class="form-group form-span-2">
            <label class="checkbox-field">
                <input type="checkbox" name="is_active" value="1" @checked((bool) old('is_active', $restaurant->is_active ?? true))>
                Активный ресторан (виден в каталоге)
            </label>
        </div>
    </div>

    <div class="actions-row">
        <button type="submit" class="btn btn-primary">{{ $submitLabel }}</button>
        <a href="{{ route('admin.restaurants.index') }}" class="btn btn-ghost">Отмена</a>
    </div>
</form>
