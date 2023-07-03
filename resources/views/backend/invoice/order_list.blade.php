<!-- resources/views/invoice/show.blade.php -->

@extends('backend.layouts.app')

@section('content')
<title>List of Order</title>
    <div class="invoice p-3 mb-3">
        <!-- title row -->
        <div class="row">
            <div class="col-12">
                <h4>
                    <i class="fas fa-globe"></i> Invoice
                    <small class="float-right">Date: {{ $orderGroup->first()->created_at->format('Y-m-d') }}</small>
                </h4>
            </div>
            <!-- /.col -->
        </div>
        <!-- info row -->
        <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
                From
                <address>
                    <strong>{{ $company->company_name }}</strong><br>
                    {{ $company->address }}<br>
                    Phone: {{ $company->phone_number }}<br>
                    Email: {{ $company->email }}
                </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
                To
                <address>
                    <strong>{{ $orderGroup->first()->user_id }}</strong>
                </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
                <b>Invoice #{{ $orderGroup->first()->id }}</b><br>
                <br>
                <b>Order ID:</b> {{ $orderGroup->first()->id }}<br>
                <b>Product ID:</b> {{ $orderGroup->first()->product_id }}<br>
                <b>Rack ID:</b> {{ $orderGroup->first()->rack_id }}<br>
                <b>Quantity:</b> {{ $orderGroup->first()->quantity }}
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
        <!-- Table row -->
        <div class="row">
            <div class="col-12 table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            {{-- <th>Subtotal</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orderGroup as $index => $order)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $order->product->product_name }}</td>
                                <td>{{ $order->quantity }}</td>
                                {{-- <td>{{ $order->product->price * $order->quantity }}</td> --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.col -->
        </div>
        
        <!-- /.row -->
        <div class="row">
            <!-- accepted payments column -->
            <div class="col-6">
                <p class="lead">Payment Methods:</p>
                <img src="https://via.placeholder.com/100" alt="Visa">
                <img src="https://via.placeholder.com/100" alt="Mastercard">
                <img src="https://via.placeholder.com/100" alt="American Express">
                <img src="https://via.placeholder.com/100" alt="Paypal">
                <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed tincidunt facilisis libero sed cursus.
                </p>
            </div>
            <!-- /.col -->
            <div class="col-6">
                <p class="lead">Amount Due {{ $orderGroup->first()->created_at->format('Y-m-d') }}</p>
                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <th style="width:50%">Subtotal:</th>
                            {{-- <td>{{ $orderGroup->first()->product->price * $orderGroup->first()->quantity }}</td> --}}
                        </tr>
                        <tr>
                            <th>Tax (0%):</th>
                            <td>$0.00</td>
                        </tr>
                        <tr>
                            <th>Total:</th>
                            {{-- <td>{{ $orderGroup->first()->product->price * $orderGroup->first()->quantity }}</td> --}}
                        </tr>
                    </table>
                </div>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.invoice -->

    <!-- Print Button -->
    <div class="row">
        <div class="col-12">
            <button class="btn btn-primary" onclick="window.print()">Print Invoice</button>
            {{-- <a href="{{ route('invoice.download', $orderGroup->first()->id) }}" class="btn btn-success">Download as PDF</a> --}}
        </div>
    </div>
@endsection
