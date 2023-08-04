<!-- resources/views/invoice/invoice_pdf.blade.php -->

@extends('backend.layouts.app')

@section('content')
<title>Invoice</title>
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
                <!-- /.col -->
                <div class="col-6">
        
                    <div class="table-responsive">
                        <table class="table">
                            <tr>
                                <th style="width:50%">Subtotal:</th>
                                <td>{{ $orderGroup->first()->product->product_price * $orderGroup->first()->quantity }}</td>
                            </tr>
                            <tr>
                                <th>Tax (0%):</th>
                                <td>$0.00</td>
                            </tr>
                            <tr>
                                <th>Total:</th>
                                <td>{{ $orderGroup->first()->product->product_price * $orderGroup->first()->quantity }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.invoice -->
@endsection
