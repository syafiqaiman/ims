@extends('backend.layouts.app')

@section('content')

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Restock Requests</h3>
    </div>
    <!-- /.card-header -->

    <div class="card-body">
        <table id="restock-table" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Company Name</th>
                    <th>Product Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($restock as $request)
                <tr data-widget="expandable-table" aria-expanded="false">
                    <td>{{$request->company_name}}</td>
                    <td>{{$request->product_name}}</td>
                    <td>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#approveModal{{$request->id}}">Approve</button>
                        <button class="btn btn-danger" data-toggle="modal" data-target="#rejectModal{{$request->id}}">Reject</button>
                    </td>
                </tr>
                <tr class="expandable-body">
                    <td colspan="3">
                        <form role="form" action="{{URL::to('/insert_product')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="company_id">Company Name</label>
                                <select name="company_id" class="form-control" id="company_id">
                                    <option value="">Select Company Name</option>
                                    @foreach($companies as $company)
                                        <option value="{{ $company->id }}" data-address="{{ $company->address }}" data-phone_number="{{ $company->phone_number }}" data-email="{{ $company->email }}">{{ $company->company_name }}</option>
                                    @endforeach
                                </select>
                                @error('company_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="rack_id">Rack Location</label>
                                <select name="rack_id" class="form-control" id="rack_id">
                                    <option value="">Select Rack Location</option>
                                    @foreach($racks as $location)
                                        <option value="{{ $location->id }}">{{ $location->location_code }}</option>
                                    @endforeach
                                </select>
                                @error('rack_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="product_name">Product Name</label>
                                <input type="text" name="product_name" class="form-control @error('title') is-invalid @enderror" id="product_name" placeholder="Enter Product Name">
                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="product_desc">Product Description</label>
                                <input type="text" name="product_desc" class="form-control @error('title') is-invalid @enderror" id="product_desc" placeholder="Enter Product Description">
                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Include the remaining form fields here -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </td>
                </tr>

                <!-- Add modal for approve and reject actions (optional) -->
                <div class="modal fade" id="approveModal{{$request->id}}" tabindex="-1" role="dialog" aria-labelledby="approveModalLabel{{$request->id}}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="approveModalLabel{{$request->id}}">Approve Request</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to approve this request?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <a href="{{ route('approveRequest', ['id' => $request->id]) }}" class="btn btn-primary">Approve</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="rejectModal{{$request->id}}" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel{{$request->id}}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="rejectModalLabel{{$request->id}}">Reject Request</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to reject this request?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <a href="{{ route('rejectRequest', ['id' => $request->id]) }}" class="btn btn-danger">Reject</a>
                            </div>
                        </div>
                    </div>
                </div>
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
                { "className": "action-buttons", "orderable": false, "targets": 2 }
            ],
            "order": [[1, 'asc']]
        });

        // Expandable table logic
        $('table').on('click', 'tr.expandable-body', function () {
            $(this).toggleClass('open');
        });
    });
</script>

@endsection
