@extends('web.layouts.web')

@section('content')
    <div class="top-content-product">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    @include('web.components.image', ['src' => $product->image_resize['lager'], 'title' => $product->title])
                </div>
                <div class="col-md-6">
                    <h1 class="title-product">{{ $product->title }}</h1>
                    <p class="price-product">{{ number_format($product->price, 0, ',', '.') }}đ</p>
                    <hr class="my-3">
                    <div class="content-product">{!! $product->content_include !!}</div>
                    <div class="d-flex number-add-to-cart">
                        <div class="number-input me-3">
                            <button onclick="this.parentNode.querySelector('input.quantity').stepDown()"></button>
                            <input type="number" min="1" name="quantity" id="quantity" class="quantity" value="1">
                            <button onclick="this.parentNode.querySelector('input.quantity').stepUp()" class="plus"></button>
                        </div>
                        <button type="button" class="w-100 btn btn-danger btn-add-to-cart cartToastBtn" id="cartToastBtn" onclick="order({{ $product->id }})">Thêm vào giỏ hàng <i class="fas fa-angle-right"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="list-product-home">
        <div class="container">
            <div class="box-list-top">
                <h4 class="title-article-other">Các món khác</h4>
                <div class="row g-0 mg-for-product">
                    @if(!empty($products))
                        @forelse($products as $k => $item)
                            <div class="col-md-4 item-product">
                                <a href="{{ route('productDetail',['slugCat'=>$item->category->slug,'slug'=>$item->slug]) }}" title="{{ $item->title }}">
                                    @include('web.components.image', ['src' => $item->image_resize['resize'], 'title' => $item->title])
                                    <h4 class="title-product">{{ $item->title }}</h4>
                                </a>
                                <p class="price-product">{{ number_format($item->price, 0, ',', '.') }}đ</p>
                            </div>
                        @empty
                        @endforelse
                    @endif
                </div>
            </div>
            <div class="box-list-add">
                <h4 class="title-article-other">các món gọi thêm</h4>
                <div class="row g-0 mg-for-product">
                    @if(!empty($products))
                        @forelse($products as $k => $item)
                            <div class="col-md-4 item-product">
                                <a href="{{ route('productDetail',['slugCat'=>$item->category->slug,'slug'=>$item->slug]) }}" title="{{ $item->title }}">
                                    @include('web.components.image', ['src' => $item->image_resize['resize'], 'title' => $item->title])
                                    <h4 class="title-product">{{ $item->title }}</h4>
                                </a>
                                <p class="price-product">{{ number_format($item->price, 0, ',', '.') }}đ</p>
                            </div>
                        @empty
                        @endforelse
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('link')
    @parent
    <link rel="stylesheet" href="{{ asset('/css/web/product-detail.css') }}">
@endsection

@section('script')
    @parent
@endsection
