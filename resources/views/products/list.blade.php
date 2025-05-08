@extends('layout.layout')
@section('content')
    <div class="row justify-content-center">

        <h3>Products</h3>

    </div>
    <div class="row">
        <div class="col-3"></div>
        <div class="col-6 mt-4">


            <div class="table-responsive">
                <table class="table table-bordered mt-3" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th scope="col" class="th_hh">S/n</th>
                        <th scope="col">Name</th>
                        <th scope="col">Price</th>
                        <th scope="col">Warehouse</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $key=>$value)
                        <tr>
                            <th scope="row">{{$key+1}}</th>
                            <td>{{$value->name}}</td>
                            <td>{{$value->price}}</td>
                            @foreach ($value->stocks as $stock)
                                <td>{{$stock->warehouse->name}}</td>
                            @endforeach
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-3"></div>

@endsection
