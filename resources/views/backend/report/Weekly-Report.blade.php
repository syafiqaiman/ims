@extends('backend.layouts.app') <!-- Replace with the layout you want to extend -->

@section('content')
    <div class="container">
        <h1>Weekly Report</h1>

        <table class="table">
            <thead>
                <tr>
                    <th>Customer Name</th>
                    <th>Week Number</th>
                    <th>Total Inflow Quantity</th>
                    <th>Total Outflow Quantity</th>
                    <th>Net Change Quantity</th>
                    <th>Remaining Quantity</th>
                </tr>
            </thead>
            <tbody>
                @foreach($weeklyReports as $report)
                    <tr>
                        <td>{{ $report->company_name }}</td>
                        <td>{{ $report->week_number }}</td>
                        <td>{{ $report->total_inflow_quantity }}</td>
                        <td>{{ $report->total_outflow_quantity }}</td>
                        <td>{{ $report->net_change_quantity }}</td>
                        <td>{{ $report->remaining_quantity }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
