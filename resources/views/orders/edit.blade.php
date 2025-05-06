@extends('layout.layout')
@section('content')
    <div class="row justify-content-center">

        <h3>Order create</h3>

    </div>
    <div class="row">
        <div class="col-1"></div>
        <div class="col-10 mt-4">
            <form action="{{"orders.update"}}" method="POST">
                @csrf
                <div class="col-lg-4 col-sm-6">
                    <div class="form-group">
                        <label for="customer">Customer</label>
                        <input type="text" class="form-control" id="customer" name="customer" required>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="form-group">
                        <label for="warehouse_id">Warehouses</label>
                        <select class="form-control region" id="warehouse_id" aria-label="Default select example"
                                name="warehouse_id" required>
                            @foreach($warehouses as $value)
                                <option value="{{$value->id}}">{{$value->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-12 col-sm-6">
                    <button type="submit" class="btn btn-primary mt-4">Submit</button>
                </div>
            </form>
        </div>
        <div class="col-1"></div>
@endsection
