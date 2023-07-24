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
                    @php
                        $previousReturnNo = null;
                    @endphp
                    @foreach($pickers as $picker)
                        @php
                            $currentReturnNo = $picker->returnStock->return_no;
                        @endphp
                        @if ($currentReturnNo != $previousReturnNo)
                            <tr>
                                <td>{{ $currentReturnNo }}</td>
                                <td>
                                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#statusModal{{ $picker->returnStock->return_no }}">View Status</button>
                                </td>
                            </tr>
                            @php
                                $previousReturnNo = $currentReturnNo;
                            @endphp
                        @endif
                    @endforeach
                </tbody>
            </table>
            
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

    @foreach($pickers as $picker)
    <!-- Status Modal -->
    <div class="modal fade" id="statusModal{{ $picker->returnStock->return_no }}" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel{{ $picker->returnStock->return_no }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="statusModalLabel{{ $picker->returnStock->return_no }}">Status of Products for Return No: {{ $picker->returnStock->return_no }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table id="statusTable{{ $picker->returnStock->return_no }}" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($picker->returnStock->products as $product)
                            <tr>
                                <td>{{ $product->product_name }}</td>
                                <td>{{ $product->pivot->quantity }}</td>
                                <td class="@if ($picker->status === 'Disposed' || $picker->status === 'Refurbished') bg-success @else bg-warning @endif color-palette">
                                    @if ($picker->status === 'Disposed' || $picker->status === 'Refurbished')
                                        {{ $picker->status }}
                                    @else
                                        In Process
                                    @endif
                                </td>                                
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
            $(function () {
                // Initialize DataTables for each status modal
                @foreach($pickers as $picker)
                    $('#statusTable{{ $picker->returnStock->return_no }}').DataTable();
                @endforeach
            });
        </script>
    @endpush
@endsection
