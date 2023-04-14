@extends('backend.layouts.app')


@section('content')

<div class="row">
  <div class="col-md-8">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Product List</h3>
      </div>
      <div class="card-body">
        <table class="table">
          <thead>
            <tr>
              <th>Product Name</th>
              <th>Stock</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($list as $product)
            <tr>
              <td>{{ $product->product_name }}</td>
              <td>{{ $product->remaining_quantity }}</td>
              <td>
                <form method="POST" action="{{ route('cart.store', $product->id) }}">
                  @csrf
                  <div class="input-group input-group-sm">
                    <input min="0" name="quantity" value="0" type="number" class="form-control">
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

  <div class="col-md-4">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Cart</h3>
      </div>
      @if (empty($cart))
      <p>Your cart is empty.</p>
      @else
      <div class="card-body">
        <table class="table">
          <thead>
            <tr>
              <th>Product Name</th>
              <th>Quantity</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($cart as $item)
            <tr>
              <td>{{ $item['name'] }}</td>
              <td>{{ $item['quantity'] }}</td>
              <td>{{ $item['price'] }}</td>
              <td>
                <form method="POST" action="{{ route('cart.remove', $item['id']) }}">
                  @csrf
                  <button type="submit" class="btn btn-danger">Remove</button>
                </form>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        <div class="d-flex justify-content-between align-items-center">
          <h4>Total: {{ $total }}</h4>
          <a href="{{ route('checkout.index') }}" class="btn btn-primary">Checkout</a>
        </div>
         @endif
      </div>
    </div>
  </div>
</div>

@endsection


