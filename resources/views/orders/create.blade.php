@extends('layout.layout')
@section('content')
    <div class="row justify-content-center">

        <h3>Order create</h3>

    </div>
    <div class="row">
        <div class="col-2"></div>
        <div class="col-8 mt-4">
            <form action="{{"orders.store"}}">
                @csrf

            </form>
        </div>
        <div class="col-2"></div>
@endsection
