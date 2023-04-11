@extends('backend.layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Select a Product</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('carts.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="company_id">Select a Company:</label>
                                <select name="company_id" id="company_id" class="form-control" required>
                                    <option value="">Select a Company</option>
                                    @foreach($companies as $company)
                                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="product_id">Select a Product:</label>
                                <select name="product_id" id="product_id" class="form-control" required>
                                    <option value="">Select a Product</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="carton_quantity">Carton Quantity:</label>
                                <input type="number" name="carton_quantity" id="carton_quantity" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="item_quantity">Item Quantity:</label>
                                <input type="number" name="item_quantity" id="item_quantity" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Add to Cart</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#company_id').on('change', function() {
                var company_id = $(this).val();
                if(company_id) {
                    $.ajax({
                        url: '/getProducts/'+company_id,
                        type: "GET",
                        dataType: "json",
                        success:function(data) {
                            $('#product_id').empty();
                            $.each(data, function(key, value) {
                                $('#product_id').append('<option value="'+ key +'">' + value + '</option>');
                            });
                        },
                        error:function(data) {
                            console.log('Error:', data);
                        }
                    });
                } else {
                    $('#product_id').empty();
                }
            });
        });
    </script>
@endsection
