@extends('web.layouts.web')

@section('content')
    <main>

        <div class="container">
            <div class="layout-page-sale mb-5">
                <div class="layout-nav-top d-flex align-items-center bg-white justify-content-between mb-3">
                    <div class="layout-nav d-flex align-items-center ">
                        <a href="" class="fw-bold text-uppercase fs-6 text-danger">Hàng mới về</a>
                    </div>
                </div>

                <div class="layout-sale-main bg-white d-grid mb-4">
                    @forelse($products as $item)
                    <a href="{{ route('detailProduct',['slug' => trim($item->slug),'sku' => $item->sku]) }}" class="product-template">
                        @if($item->promotionItem)
                            @if($item->promotionItem->price != $item->normal_price)
                                <div class="product-discount">
                                    <span class="pe-1">{{ percentage_price($item->promotionItem->price, $item->normal_price) }}</span>
                                </div>
                            @endif
                        @else
                            @if($item->price != $item->normal_price)
                                <div class="product-discount">
                                    <span class="pe-1">{{ percentage_price($item->price, $item->normal_price) }}</span>
                                </div>
                            @endif
                        @endif
                        <div class="product-thumbnail @if($item->promotionItem && $item->promotionItem->applied_stop_time) image-frame @endif">
                            <img src="{{ asset($item->image_first) }}" alt="{{ $item->title }}" class="img-fluid">
                        </div>
                        <div class="product-price">
                            @if($item->promotionItem)
                                <div class="public-price">{{ format_money($item->promotionItem->price) }}</div>
                                @if($item->promotionItem->price != $item->normal_price)
                                    <div class="origin-price">{{ format_money($item->normal_price) }}</div>
                                @endif
                            @else
                                <div class="public-price">{{ format_money($item->price) }}</div>
                                @if($item->price != $item->normal_price)
                                    <div class="origin-price">{{ format_money($item->normal_price) }}</div>
                                @endif
                            @endif
                        </div>
                        <div class="product-brand">
                           {{ $item->brand }}
                        </div>
                        <div class="product-title">
                            {{ $item->title }}
                        </div>
                    </a>
                    @empty
                    @endforelse
                </div>
                {{ $products->links('web.components.pagination') }}
            </div>
        </div>

    </main>
@endsection

@section('link')
    @parent
    <link rel="stylesheet" href="{{ mix('css/web/sale.css') }}">
@endsection

@section('script')
    @parent
    <script src="{{ mix('js/web/product-new.js') }}"></script>
    @include('web.components.extend')
@endsection
