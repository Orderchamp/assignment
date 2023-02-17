@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    @foreach ($products as $product)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card h-100">
                                <a href="#"><img class="card-img-top" src="{{ $product->image }}" alt=""></a>
                                <div class="card-body">
                                    <h4 class="card-title">
                                        <a href="#">{{ $product->name }}</a>
                                    </h4>
                                    <h5>${{ $product->price }}</h5>
                                    <p class="card-text">{{ $product->description }}</p>
                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-lg-6 d-flex text-right justify-content-start align-items-center">
                                            <button class="btn btn-primary @if($product->quantity === 0) disabled @else add-to-cart-btn @endif" data-product-id="{{ $product->id }}">
                                                Add to Cart
                                            </button>
                                        </div>
                                        <div class="col-lg-6 d-flex text-right justify-content-end align-items-center">
                                            Qty: {{ $product->quantity }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                {{ $products->links() }}
            </div>
        </div>
    </div>
@endsection
