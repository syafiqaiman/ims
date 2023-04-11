@extends('backend.layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Add to Cart</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('carts.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="company_id">Select Company</label>
                            <select name="company_id" id="company_id" class="form-control" required>
                                <option value="">Select Company</option>
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Carton Quantity</th>
                                        <th>Item Per Carton</th>
                                        <th>Item Quantity</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $product)
                                        <tr>
                                            <td>{{ $product->product_name }}</td>
                                            <td>
                                                <input type="number" name="carton_quantity[{{ $product->id }}]" class="form-control" min="0" required>
                                            </td>
                                            <td>{{ $product->quantity->item_per_carton }}</td>
                                            <td>
                                                <input type="number" name="item_quantity[{{ $product->id }}]" class="form-control" min="0" required>
                                            </td>
                                            <td>
                                                <button type="submit" class="btn btn-primary">Add to Cart</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
