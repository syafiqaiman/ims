@extends('backend.layouts.app')

@section('content')
<title>Restock Status</title>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Restock Requests</h3>
    </div>
    <!-- /.card-header -->

    <div class="card-body">
        <table id="restock-table" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($restock as $request)
                <tr data-widget="expandable-table" aria-expanded="false">
                    <td>{{$request->product_name}}</td>
                    <td>
                        @if ($request->status === 'Under Review')
                            <button class="btn btn-info">Under Review</button>
                        @elseif ($request->status === 'Approved')
                            <button class="btn btn-success">Approved</button>
                        {{-- @elseif ($request->status === 'Rejected')
                            <button class="btn btn-danger">Rejected</button> --}}
                        @endif
                    </td>
                    <td>
                        @if ($request->status === 'Under Review')
                            <a href="{{ route('cancelReorderRequest', ['id' => $request->id]) }}" class="btn btn-danger">Cancel Reorder</a>
                        @endif
                    </td>                    
                </tr>
                <tr class="expandable-body">
                    <td colspan="3">
                        <p><strong>Description:</strong> {{$request->product_desc}}</p>
                        <p><strong>Weight to be Restock:</strong> {{$request->total_weight}} kg</p>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->

<script>
    $(function () {
        $("#restock-table").DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "columnDefs": [
                { "className": "expand-control", "orderable": false, "targets": 0 },
                { "className": "expand-content", "orderable": false, "targets": 1 },
                { "orderable": false, "targets": 2 }
            ],
            "order": [[1, 'asc']]
        });

        // Expandable table logic
        $('table').on('click', 'tr.expandable-body', function () {
            $(this).toggleClass('open');
        });
    });

    function removeRow(button) {
        const row = button.closest('tr');
        row.remove();
    }
</script>

@endsection
