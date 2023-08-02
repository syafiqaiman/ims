@extends('backend.layouts.app')

@section('content')
    <title>List of Delivery Orders</title>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Delivery Orders List</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="row mb-3">
                <div class="col">
                    <div class="input-group">
                        <input type="text" id="delivery-no-search" class="form-control" placeholder="Search by Delivery No">
                        <div class="input-group-append">
                            <button type="button" id="search-btn" class="btn btn-primary"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <table id="delivery-orders-table" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Delivery No.</th>
                        <th>View The Detail of Delivery Order</th>
                        {{-- <th>Handled by</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach($deliveryOrdersList as $deliveryOrder)
                        <tr>
                            <td>{{ $deliveryOrder->order_no }}</td>
                            <td>
                                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#statusModal{{ $deliveryOrder->id }}">View Request</button>
                            </td>
                            {{-- <td>
                                @php
                                    $picker = $pickers->where('delivery_order_id', $deliveryOrder->id)->first();
                                    $pickerUser = $picker ? $users->where('id', $picker->user_id)->first() : null;
                                @endphp
                                @if($pickerUser)
                                    {{ $pickerUser->name }}
                                @endif
                            </td> --}}
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

    @foreach($deliveryOrdersList as $deliveryOrder)
        <!-- Status Modal -->
        <div class="modal fade" id="statusModal{{ $deliveryOrder->id }}" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel{{ $deliveryOrder->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="statusModalLabel{{ $deliveryOrder->id }}">Status of Products for Delivery No: {{ $deliveryOrder->delivery_no }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table id="statusTable{{ $deliveryOrder->id }}" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Qty</th>
                                    {{-- <th>Status</th>
                                    <th>Remark</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($deliveryOrder->products as $product)
                                @php
                                    $productData = \App\Models\Product::find($product->pivot->product_id);
                                @endphp
                                    <tr>
                                        <td>{{ $productData->product_name }}</td>
                                        <td>{{ $product->pivot->quantity }}</td>
                                        {{-- <td class="@if ($product->pivot->status === 'Approved') bg-success @elseif ($product->pivot->status === 'Rejected') bg-danger @else bg-warning @endif">
                                            {{ $product->pivot->status }}
                                        </td>
                                        <td>{{ $product->pivot->remark }}</td> --}}
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

    @push('scripts')
    <script>
        $(document).ready(function() {
            // Initialize DataTables
            var table = $('#delivery-orders-table').DataTable();
    
            // Search by Delivery No
            $('#search-btn').on('click', function() {
                var searchText = $('#delivery-no-search').val().trim();
                table.search(searchText).draw();
            });
    
            // Initialize DataTables for each status modal
            @foreach($deliveryOrdersList as $deliveryOrder)
                $('#statusTable{{ $deliveryOrder->id }}').DataTable();
            @endforeach
        });
    </script>
    @endpush
@endsection
