@extends('layout.layout')
@section('content')
    <div class="row justify-content-center">

        <h3>Orders</h3>

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
                        <th scope="col">Confirm</th>
                        <th scope="col">Cancel</th>
                        <th scope="col">Resume</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($order as $key=>$value)
                        <tr>
                            <th scope="row">{{$key+1}}</th>
                            <td>{{$value->customer}}</td>
                            <td>{{$value->warehouse->name}}</td>
                            <td>{{$value->status}}</td>
                            <td>
                                <form action="{{route('orders.complete', $value)}}" method="POST" class="complete-form" data-id="{{ $value }}">
                                    @csrf
                                <button type = "submit" style="border: none"><i class="nav-icon fas fa-check text-success"></i></button>
                                </form>
                            </td>
                            <td>
                                <form action="{{route('orders.cancel', $value)}}" method="POST"  class="cancel-form" data-id="{{ $value }}">
                                    @csrf
                                    <button type = "submit" style="border: none"><i class="nav-icon fas fa-times text-danger"></i></button>
                                </form>
                            </td>
                            <td>
                                <form action="{{route('orders.resume', $value)}}" method="POST"  class="cancel-form" data-id="{{ $value }}">
                                    @csrf
                                    <button type = "submit" style="border: none"><i class="nav-icon fas fa-undo text-success"></i></button>
                                </form>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div id="message-{{ $value }}" class="text-success mt-1"></div>
                <div id="cancel-message-{{ $value }}" class="mt-1"></div>
                @endforeach
            </div>
            <div class="modal fade" id="paid" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Վճարում</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input class="form-control input-sm" type="number" id="paid_sum" value="">
                            <input class="form-control input-sm" type="hidden" id="comp_val" value="">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Փակել</button>
                            <button id="send_paid_val" type="button" class="btn btn-primary" data-dismiss="modal">
                                Հաստատել
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-2"></div>
        <script>
            document.querySelectorAll('.complete-form').forEach(form => {
                form.addEventListener('submit', function (e) {
                    e.preventDefault(); // չուղարկել սովորական ձևով

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
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                });
            });
        </script>
@endsection
