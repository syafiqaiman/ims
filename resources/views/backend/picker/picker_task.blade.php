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
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pickers as $picker)
                            <tr>
                                <td>{{ $picker->product->product_name }}</td>
                                <td>{{ $picker->quantity }}</td>
                                <td>{{ $picker->created_at->format('d M, Y') }}</td>
                                <td>
                                    @if($picker->status == 'Collected')
                                    <span class="badge bg-success">{{ $picker->status }}</span>
                                @elseif($picker->status == 'Pending')
                                    <span class="badge bg-warning">{{ $picker->status }}</span>
                                @else
                                    <span class="badge bg-danger">{{ $picker->status }}</span>
                                @endif
                                </td>
                                <td class="status-cell">
                                @if($picker->status == 'Collected')
                                    <span class="badge bg-success">{{ $picker->status }}</span>
                                @elseif($picker->status == 'Pending')
                                    <form action="{{ route('picker.confirm', ['id' => $picker->id, 'quantity' => $picker->quantity]) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-sm btn-collect collect-btn">Collect</button>
                                    </form>                                    
                                @else
                                    <span class="badge bg-primary">Collected</span>
                                @endif
                                </td>
                                
                                
                                
                            </tr>
                            @endforeach
                        </tbody>                        
                    </table>
                </div>
            </div>
            <div class="text-center mt-4">
                <a href="{{ route('picker.history') }}" class="btn btn-success" id="proceed-to-packing" disabled>Proceed to Packing</a>
            </div>
            
        </div>
    </div>
</div>

    

@endsection
