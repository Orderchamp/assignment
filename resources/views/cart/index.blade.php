@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Shopping Cart</h1>
        @if(count($cartItems) > 0)
            <table class="table">
                <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($cartItems as $productId => $groupedCartItems)
                    @php
                        $product = $groupedCartItems->first()->product;
                        $quantity = $groupedCartItems->sum('quantity');
                        $subtotal = $quantity * $product->price;
                    @endphp

                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->price }}</td>
                        <td>
                            <form action="" method="POST">
                                @csrf
                                <div class="form-group d-flex">
                                    <button type="submit" class="btn btn-link"><i class="fa fa-minus-circle"></i></button>
                                    <input type="number" name="quantity" class="form-control" value="{{ $quantity }}" min="1" max="{{ $product->quantity }}">
                                    <button type="submit" class="btn btn-link">Update</button>
                                </div>
                            </form>
                        </td>
                        <td>{{ $product->price * $quantity }}</td>
                        <td>
                            <form action="{{ route('cart.destroy') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="cart_item_id" value="{{ $groupedCartItems->first()->product_id }}">
                                <button type="submit" class="btn btn-danger">Remove</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="3"><strong>Total</strong></td>
                    <td><strong>{{ $total }}</strong></td>
                    <td></td>
                </tr>
                </tbody>
            </table>
            <div class="d-flex justify-content-end">
                <a href="{{ route('checkout.index') }}" class="btn btn-primary">Checkout</a>
            </div>
        @else
            <p>Your cart is empty.</p>
        @endif
    </div>
@endsection
