@extends('backend.layouts.app')


    <div class="invoice p-3 mb-3">
        <div class="row">
            <div class="col-12">
                <h4>
                    <i class="fas fa-globe"></i> Invoice
                    <small class="float-right">Date: {{ date('d/m/Y') }}</small>
                </h4>
            </div>
        </div>

        <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
                From
                <address>
                    Your Company Name<br>
                    Your Address<br>
                    City, State, ZIP<br>
                    Phone: (123) 456-7890<br>
                    Email: info@example.com
                </address>
            </div>
            <div class="col-sm-4 invoice-col">
                To
                <address>
                    Customer Name<br>
                    Customer Address<br>
                    City, State, ZIP<br>
                    Phone: (123) 456-7890<br>
                    Email: customer@example.com
                </address>
            </div>
            <div class="col-sm-4 invoice-col">
                <b>Invoice #007612</b><br>
                <br>
                <b>Order ID:</b> {{ $orderGroup->first()->order_no }}<br>
                <b>Payment Due:</b> {{ date('d/m/Y', strtotime('+7 days')) }}
            </div>
        </div>

        <div class="row">
            <div class="col-12 table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orderGroup as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->product_id }}</td>
                                <td>{{ $order->quantity }}</td>
                                <td>{{ $order->product->price }}</td>
                                <td>{{ $order->quantity * $order->product->price }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

