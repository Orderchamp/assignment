@extends('layouts.app')

@section('content')
    <div class="px-4 px-lg-0">
        <!-- For demo purpose -->
        <div class="container pt-2 pb-4 text-center">
            <h1 class="display-4">Shopping cart</h1>
        </div>
        <!-- End -->

        <div class="pb-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 p-5 bg-white rounded shadow-sm mb-5">

                        <!-- Shopping cart table -->
                        @if(count($cartItems) > 0)
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col" class="border-0 bg-light">
                                            <div class="p-2 px-3 text-uppercase">Product</div>
                                        </th>
                                        <th scope="col" class="border-0 bg-light">
                                            <div class="py-2 text-uppercase">Price</div>
                                        </th>
                                        <th scope="col" class="border-0 bg-light">
                                            <div class="py-2 text-uppercase">Quantity</div>
                                        </th>
                                        <th scope="col" class="border-0 bg-light">
                                            <div class="py-2 text-uppercase">Total</div>
                                        </th>
                                        <th scope="col" class="border-0 bg-light">
                                            <div class="py-2 text-uppercase">Remove</div>
                                        </th>
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
                                            <th scope="row" class="border-0">
                                                <div class="p-2">
                                                    <img src="{{ $product->image }}" alt="" width="70" class="img-fluid rounded shadow-sm">
                                                    <div class="ml-3 d-inline-block align-middle">
                                                        <h5 class="mb-0">
                                                            <a href="#" class="text-dark d-inline-block align-middle">{{ $product->name }}</a>
                                                        </h5>
                                                        <span class="text-muted font-weight-normal font-italic d-block"></span>
                                                    </div>
                                                </div>
                                            </th>
                                            <td class="border-0 align-middle"><strong>{{ $product->price }}</strong></td>
                                            <td class="border-0 align-middle"><strong>{{ $quantity }}</strong></td>
                                            <td class="border-0 align-middle"><strong>{{ $product->price * $quantity }}</strong></td>
                                            <td class="border-0 align-middle">
                                                <form action="{{ route('cart.destroy') }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="cart_item_id" value="{{ $groupedCartItems->first()->product_id }}">
                                                    <button type="submit" class="btn btn-danger">Remove</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p>Your cart is empty.</p>
                        @endif
                        <!-- End -->
                    </div>
                </div>

                <div class="row py-5 p-4 bg-white rounded shadow-sm">
                    <div class="col-lg-6">
                        <div class="bg-light rounded-pill px-4 py-3 text-uppercase font-weight-bold">Order summary</div>
                        <div class="p-4">
                            <p class="font-italic mb-4">Shipping and additional costs are calculated based on values you have entered.</p>
                            <ul class="list-unstyled mb-4">
                                <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Order Subtotal </strong><strong>{{ $total }}</strong></li>
                                <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Total</strong>
                                    <h5 class="font-weight-bold">{{ $total }}</h5>
                                </li>
                            </ul>
                            <a href="{{ route('checkout.index') }}" class="btn btn-dark rounded-pill py-2 btn-block">Procceed to checkout</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
