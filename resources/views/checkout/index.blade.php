@extends('layouts.app')

@section('content')
    <div class="container">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row">
            <div class="col-md-4 order-md-2 mb-4">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted">Your cart</span>
                    <span class="badge badge-secondary badge-pill">@if(count($products) > 0)
                            {{ count($products) }}
                        @endif</span>
                </h4>
                <ul class="list-group mb-3">
                    @if(count($products) > 0)
                        @foreach($products as $id => $product)
                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                <div>
                                    <h6 class="my-0">{{ $product->name }}</h6>
                                    <small class="text-muted">x{{ $product->quantity }}</small>
                                </div>
                                <span class="text-muted">{{ $product->quantity * $product->price }}</span>
                            </li>
                        @endforeach
                    @endif

                    <li class="list-group-item d-flex justify-content-between">
                        <span>Total (USD)</span>
                        <strong>{{ $total }}</strong>
                    </li>
                </ul>

                <form class="card p-2">
                    <div class="input-group">
                        <input disabled type="text" class="form-control" placeholder="Promo code"">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-secondary">Redeem</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-8 order-md-1">
                <h4 class="mb-3">Billing Information</h4>
                <form action="{{ route('checkout.store') }}" novalidate method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="" value="{{ auth()->check() ? auth()->user()->name : old('name') ?? '' }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="email">Email </label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ auth()->check() ? auth()->user()->email : old('email') ?? '' }}" placeholder="you@example.com">
                        <div class="invalid-feedback">
                            Please enter a valid email address for shipping updates.
                        </div>
                    </div>

                    <div id="password-field" class="mb-3">
                        <label for="password">Password </label>
                        <input type="password" class="form-control" id="password" name="password" value="{{ old('password') ?? '' }}" placeholder="*******">
                        <div class="invalid-feedback">
                            Please enter a valid password.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" name="address" value="{{ old('address') ?? '' }}" placeholder="1234 Main St" required>
                        <div class="invalid-feedback">
                            Please enter your shipping address.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="phone">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') ?? '' }}" placeholder="123891298" required>
                        <div class="invalid-feedback">
                            Please enter your phone number.
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-5 mb-3">
                            <label for="country">Country</label>
                            <select class="custom-select d-block w-100" id="country" name="country" required>
                                <option value="">Choose...</option>
                                <option value="GR">Greece</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select a valid country.
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="city">State</label>
                            <select class="custom-select d-block w-100" id="city" name="city" required>
                                <option value="">Choose...</option>
                                <option value="Thessaloniki">Thessaloniki</option>
                                <option value="Athens">Athens</option>
                            </select>
                            <div class="invalid-feedback">
                                Please provide a valid state.
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="zip">Zip</label>
                            <input type="text" class="form-control" id="zip" name="zip" value="{{ old('zip') ?? '' }}" placeholder="" required>
                            <div class="invalid-feedback">
                                Zip code required.
                            </div>
                        </div>
                    </div>
                    @if(!@auth()->check())
                        <hr class="mb-4">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="has-password" id="has-password">
                            <label class="custom-control-label" for="has-password">Also create an account?</label>
                        </div>
                    @endif
                    <div class="mb-4"></div>
                    <button class="btn btn-primary btn-lg btn-block" type="submit">Complete order</button>
                </form>
            </div>
        </div>
    </div>
@endsection
