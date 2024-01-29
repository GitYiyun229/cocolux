@extends('web.layouts.web')

@section('content')
    <main>

        <div class="container">
            <div class="layout-page-deal-detail mb-5">
                <div class="layout-nav bg-white d-flex align-items-center mb-3">
                    <a href="{{ route('dealHotProducts') }}" class="fw-bold text-uppercase fs-6 text-danger">Sản phẩm hot</a>
                </div>

                <div class="layout-detail-main bg-white d-grid mb-4">
                    @if(!empty($productOptions))
                        @forelse($productOptions as $item)
                            <a href="{{ route('detailProduct',['slug'=>!empty($item->slug)?trim($item->slug):trim($item->product->slug), 'sku' =>$item->sku]) }}" class="product-template">
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
                                <div class="product-thumbnail">
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
                    @else
                        <p class="text-center">Không có deal khuyến mãi</p>
                    @endif
                </div>

                {{ $productOptions->links('web.components.pagination') }}
            </div>
        </div>

    </main>
@endsection

@section('link')
    @parent
    <link rel="stylesheet" href="{{ mix('css/web/deal-detail.css') }}">
@endsection

@section('script')
    @parent
    <script src="{{ mix('js/app.js') }}"></script>
    @include('web.components.extend')
@endsection
