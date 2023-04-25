

@extends('backend.layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">TASK : Product To Be Collected</h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Date of Pick Up</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pickers as $picker)
                            <tr>
                                <td>{{ $picker->product->product_name }}</td>
                                <td>{{ $picker->quantity }}</td>
                                <td>{{ $picker->created_at->format('d M, Y') }}
                                </td>
                                <td><span class="tag tag-{{ $picker->status == 'Approved' ? 'success' : ($picker->status == 'Pending' ? 'warning' : 'danger') }}">{{ $picker->status }}</span></td>
                                <td>{{ $picker->reason }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
