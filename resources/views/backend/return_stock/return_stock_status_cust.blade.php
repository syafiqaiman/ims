@extends('backend.layouts.app')

@section('content')
    <title>Return Stock List</title>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Return Stock List</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="return-stock-table" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Return No.</th>
                        <th>View The Status of Your Returned Product</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($returnStockList as $returnStock)
                        <tr>
                            <td>{{ $returnStock->return_no }}</td>
                            <td>
                                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#statusModal{{ $returnStock->id }}">View Status</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

    @foreach($returnStockList as $returnStock)
        <!-- Status Modal -->
        <div class="modal fade" id="statusModal{{ $returnStock->id }}" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel{{ $returnStock->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="statusModalLabel{{ $returnStock->id }}">Status of Products for Return No: {{ $returnStock->return_no }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($returnStock->products as $product)
                                    <tr>
                                        <td>{{ $product->product_name }}</td>
                                        <td>{{ $product->pivot->status }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
