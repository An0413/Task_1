@extends('layout.layout')

@section('content')
    <div class="container mt-4">
        <h3>Редактировать заказ</h3>
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <form action="{{ route('orders.update', $order->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="customer">Имя клиента</label>
                <input type="text" class="form-control" name="customer" value="{{ old('customer', $order->customer) }}" required>
            </div>

            <div class="form-group mt-3">
                <label>Товары</label>
                <div id="items-container">
                    @foreach ($order->items as $index => $item)
                        <div class="d-flex mb-2">
                            <select name="items[{{ $index }}][product_id]" class="form-control me-2" required>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}" {{ $product->id == $item->product_id ? 'selected' : '' }}>
                                        {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>
                            <input type="number" class="form-control me-2" name="items[{{ $index }}][count]" min="1" value="{{ $item->count }}" required>
                        </div>
                    @endforeach
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Update</button>
        </form>
    </div>
@endsection
