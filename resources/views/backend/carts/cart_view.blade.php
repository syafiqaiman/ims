
@section('contents')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>Shopping Cart</h2>
            @if (empty($cart))
                <p>Your cart is empty.</p>
            @else
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($list as $item)
                            <tr>
                                <td>{{ $item->product_name }}</td>
                                <td>{{ $cart[$item->id]['quantity'] }}</td>
                                <td>
                                    <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                                    </form>
                                </td>
                            </tr>
                            @php
                                $subtotal = $cart[$item->id]['quantity'] * $cart[$item->id]['price'];
                                $total += $subtotal;
                            @endphp
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
@endsection
