@extends('backend.layouts.app')

@section('content')
    <title>List of Returned Order</title>
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
                        <th>View The Detail of Returned Product</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($returnStockList as $returnStock)
                        <tr>
                            <td>{{ $returnStock->return_no }}</td>
                            <td>
                                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#statusModal{{ $returnStock->id }}">View Request</button>
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
                                @foreach($returnStock->products as $product)
                                <tr>
                                    <td>{{ $product->product_name }}</td>
                                    <td>{{ $product->pivot->quantity }}</td>
                                    <td class="@if ($product->pivot->status === 'Refurbish' || $product->pivot->status === 'Dispose') bg-warning  color-palette @else bg-success color-palette @endif">

                                            {{ $product->pivot->status }}

                                    </td>
                                    <td>{{ $product->pivot->remark }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#pickerModal{{ $returnStock->id }}">Send Task To Picker</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
                        <form>
                            <div class="form-group">
                                <label for="picker">Select Picker:</label>
                                <select class="form-control" id="picker" name="picker">
                                    <option value="picker1">Picker 1</option>
                                    <option value="picker2">Picker 2</option>
                                    <option value="picker3">Picker 3</option>
                                    <!-- Add more options as needed -->
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary">Assign Task</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    @push('scripts')
        <script>
            $(function () {
                // Initialize DataTables
                $('#return-stock-table').DataTable();

                // Initialize DataTables for each status modal
                @foreach($returnStockList as $returnStock)
                    $('#statusTable{{ $returnStock->id }}').DataTable();
                @endforeach
            });
        </script>
    @endpush
@endsection
