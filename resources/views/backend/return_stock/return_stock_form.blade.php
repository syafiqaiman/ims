@extends('backend.layouts.app')

@section('content')
    <title>Return Order Form</title>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Return Order Form</h3>
        </div>
        <form method="POST" action="{{ route('return-stock.store') }}">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="company_id">My Company</label>
                            <select name="company_id" id="company_id"
                                class="form-control select2 select2-hidden-accessible" style="width: 100%;"
                                data-select2-id="1" tabindex="-1" aria-hidden="true">
                                <option value="">Select Company Name</option>
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}"
                                        data-address="{{ $company->address }}"
                                        data-phone_number="{{ $company->phone_number }}"
                                        data-email="{{ $company->email }}">{{ $company->company_name }}</option>
                                @endforeach
                            </select>
                            @error('company_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" name="address"
                                class="form-control @error('address') is-invalid @enderror"
                                id="address" placeholder="Enter Address">
                            @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="phone">Phone number</label>
                            <input type="text" name="phone_number"
                                class="form-control @error('phone_number') is-invalid @enderror"
                                id="phone_number" placeholder="Enter Phone Number">
                            @error('phone_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email"
                                class="form-control @error('email') is-invalid @enderror"
                                id="email" placeholder="Enter Email">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Product Table -->
                <div class="form-group">
                    <label for="product_table">Products</label>
                    <table class="table table-bordered" id="product_table">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Status</th>
                                <th>Remark</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Empty tbody -->
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-primary" id="add_product">Add Product</button>
                </div>

                <!-- Product Modal -->
                <div class="modal fade" id="product_modal" tabindex="-1" role="dialog"
                    aria-labelledby="product_modal_label" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="product_modal_label">Select Product To Be Return</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- Product Selection Form -->
                                <form id="product_selection_form">
                                    @csrf
                                    <div class="form-group">
                                        <label for="product_name">Product Name</label>
                                        <select class="form-control" id="product_name" name="product_name[]">
                                            @foreach ($products as $product)
                                                <option value="{{ $product->id }}">{{ $product->product_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="quantity">Quantity</label>
                                        <input type="number" class="form-control" id="quantity" name="quantity[]"
                                            placeholder="Enter quantity">
                                    </div>
                                    <div class="form-group">
                                        <label for="status">Status:</label>
                                        <select class="form-control" id="status" name="status[]">
                                            <option value="Dispose">Dispose</option>
                                            <option value="Refurbish">Refurbish</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="remark">Remark:</label>
                                        <select class="form-control" id="remark" name="remark[]">
                                            <option value="">Select Remark</option>
                                        </select>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" id="add_product_row">Add</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <button class="btn btn-primary" id="submit_return">Submit</button>

        </form>
    </div>
    </div>

@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            // Show product modal
            $('#add_product').click(function () {
                $('#product_modal').modal('show');
            });

            // Handle status change event
            $('#status').change(function () {
                var selectedStatus = $(this).val();
                var remarkDropdown = $('#remark');

                // Clear previous options
                remarkDropdown.empty();

                // Add options based on selected status
                if (selectedStatus === 'Dispose') {
                    remarkDropdown.append('<option value="Expired">Expired</option>');
                    remarkDropdown.append('<option value="Damaged">Damaged</option>');
                    remarkDropdown.append('<option value="Broken">Broken</option>');
                } else if (selectedStatus === 'Refurbish') {
                    remarkDropdown.append('<option value="Repackage">Repackage</option>');
                    remarkDropdown.append('<option value="Rerack">Rerack</option>');
                }
            });

            // Add product row to the table
            $('#add_product_row').click(function () {
                // Add the product row to the table without refreshing the page
                var product_id = $('#product_name').val();
                var product_name = $('#product_name option:selected').text();
                var quantity = $('#quantity').val();
                var status = $('#status').val();
                var remark = $('#remark').val();

                var newRow = '<tr>' +
                    '<td><input type="hidden" name="product_id[]" value="' + product_id + '">' + product_name + '</td>' +
                    '<td><input type="hidden" name="quantity[]" value="' + quantity + '">' + quantity + '</td>' +
                    '<td><input type="hidden" name="status[]" value="' + status + '">' + status + '</td>' +
                    '<td><input type="hidden" name="remark[]" value="' + remark + '">' + remark + '</td>' +
                    '<td><button class="btn btn-danger btn-sm remove_product_row">Remove</button></td>' +
                    '</tr>';

                $('#product_table tbody').append(newRow);

                // Clear the modal form
                $('#product_selection_form')[0].reset();

                // Close the modal
                $('#product_modal').modal('hide');
            });

            // Remove product row from the table
            $(document).on('click', '.remove_product_row', function () {
                $(this).closest('tr').remove();
            });

            // Submit return stock form
            $('#submit_return').click(function () {
                // Trigger form submission
                $('#product_selection_form').submit();
            });
        });
    </script>

    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function () {
            var companySelect = document.getElementById('company_id');
            var addressField = document.getElementById('address');
            var phoneField = document.getElementById('phone_number');
            var emailField = document.getElementById('email');

            companySelect.addEventListener('change', function () {
                var selectedOption = companySelect.options[companySelect.selectedIndex];
                addressField.value = selectedOption.getAttribute('data-address');
                phoneField.value = selectedOption.getAttribute('data-phone_number');
                emailField.value = selectedOption.getAttribute('data-email');
            });
        });
    </script>
@endpush
