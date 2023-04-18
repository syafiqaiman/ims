@extends('backend.layouts.app')


@section('content')

<!-- Product List -->
<div class="row">
  <div class="col-md-8">
    <div class="card card-primary">
      <div class="card-header info">
        <h3 class="card-title">Product List</h3>
      </div>
      <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Product Image</th>
              <th>Product Name</th>
              <th>Stock</th>
              <th>Add To Cart</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($list as $product)
            <tr>
              <td><img src="{{ asset('storage/Image/'.$product->product_image) }}" style="height: 40px; width: 60px;"></td>
              <td>{{ $product->product_name }}</td>
              <td>{{ $product->remaining_quantity }}</td>
              <td>
                <form method="POST" action="{{ route('cart.add', $product->id) }}">
                  @csrf
                  <div class="input-group input-group-sm">
                      <input type="hidden" value="{{ $product->id }}" name="id">
                        <input type="hidden" value="{{ $product->product_name }}" name="product_name">
                        <input type="hidden" value="{{ $product->weight_per_item }}" name="weight_per_item">
                        <input type="hidden" value="{{ $product->product_image }}"  name="product_image">
                        <input type="hidden" value="1" name="quantity">
                    <span class="input-group-append">
                      <button type="submit" class="btn btn-info btn-flat">Add to Cart</button>
                    </span>
                  </div>
                </form>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
<!-- Cart -->
<div class="col-md-4">
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Selected Product</h3>
    </div>
    @if (empty(session('cart')))
    <p>Your cart is empty.</p>
    @else
    <div class="card-body">
      <table class="table">
        <thead>
          <tr>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Image</th>
          </tr>
        </thead>
        <tbody>
          @foreach (session('cart') as $id => $item)
          <tr>
            <td>{{ $item['name'] }}</td>
            <td>
              <form method="POST" action="{{ route('cart.update', $id) }}">
                @csrf
                <div class="input-group input-group-sm">
                  <input min="0" name="quantity" value="{{ $item['quantity'] }}" type="number" class="form-control">
                  <span class="input-group-append">
                    <button type="submit" class="btn btn-info btn-flat">Update</button>
                  </span>
                </div>
              </form>
            </td>
            <td><img src="{{ asset('storage/Image/'.$item['image']) }}" style="height: 40px; width: 60px;"></td>
            <td>
              <form method="POST" action="{{ route('cart.remove', $id) }}">
                @csrf
                <button type="submit" class="close">x</button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      <div class="d-flex justify-content-between align-items-center">
        <h4>Total: {{ session('total') }}</h4>
        <a href="{{ route('checkout.index') }}" class="btn btn-primary">Checkout</a>
      </div>
       @endif
    </div>
  </div>
</div>
</div>

@endsection


