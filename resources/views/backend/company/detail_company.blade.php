@extends('backend.layouts.app')
@section('content')
@foreach($companies as $company)
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-text-width"></i>
                Company List Owned
            </h3>
        </div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-4">Company Name</dt>
                <dd class="col-sm-8">{{ $company->company_name }}</dd>
                <dt class="col-sm-4">Company Address</dt>
                <dd class="col-sm-8">{{ $company->address }}</dd>
                <dt class="col-sm-4">Phone Number</dt>
                <dd class="col-sm-8">{{ $company->phone_number }}</dd>
                <dt class="col-sm-4">Email</dt>
                <dd class="col-sm-8">{{ $company->email }}</dd>
            </dl>
        </div>
    </div>
</div>
@endforeach

@endsection
