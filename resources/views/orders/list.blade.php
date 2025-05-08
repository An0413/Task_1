@extends('layout.layout')
@section('content')
    <div class="row justify-content-center">
        <h3>Orders</h3>
    </div>
    <div class="row justify-content-center">
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
    </div>
    <div class="row">
        <div class="col-2"></div>
        <div class="col-8 mt-4">
            <a type="button" class="btn btn-outline-success px-3 py-2 float-right"
               href="{{route('orders.create')}}">Create order</a>


            <div class="table-responsive">
                <table class="table table-bordered mt-3" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th scope="col" class="th_hh">S/n</th>
                        <th scope="col">Customer</th>
                        <th scope="col">Warehouse</th>
                        <th scope="col">Status</th>
                        <th scope="col">History</th>
                        <th scope="col">Edit</th>
                        <th scope="col">Confirm</th>
                        <th scope="col">Cancel</th>
                        <th scope="col">Resume</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $key=>$order)
                        <tr>
                            <th scope="row">{{$key+1}}</th>
                            <td>{{$order->customer}}</td>
                            <td>{{$order->warehouse->name}}</td>
                            <td>{{$order->status}}</td>
                            <td><a href="{{route('stock_movements', $order)}}"><i class="nav-icon fas fa-eye"></i></a></td>
                            <td>
                                <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-sm btn-warning">
                                    <i class="nav-icon fas fa-edit text-primary"></i>
                                </a>
                            </td>
                            <td>
                                @if($order->status == 'active')
                                    <form action="{{route('orders.complete', $order)}}" method="POST"
                                          class="complete-form"
                                          data-id="{{ $order }}">
                                        @csrf
                                        <button type="submit" style="border: none"><i
                                                class="nav-icon fas fa-check text-success"></i></button>
                                    </form>
                                @endif
                            </td>
                            <td>
                                @if($order->status == 'active')
                                    <form action="{{route('orders.cancel', $order)}}" method="POST" class="cancel-form"
                                          data-id="{{ $order }}">
                                        @csrf
                                        <button type="submit" style="border: none"><i
                                                class="nav-icon fas fa-times text-danger"></i></button>
                                    </form>
                                @endif
                            </td>
                            <td>
                                @if($order->status == 'canceled')
                                    <form action="{{route('orders.resume', $order)}}" method="POST">
                                        @csrf
                                        <button type="submit" style="border: none"><i
                                                class="nav-icon fas fa-undo text-success"></i></button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
                @foreach($orders as $key=>$order)
                    <div id="message-{{ $order }}" class="text-success mt-1"></div>
                    <div id="cancel-message-{{ $order }}" class="mt-1"></div>
                @endforeach
            </div>
        </div>
        <div class="col-2"></div>
        <script>
            document.querySelectorAll('.complete-form').forEach(form => {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();

                    const formData = new FormData(this);
                    const url = this.action;
                    const orderId = this.dataset.id;

                    fetch(url, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': formData.get('_token'),
                            'Accept': 'application/json',
                        },
                        body: formData
                    })
                        .then(response => response.json())
                        .then(data => {
                            const messageDiv = document.getElementById(`message-${orderId}`);
                            if (data.message) {
                                messageDiv.innerText = data.message;
                            } else if (data.error) {
                                messageDiv.innerText = data.error;
                                messageDiv.classList.remove('text-success');
                                messageDiv.classList.add('text-danger');
                            }
                            location.reload();
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                });
            });

            document.querySelectorAll('.cancel-form').forEach(form => {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();

                    const formData = new FormData(this);
                    const url = this.action;
                    const orderId = this.dataset.id;

                    fetch(url, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': formData.get('_token'),
                            'Accept': 'application/json',
                        },
                        body: formData
                    })
                        .then(response => response.json())
                        .then(data => {
                            const messageDiv = document.getElementById(`cancel-message-${orderId}`);
                            if (data.message) {
                                messageDiv.innerText = data.message;
                                messageDiv.classList.remove('text-danger');
                                messageDiv.classList.add('text-success');
                            } else if (data.error) {
                                messageDiv.innerText = data.error;
                                messageDiv.classList.remove('text-success');
                                messageDiv.classList.add('text-danger');
                            }
                            location.reload();
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                });
            });
        </script>
@endsection
