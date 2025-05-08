@extends('layout.layout')

@section('content')
    <h3>История движений по заказу #{{ $order->id }}</h3>

    <table class="table table-bordered" id="dataTable">
        <thead>
        <tr>
            <th>Товар</th>
            <th>Склад</th>
            <th>Изменение</th>
            <th>Причина</th>
            <th>Дата</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($movements as $movement)
            <tr>
                <td>{{ $movement->product->name ?? '—' }}</td>
                <td>{{ $movement->warehouse_id }}</td>
                <td>{{ $movement->change }}</td>
                <td>{{ $movement->reason }}</td>
                <td>{{ $movement->created_at }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection

