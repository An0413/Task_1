@extends('layout.layout')
@section('content')
    <div class="row justify-content-center">

        <h3>Warehouses</h3>

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
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($warehouses as $key=>$value)
                        <tr>
                            <th scope="row">{{$key+1}}</th>
                            <td>{{$value->name}}</td>
                    @endforeach
                    </tbody>
                </table>
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
        <div class="col-3"></div>

@endsection
