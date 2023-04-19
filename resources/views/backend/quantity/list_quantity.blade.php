@extends('backend.layouts.app')

@section('content')

<div class="card">
    <div class="card-header">
        <strong>Product Stock Level</strong>
    </div>
       
    <div class="card-body">
        <table id="example1" class="table">
            <thead>
                <tr>
                    <th style="width: 10px">Company</th>
                    <th>Product</th>
                    <th>Total Quantity Initially Stocked</th>
                    <th>Remaining Quantity</th>
                    <th>Stock Level</th>
                    <th style="width: 40px">Label</th>
                </tr>
            </thead>
            <tbody>
                @foreach($quantities as $quantity)
                <tr>
                    <td>{{ $quantity->company_name }}</td>
                    <td>{{ $quantity->product_name }}</td>
                    <td>{{ $quantity->total_quantity }}</td>
                    <td>{{ $quantity->remaining_quantity }}/{{ $quantity->total_quantity }}</td>
                    <td>
                        @php
                            $progress = ($quantity->remaining_quantity / $quantity->total_quantity) * 100;
                            $labelClass = $progress < 25 ? 'danger' : ($progress < 50 ? 'warning' : ($progress < 75 ? 'primary' : 'success'));
                        @endphp
                        <div class="progress progress-xs">
                            <div class="progress-bar bg-{{ $labelClass }}" style="width: {{ $progress }}%"></div>
                        </div>
                    </td>
                    <td>
                        <span class="badge bg-{{ $labelClass }}">{{ round($progress) }}%</span>
                    </td>
                    
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
