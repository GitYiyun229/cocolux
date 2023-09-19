@extends('web.layouts.web')

@section('content')
    <div class="top-content-products">
        <div class="container">
            <h1 class="title-page">Thực đơn</h1>
            <ul class="list-unstyled list-menu-page">
                <li>
                    <a href="{{ route('productHome') }}" title="Thực đơn" >Tất cả</a>
                </li>
                @if(!empty($cats))
                    @forelse($cats as $k => $item)
                        <li>
                            <a href="{{ route('productCat', $item->slug) }}" title="{{ $item->title }}" class="@if (request()->fullUrlIs(route('productCat', $item->slug))) active @endif">{{ $item->title }}</a>
                        </li>
                    @empty
                    @endforelse
                @endif
            </ul>
        </div>
    </div>
    <div class="list-products-home">
        <div class="container">
            <div class="row g-0 mg-for-product">
                @if(!empty($products))
                    @forelse($products as $k => $item)
                        <div class="col-md-4 item-product">
                            <div class="image-product-item d-block position-relative">
                                @include('web.components.image', ['src' => $item->image_resize['resize'], 'title' => $item->title])
                                <span class="position-absolute top-50 start-50 translate-middle w-100 h-100 bg-hover-black"></span>
                                <div class="m-0 position-absolute top-50 start-50 translate-middle add-to-cart-cat">
                                    <ul class="list-unstyled">
                                        <li class="mb-2"><a class="btn-danger btn" href="{{ route('productDetail',['slugCat'=>$item->category->slug,'slug'=>$item->slug]) }}">Xem chi tiết <i class="fas fa-chevron-right"></i></a></li>
                                        <li><button class="btn btn-warning cartToastBtn" onclick="order({{ $item->id }})">Thêm giỏ hàng <i class="fas fa-cart-plus"></i></button></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="box-item-detail">
                                <a href="{{ route('productDetail',['slugCat'=>$item->category->slug,'slug'=>$item->slug]) }}" title="{{ $item->title }}">
                                    <h4 class="title-product">{{ $item->title }}</h4>
                                </a>
                                <p class="price-product">{{ format_money($item->price) }}</p>
                            </div>
                        </div>
                    @empty
                    @endforelse
                @endif
            </div>
            {{ $products->links('web.components.pagination') }}
        </div>
    </div>
@endsection

@section('link')
    @parent
    <link rel="stylesheet" href="{{ asset('/css/web/products-home.css') }}">
@endsection

@section('script')
    @parent
@endsection
