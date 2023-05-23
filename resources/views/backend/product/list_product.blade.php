@extends('backend.layouts.app')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header info">
                <h3 class="card-title">Product List</h3>
                <div class="card-tools">
                    <form class="form-inline ml-3" id="searchForm">
                        <div class="input-group input-group-sm">
                            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search" id="searchInput">
                            <div class="input-group-append">
                                <button class="btn btn-navbar" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Company</th>
                            @if (Auth::user()->role == 1 || Auth::user()->role == 2)
                            <th>Rack Location</th>
                            @endif
                            <th>Product Name</th>
                            <th>Qty</th>
                            <th>Total Weight In Stock (kg)</th>
                            <th>Product Image</th>
                            @if (Auth::user()->role == 1)
                            <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($list as $row)
                        <tr data-widget="expandable-table" aria-expanded="false">
                            <td>{{ $row->id }}</td>
                            <td>{{ $row->company_name }}</td>
                            @if (Auth::user()->role == 1 || Auth::user()->role == 2)
                            <td>{{ $row->location_code }}</td>
                            @endif
                            <td>{{ $row->product_name }}</td>
                            <td>{{ $row->remaining_quantity }}</td>
                            <td>{{ $row->weight_of_product }}</td>
                            <td>
                                <img src="{{ asset('storage/Image/'.$row->product_image) }}" style="height: 100px; width: 150px;">
                            </td>
                            @if (Auth::user()->role == 1)
                            <td>
                                <a href="{{ URL::to('/edit_product/'.$row->id) }}" class="btn btn-sm btn-info">Edit</a>
                                <a href="{{ URL::to('delete_product/'.$row->id) }}" class="btn btn-sm btn-danger" id="delete" class="middle-align">Delete</a>
                            </td>
                            @endif
                        </tr>
                        <tr class="expandable-body">
                            <td colspan="9">
                                <div class="row">
                                    <div class="col-md-3">
                                        <strong>Description:</strong>
                                    </div>
                                    <div class="col-md-9">
                                        {{ $row->product_desc }}
                                    </div>
                                </div>
                                @if (Auth::user()->role ==
1 || Auth::user()->role == 2)
<div class="row">
<div class="col-md-3">
<strong>Location Code:</strong>
</div>
<div class="col-md-9">
{{ $row->location_code }}
</div>
</div>
@endif
<div class="row">
<div class="col-md-3">
<strong>Weight per Carton:</strong>
</div>
<div class="col-md-9">
{{ $row->weight_per_carton }}
</div>
</div>
<div class="row">
<div class="col-md-3">
<strong>Weight per Item:</strong>
</div>
<div class="col-md-9">
{{ $row->weight_per_item }}
</div>
</div>
@if (Auth::user()->role == 1 || Auth::user()->role == 2)
<div class="row">
<div class="col-md-3">
<strong>Date To Be Stored:</strong>
</div>
<div class="col-md-9">
{{ $row->date_to_be_stored }}
</div>
</div>
@endif
</td>
</tr>
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

@push('scripts')

<script>
    $(function () {
        // Enable expandable tables
        $('[data-widget="expandable-table"]').ExpandableTable();

        // Initialize DataTable with search functionality
        var table = $('#example1').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true
        });

        // Apply search functionality to the table based on input value
        $('#searchInput').on('input', function () {
            table.search($(this).val()).draw();
        });
    });
</script>
@endpush