@extends('backend.layouts.app')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header info">
                <h3 class="card-title">Product List</h3>
                <div class="card-tools">
                        <div class="input-group">
                            <input class="form-control" type="text" placeholder="Search" aria-label="Search" id="searchInput">
                            <div class="input-group-append">
                                <button class="btn btn-primary" id="searchButton">Search
                                </button>
                            </div>
                        </div>
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
                        <tr class="expandable-body d-none">
                            <td colspan="9">
                                <div class="row">
                                    <div class="col-md-3">
                                        <strong>Description:</strong>
                                    </div>
                                    <div class="col-md-9">
                                        {{ $row->product_desc }}
                                    </div>
                                </div>
                                @if (Auth::user()->role == 1 || Auth::user()->role == 2)
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
    document.addEventListener('DOMContentLoaded', function() {
        var searchInput = document.getElementById('searchInput');
        var searchForm = document.getElementById('searchButton');
        var table = document.getElementById('example1');
        var rows = table.getElementsByTagName('tr');

        searchForm.addEventListener('click', function(e) {
            e.preventDefault();
            searchTable();
        });

        function searchTable() {
            var searchText = searchInput.value.toLowerCase();
            var userRole = {{ Auth::user()->role }};

            for (var i = 1; i < rows.length; i++) {
                var idCell = rows[i].getElementsByTagName('td')[0];
                var idText = idCell.textContent.toLowerCase();

                var productNameCell = rows[i].getElementsByTagName('td')[3];
                var productNameText = productNameCell.textContent.toLowerCase();

                var rackLocationCell = rows[i].getElementsByTagName('td')[2];
                var rackLocationText = rackLocationCell.textContent.toLowerCase();

                var isVisible = false;

                if (userRole === 1 && rackLocationText.includes(searchText)) {
                    isVisible = true;
                } else if (userRole === 3 && (idText.includes(searchText) || productNameText.includes(searchText))) {
                    isVisible = true;
                }

                if (isVisible) {
                    rows[i].style.display = '';
                    rows[i].nextElementSibling.style.display = '';
                } else {
                    rows[i].style.display = 'none';
                    rows[i].nextElementSibling.style.display = 'none';
                }
            }
        }
    });
</script>
@endpush
