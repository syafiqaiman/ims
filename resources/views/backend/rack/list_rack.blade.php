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
                                            <td rowspan="{{ $rowspan }}">{{ $row->location_code }}</td>
                                        @endif
                                        <td>{{ $row->company_name }}</td>
                                        <td>{{ $row->product_name }}</td>
                                        <td>{{ $row->occupied }}/200</td>

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

@endsection
