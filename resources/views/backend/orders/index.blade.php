@extends('backend.layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Orders</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Order No</th>
                        <th>User ID</th>
                        <th>Product ID</th>
                        <th>Rack ID</th>
                        <th>Quantity</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Action</th> <!-- Add a new column for the action button -->
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $orderGroup)
                        <tr data-widget="expandable-table" aria-expanded="false">
                            <td>
                                <span class="btn btn-default btn-xs">
                                    <i class="fas fa-plus"></i>
                                </span>
                            </td>
                            <td>{{ $orderGroup->first()->order_no }}</td>
                            <td>{{ $orderGroup->first()->user_id }}</td>
                            <td>{{ $orderGroup->first()->product_id }}</td>
                            <td>{{ $orderGroup->first()->rack_id }}</td>
                            <td>{{ $orderGroup->first()->quantity }}</td>
                            <td>{{ $orderGroup->first()->created_at }}</td>
                            <td>{{ $orderGroup->first()->updated_at }}</td>
                            <td>
                                <!-- Add a button to generate the invoice -->
                                <a href="{{ route('orderShow', ['order_no' => $orderGroup->first()->order_no]) }}" class="btn btn-primary">Generate Invoice</a>



                            </td>
                        </tr>
                        <tr class="expandable-body">
                            <td colspan="9">
                                <div class="p-0" style="display: none;">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>User ID</th>
                                                <th>Product ID</th>
                                                <th>Rack ID</th>
                                                <th>Quantity</th>
                                                <th>Created At</th>
                                                <th>Updated At</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($orderGroup as $order)
                                                <tr>
                                                    <td>{{ $order->id }}</td>
                                                    <td>{{ $order->user_id }}</td>
                                                    <td>{{ $order->product_id }}</td>
                                                    <td>{{ $order->rack_id }}</td>
                                                    <td>{{ $order->quantity }}</td>
                                                    <td>{{ $order->created_at }}</td>
                                                    <td>{{ $order->updated_at }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9">No orders found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

{{-- @push('scripts')
    <script>
        function generateInvoice(orderNo) {
            window.location.href = "{{ route('backend.invoice.generate') }}?order_no=" + orderNo;
        }
    </script>
@endpush --}}
