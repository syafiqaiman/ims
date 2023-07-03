@extends('backend.layouts.app')

@section('content')
<title>Review Restock Request</title>
<div class="card-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Restock Requests</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Company Name</th>
                                <th>Product Name</th>
                                <th>Total Weight</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($restock as $index => $request)
                                @if ($request->status === 'Under Review')
                                    <tr data-widget="expandable-table" aria-expanded="false">
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $request->company_name }}</td>
                                        <td>{{ $request->product_name }}</td>
                                        <td>{{ $request->total_weight }}</td>
                                        <td>
                                            <a href="{{ URL::to('approve_request/'.$request->id) }}" class="btn btn-success">Approve</a>
                                            <a href="{{ URL::to('remove_request/'.$request->id) }}" class="btn btn-danger">Reject</a>
                                        </td>
                                    </tr>
                                    <tr class="expandable-body">
                                        <td colspan="5">
                                            <p><strong>Product Image:</strong></p>
                                            <div class="col-sm-2">
                                                <img src="{{ asset('storage/Image/'.$request->product_image) }}" width="100">
                                            </div>
                                            <p><strong>Weight Per Item (kg):</strong> {{ $request->weight_per_item }}</p>
                                            <p><strong>Weight Per Carton (kg):</strong> {{ $request->weight_per_carton }}</p>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
    <!-- /.row -->
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function () {
        // Enable expandable tables
        $('[data-widget="expandable-table"]').ExpandableTable();

        // Initialize DataTable with search functionality
        $('#example1').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true
        });
    });
</script>
@endsection
