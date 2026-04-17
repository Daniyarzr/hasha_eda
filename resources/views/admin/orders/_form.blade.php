<form method="POST" action="{{ $action }}" class="card">
    @csrf
    @isset($method)
        @method($method)
    @endisset

    <div class="form-grid form-grid-2">
        <div class="form-group">
            <label for="user_id">Пользователь</label>
            <select id="user_id" name="user_id" required>
                <option value="">Выберите пользователя</option>
                @foreach($users as $customer)
                    <option value="{{ $customer->id }}" @selected((int) old('user_id', $order->user_id) === $customer->id)>
                        #{{ $customer->id }} — {{ $customer->name }} ({{ $customer->email }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="restaurant_id">Ресторан</label>
            <select id="restaurant_id" name="restaurant_id" required>
                <option value="">Выберите ресторан</option>
                @foreach($restaurants as $restaurant)
                    <option value="{{ $restaurant->id }}" @selected((int) old('restaurant_id', $order->restaurant_id) === $restaurant->id)>
                        {{ $restaurant->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="status">Статус</label>
            <select id="status" name="status" required>
                @foreach($statuses as $statusOption)
                    @php
                        $label = match($statusOption) {
                            'processing' => 'В работе',
                            'delivered' => 'Доставлен',
                            'cancelled' => 'Отменен',
                            default => 'Новый',
                        };
                    @endphp
                    <option value="{{ $statusOption }}" @selected(old('status', $order->status) === $statusOption)>{{ $label }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="ordered_at">Дата и время</label>
            <input
                id="ordered_at"
                type="datetime-local"
                name="ordered_at"
                value="{{ old('ordered_at', optional($order->ordered_at)->format('Y-m-d\TH:i')) }}"
            >
        </div>

        <div class="form-group form-span-2">
            <label for="delivery_address">Адрес доставки</label>
            <input
                id="delivery_address"
                type="text"
                name="delivery_address"
                required
                value="{{ old('delivery_address', $order->delivery_address) }}"
            >
        </div>

        <div class="form-group">
            <label for="customer_phone">Телефон клиента</label>
            <input id="customer_phone" type="text" name="customer_phone" required value="{{ old('customer_phone', $order->customer_phone) }}">
        </div>

        <div class="form-group">
            <label for="delivery_fee">Доставка, ₽</label>
            <input
                id="delivery_fee"
                type="number"
                min="0"
                step="0.01"
                name="delivery_fee"
                required
                value="{{ old('delivery_fee', $order->delivery_fee ?? 0) }}"
            >
        </div>

        <div class="form-group">
            <label for="total_amount">Итого, ₽</label>
            <input
                id="total_amount"
                type="number"
                min="0"
                step="0.01"
                name="total_amount"
                required
                value="{{ old('total_amount', $order->total_amount ?? 0) }}"
            >
        </div>

        <div class="form-group form-span-2">
            <label for="comment">Комментарий</label>
            <textarea id="comment" name="comment">{{ old('comment', $order->comment) }}</textarea>
        </div>
    </div>

    <div class="actions-row">
        <button type="submit" class="btn btn-primary">{{ $submitLabel }}</button>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-ghost">Отмена</a>
    </div>
</form>

