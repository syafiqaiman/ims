@extends('backend.layouts.app')

@section('content')

<div class="row">
    <div class="col-5 col-sm-3">
        <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
            @foreach($dates as $date)
                <a class="nav-link @if($loop->first) active @endif" id="vert-tabs-{{ $date }}-tab" data-toggle="pill" href="#vert-tabs-{{ $date }}" role="tab" aria-controls="vert-tabs-{{ $date }}" aria-selected="{{ $loop->first ? 'true' : 'false' }}">{{ $date }}</a>
            @endforeach
        </div>
    </div>
    <div class="col-7 col-sm-9">
        <div class="tab-content" id="vert-tabs-tabContent">
            @foreach($dates as $date)
                <div class="tab-pane text-left fade @if($loop->first) show active @endif" id="vert-tabs-{{ $date }}" role="tabpanel" aria-labelledby="vert-tabs-{{ $date }}-tab">
                    <h3>{{ $date }}</h3>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Product Name</th>
                                <th>Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders[$date] as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->product_name }}</td>
                                    <td>{{ $order->quantity }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection