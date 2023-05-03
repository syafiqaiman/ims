@extends('backend.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header info">
                    <h3 class="card-title">Rack Location</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Rack Location</th>
                                <th>Company</th>
                                <th>Product Name</th>
                                <th>Weight (KG)</th>
                                {{-- @if (Auth::user()->role == 1)
                                    <th>Action</th>
                                @endif --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($racking->groupBy('location_code') as $location => $rows)
                                @php
                                    $rowspan = count($rows);
                                @endphp
                                @foreach ($rows as $index => $row)
                                    <tr>
                                        @if ($index === 0)
                                            <td rowspan="{{ $rowspan }}">{{ $location }}</td>
                                        @endif
                                        <td>{{ $row->company_name }}</td>
                                        <td>{{ $row->product_name }}</td>
                                        <td>{{ $row->remaining_quantity }}</td>
                                        {{-- @if (Auth::user()->role == 1)
                                            <td>
                                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                                    data-target="#edit-rack-modal">
                                                    Edit Weight
                                                </button>
                                            </td>
                                        @endif --}}
                                    </tr>
                                @endforeach
                            @endforeach

                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>

    {{-- <div class="modal fade" id="edit-rack-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Quantity</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Quantity</p>
                    <input class="form-control" type="text" placeholder="{{ $row->remaining_quantity }}">
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal --> --}}

    {{-- <div class="modal fade" id="edit-rack-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Quantity</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Weight</p>
                    <input class="form-control" type="text" placeholder="">
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="save-quantity-btn">Save changes</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div> --}}
@endsection
