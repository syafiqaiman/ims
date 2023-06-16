@extends('backend.layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Delivery Form</h3>
        </div>
        <form method="POST" action="{{ URL::to('/delivery/form_sent') }}">


            @csrf
        <div class="card-body">
            
                <div class="row">
                    <div class="col-md-6">

                        <!-- Sender Name -->
                        <div class="form-group">
                            <label for="sender_name">Sender Name</label>
                            <input type="text" class="form-control" id="sender_name" name="sender_name" placeholder="Enter sender's name">
                        </div>

                        <!-- Sender Address -->
                        <div class="form-group">
                            <label for="sender_address">Sender Address</label>
                            <textarea class="form-control" id="sender_address" name="sender_address" rows="3" placeholder="Enter sender address"></textarea>
                        </div>

                        <!-- Sender Postcode -->
                        <div class="form-group">
                            <label for="sender_postcode">Sender Postcode</label>
                            <input type="text" class="form-control" id="sender_postcode" name="sender_postcode" placeholder="Enter sender postcode">
                        </div>

                        <!-- Sender State -->
                        <div class="form-group">
                            <label for="sender_state">Sender State</label>
                            <select class="form-control" id="sender_state" name="sender_state">
                                <option value="Johor">Johor</option>
                                <option value="Kedah">Kedah</option>
                                <option value="Kelantan">Kelantan</option>
                                <option value="Kuala Lumpur">Kuala Lumpur</option>
                                <option value="Labuan">Labuan</option>
                                <option value="Malacca">Malacca</option>
                                <option value="Negeri Sembilan">Negeri Sembilan</option>
                                <option value="Pahang">Pahang</option>
                                <option value="Perak">Perak</option>
                                <option value="Perlis">Perlis</option>
                                <option value="Penang">Penang</option>
                                <option value="Sabah">Sabah</option>
                                <option value="Sarawak">Sarawak</option>
                                <option value="Selangor">Selangor</option>
                                <option value="Terengganu">Terengganu</option>
                            </select>
                        </div>

                        <!-- Sender Phone Number -->
                        <div class="form-group">
                            <label for="sender_phone">Sender Phone Number</label>
                            <input type="text" class="form-control" id="sender_phone" name="sender_phone" placeholder="Enter sender phone number">
                        </div>
                    </div>
                    <div class="col-md-6">

                        <!-- Receiver Name -->
                        <div class="form-group">
                            <label for="receiver_name">Receiver Name</label>
                            <input type="text" class="form-control" id="receiver_name" name="receiver_name" placeholder="Enter receiver's name">
                        </div>

                        <!-- Receiver Address -->
                        <div class="form-group">
                            <label for="receiver_address">Receiver Address</label>
                            <textarea class="form-control" id="receiver_address" name="receiver_address" rows="3" placeholder="Enter receiver address"></textarea>
                        </div>

                        <!-- Receiver Postcode -->
                        <div class="form-group">
                            <label for="receiver_postcode">Receiver Postcode</label>
                            <input type="text" class="form-control" id="receiver_postcode" name="receiver_postcode" placeholder="Enter receiver postcode">
                        </div>


                        <!-- Receiver State -->
                        <div class="form-group">
                            <label for="receiver_state">Receiver State</label>
                            <select class="form-control" id="receiver_state" name="receiver_state">
                                <option value="Johor">Johor</option>
                                <option value="Kedah">Kedah</option>
                                <option value="Kelantan">Kelantan</option>
                                <option value="Kuala Lumpur">Kuala Lumpur</option>
                                <option value="Labuan">Labuan</option>
                                <option value="Malacca">Malacca</option>
                                <option value="Negeri Sembilan">Negeri Sembilan</option>
                                <option value="Pahang">Pahang</option>
                                <option value="Perak">Perak</option>
                                <option value="Perlis">Perlis</option>
                                <option value="Penang">Penang</option>
                                <option value="Sabah">Sabah</option>
                                <option value="Sarawak">Sarawak</option>
                                <option value="Selangor">Selangor</option>
                                <option value="Terengganu">Terengganu</option>
                            </select>
                        </div>

                        <!-- Receiver Phone Number -->
                        <div class="form-group">
                            <label for="receiver_phone">Receiver Phone Number</label>
                            <input type="text" class="form-control" id="receiver_phone" name="receiver_phone" placeholder="Enter receiver phone number">
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
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>{{ $product->product_name }}</td>
                                    <td>
                                        <input type="number" name="quantities[{{ $product->id }}]" value="{{ old('quantities.' . $product->id) }}" class="form-control">
                                    </td>
                                    <td>
                                        <button class="btn btn-danger btn-sm remove_product_row">Remove</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-primary" id="add_product">Add Product</button>
                </div>


                <!-- Product Modal -->
                <div class="modal fade" id="product_modal" tabindex="-1" role="dialog" aria-labelledby="product_modal_label" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="product_modal_label">Select Product</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- Product Selection Form -->
                                <form id="product_selection_form">
                                    <div class="form-group">
                                        <label for="product_name">Product Name</label>
                                        <select class="form-control" id="product_name" name="product_name[]">
                                            @foreach ($products as $product)
                                                <option value="{{ $product->product_name }}">{{ $product->product_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="quantity">Quantity</label>
                                        <input type="number" class="form-control" id="quantity" name="quantity[]" placeholder="Enter quantity">
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
                <button class="btn btn-primary" id="submit_delivery">Submit</button>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
            <script>
                $(document).ready(function() {
            // Show product modal
            $('#add_product').click(function() {
                $('#product_modal').modal('show');
            });

            // Add product row to the table
            $('#add_product_row').click(function() {
                // Add the product row to the table without refreshing the page
                var product_name = $('#product_name').val();
                var quantity = $('#quantity').val();

                var newRow = '<tr>' +
                    '<td>' + product_name + '</td>' +
                    '<td>' + quantity + '</td>' +
                    '<td><button class="btn btn-danger btn-sm remove_product_row">Remove</button></td>' +
                    '</tr>';

                $('#product_table tbody').append(newRow);

                // Clear the modal form
                $('#product_selection_form')[0].reset();

                // Close the modal
                $('#product_modal').modal('hide');
            });

            // Remove product row from the table
            $(document).on('click', '.remove_product_row', function() {
                $(this).closest('tr').remove();
            });

        });

    </script>
@endpush
