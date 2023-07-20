@extends('backend.layouts.app')

@section('content')
    <title>List of Returned Order</title>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Return Stock List</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="row mb-3">
                <div class="col">
                    <div class="input-group">
                        <input type="text" id="return-no-search" class="form-control" placeholder="Search by Return No">
                        <div class="input-group-append">
                            <button type="button" id="search-btn" class="btn btn-primary"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <table id="return-stock-table" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Return No.</th>
                        <th>View The Detail of Returned Product</th>
                        <th>Handle by</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($returnStockList as $returnStock)
                        <tr>
                            <td>{{ $returnStock->return_no }}</td>
                            <td>
                                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#statusModal{{ $returnStock->id }}">View Request</button>
                            </td>
                            <td>
                                @php
                                    $picker = $pickers->where('return_stock_id', $returnStock->id)->first();
                                    $pickerUser = $picker ? $users->where('id', $picker->user_id)->first() : null;
                                @endphp
                                @if($pickerUser)
                                    {{ $pickerUser->name }}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

    @foreach($returnStockList as $returnStock)
        <!-- Status Modal -->
          <!-- Status Modal -->
    <div class="modal fade" id="statusModal{{ $returnStock->id }}" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel{{ $returnStock->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="statusModalLabel{{ $returnStock->id }}">Status of Products for Return No: {{ $returnStock->return_no }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table id="statusTable{{ $returnStock->id }}" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Qty</th>
                                <th>Status</th>
                                <th>Remark</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($returnStock->products as $product)
                            @php
                            $productData = \App\Models\Product::find($product->pivot->product_id);
                            $receiveStatus = $returnStock->receive_status;
                            $status = null;
                
                            if ($receiveStatus === null) {
                                // Get the status from the pivot table
                                $status = $product->pivot->status;
                            } elseif ($receiveStatus === 'Received') {
                                // Get the status from the pickers table using return_stock_id as the foreign key
                                $pickerStatuses = $product->pickers->where('return_stock_id', $returnStock->id)->pluck('status');
                                
                                // Check if the product's status is present in the pickerStatuses collection
                                if ($pickerStatuses->contains($product->pivot->status)) {
                                    $status = $product->pivot->status;
                                } else {
                                    // If not found, set the status to the first status in the pickerStatuses collection
                                    $status = $pickerStatuses->first();
                                }
                            }
                        @endphp
                                <tr>
                                    <td>{{ $productData->product_name }}</td>
                                    <td>{{ $product->pivot->quantity }}</td>
                                    <td class="@if ($status === 'Refurbish' || $status === 'Dispose') bg-warning color-palette @else bg-success color-palette @endif">
                                        {{ $status }}
                                    </td>
                                    <td>{{ $product->pivot->remark }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                                       
                    </table>
                </div>
                <div class="modal-footer">
                    <div class="modal-footer">
                        <button type="button" id="sendTaskButton{{ $returnStock->id }}" class="btn btn-primary" data-toggle="modal" data-target="#pickerModal{{ $returnStock->id }}">Send Task To Picker</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <!-- Picker Modal -->
        <div class="modal fade" id="pickerModal{{ $returnStock->id }}" tabindex="-1" role="dialog" aria-labelledby="pickerModalLabel{{ $returnStock->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="pickerModalLabel{{ $returnStock->id }}">Assign Task to Picker for Return No: {{ $returnStock->return_no }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Add picker selection form here -->
                        <form id="assignTaskForm{{ $returnStock->id }}" action="{{ route('assign.RO.task') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="picker">Select Picker:</label>
                                <select name="user_id" class="form-control">
                                    <option value="">Select Picker</option>
                                    @foreach ($users as $user)
                                        @if ($user->role == 2)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <input type="hidden" name="return_stock_id" value="{{ $returnStock->id }}">
                            <input type="hidden" name="return_no" value="{{ $returnStock->return_no }}">
                            @foreach ($returnStock->products as $product)
                                @php
                                    $productData = \App\Models\Product::find($product->pivot->product_id);
                                @endphp
                                <input type="hidden" name="product_id[]" value="{{ $productData->id }}">
                                <input type="hidden" name="quantity[]" value="{{ $product->pivot->quantity }}">
                                <input type="hidden" name="status[]" value="{{ $product->pivot->status }}">
                                <input type="hidden" name="remark[]" value="{{ $product->pivot->remark }}">
                            @endforeach
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" form="assignTaskForm{{ $returnStock->id }}" class="btn btn-primary">Assign Task</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    @push('scripts')
    <script>
        $(document).ready(function() {
            // Initialize DataTables
            $('#return-stock-table').DataTable();

            // Search by Return No
            $('#search-btn').on('click', function() {
                // Your existing search logic...
            });

            // Initialize DataTables for each status modal
            @foreach($returnStockList as $returnStock)
                $('#statusTable{{ $returnStock->id }}').DataTable();

                // JavaScript function to disable the "Send Task To Picker" button
                function updateSendTaskButton{{ $returnStock->id }}() {
                    // Check if the receive_status is 'Received'
                    const receiveStatus = '{{ $returnStock->receive_status }}';
                    const sendTaskButton = document.getElementById('sendTaskButton{{ $returnStock->id }}');

                    if (receiveStatus === 'Received') {
                        sendTaskButton.disabled = true; // Disable the button if 'Received'
                    } else {
                        // Check if any of the status cells have "Disposed" or "Refurbished" status
                        const statusTable = document.getElementById('statusTable{{ $returnStock->id }}');
                        const statusCells = statusTable.querySelectorAll('tbody td:nth-child(3)');
                        let isAnyDisposedOrRefurbished = false;

                        statusCells.forEach((cell) => {
                            const status = cell.textContent.trim();
                            if (status === 'Disposed' || status === 'Refurbished') {
                                isAnyDisposedOrRefurbished = true;
                            }
                        });

                        sendTaskButton.disabled = isAnyDisposedOrRefurbished; // Enable/disable the button accordingly
                    }
                }

                // Run the function when the modal is shown
                $('#statusModal{{ $returnStock->id }}').on('shown.bs.modal', function () {
                    updateSendTaskButton{{ $returnStock->id }}();
                });
            @endforeach
        });
    </script>
        
    @endpush
@endsection