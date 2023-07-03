@extends('backend.layouts.app')

@section('content')
<title>Picker Status</title>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Picker Status</h3>
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
                <div class="card-body p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>Picker</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pickers->groupBy('picker_name') as $pickerName => $groupedPickers)
                                <tr data-widget="expandable-table" aria-expanded="false">
                                    <td>
                                        <i class="expandable-table-caret fas fa-caret-right fa-fw"></i>
                                        {{ $pickerName }}
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr class="expandable-body">
                                    <td colspan="5">
                                        <div class="p-4">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Product Name</th>
                                                        <th>Quantity</th>
                                                        <th>Date of Pick Up</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($groupedPickers->sortBy('status') as $picker)
                                                        <tr>
                                                            <td>{{ $picker->product_name }}</td>
                                                            <td>{{ $picker->quantity }}</td>
                                                            <td>{{ $picker->updated_at }}</td>
                                                            <td>
                                                                @if($picker->status == 'Collected')
                                                                    <span class="badge bg-success">{{ $picker->status }}</span>
                                                                @elseif($picker->status == 'Pending')
                                                                    <span class="badge bg-warning">{{ $picker->status }}</span>
                                                                @elseif($picker->status == 'Packing')
                                                                    <span class="badge bg-info">{{ $picker->status }}</span>
                                                                @else
                                                                    <span class="badge bg-danger">{{ $picker->status }}</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </td>
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
