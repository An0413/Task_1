@extends('layout.layout')

@section('content')
    <div class="row justify-content-center">
        <h3>Order Create</h3>
    </div>

    <div class="row">
        <div class="col-1"></div>
        <div class="col-10 mt-4">
            <form action="{{ route('orders.store') }}" method="POST">
                @csrf

                <div class="col-lg-4 col-sm-6 mb-3">
                    <label for="customer">Customer</label>
                    <input type="text" class="form-control" id="customer" name="customer" required>
                </div>

                <div class="col-lg-4 col-sm-6 mb-4">
                    <label for="warehouse_id">Warehouse</label>
                    <select class="form-control" id="warehouse_id" name="warehouse_id" required>
                        @foreach($warehouses as $value)
                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-4 col-sm-6 mb-4">

                    <div id="items-container">
                        <div class="row mb-2 item">
                            <div class="col-md-6">
                                <select class="form-control" name="items[0][product_id]" required>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <input type="number" class="form-control" name="items[0][count]" min="1" required>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-danger remove-item float-right">X</button>
                            </div>
                        </div>
                    </div>
                    <button type="button" id="add-item" class="btn btn-success mb-4">Add Product</button>

                </div>

                <div class="col-lg-4 col-sm-6 mb-4">
                    <button type="submit" class="btn btn-primary">Submit Order</button>
                </div>
            </form>
        </div>
        <div class="col-1"></div>
    </div>

    <script>
        let itemIndex = 1;

        document.getElementById('add-item').addEventListener('click', function () {
            const container = document.getElementById('items-container');

            const html = `
            <div class="row mb-2 item">
                <div class="col-md-6">
                    <select class="form-control" name="items[${itemIndex}][product_id]" required>
                        @foreach ($products as $product)
            <option value="{{ $product->id }}">{{ $product->name }}</option>
                        @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <input type="number" class="form-control" name="items[${itemIndex}][count]" min="1" required>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger remove-item float-right">X</button>
                </div>
            </div>
        `;

            container.insertAdjacentHTML('beforeend', html);
            itemIndex++;
        });

        document.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-item')) {
                e.target.closest('.item').remove();
            }
        });
    </script>
@endsection
