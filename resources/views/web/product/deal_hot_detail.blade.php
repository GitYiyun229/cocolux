@extends('web.layouts.web')

@section('content')
    <main>

        <div class="container">
            <div class="layout-page-deal-detail mb-5">
                <div class="layout-banner mb-3">
                    @if (!empty($promotion_hots->thumbnail_url))
                        <img src="{{ asset($promotion_hots->thumbnail_url) }}" alt="{{ $promotion_hots->name }}"
                            class="img-fluid w-100">
                    @endif
                </div>
                <div class="layout-detail-main bg-white d-grid mb-4">
                    @if (!empty($productOptions))
                        @forelse($productOptions as $item)
                            @if (empty($item->slug) || empty($item->sku))
                                <p>Missing slug or sku for item: {{ $item->title }}</p>
                            @else
                                <a href="{{ route('detailProduct', ['slug' => $item->slug, 'sku' => $item->sku]) }}"
                                    class="product-template">
                                    @if ($item->promotionItem && $item->promotionItem->price != $item->normal_price)
                                        <div class="product-discount">
                                            <span
                                                class="pe-1">{{ percentage_price($item->promotionItem->price, $item->normal_price) }}</span>
                                        </div>
                                    @endif
                                    <div
                                        class="product-thumbnail position-relative @if ($item->promotionItem && $item->promotionItem->applied_stop_time) image-frame2 @endif">
                                        <img src="{{ asset($item->image_first) }}" alt="{{ $item->title }}"
                                            class="img-fluid">
                                        @if ($setting['frame_image_for_sale'])
                                            <div class="position-absolute top-0 bottom-0"> <img
                                                    src="{{ asset($setting['frame_image_for_sale']) }}" alt="">
                                            </div>
                                        @endif
                                    </div>
                                    <div class="product-price">
                                        @if (isset($item->promotionItem))
                                            <div class="public-price">{{ format_money($item->promotionItem->price) }}</div>
                                        @endif
                                        @if ($item->promotionItem && $item->promotionItem->price != $item->normal_price)
                                            <div class="origin-price">{{ format_money($item->normal_price) }}</div>
                                        @endif
                                    </div>
                                    <div class="product-brand" style="height: 18px">
                                        {{ $item->brand }}
                                    </div>
                                    <div class="product-title">
                                        {{ $item->title }}
                                    </div>
                                    @if ($promotion_hots->applied_stop_time)
                                        <div class="product-progress-sale count-down"
                                            time-end="{{ $promotion_hots->applied_stop_time }}"></div>
                                    @endif
                                </a>
                            @endif
                        @empty
                        @endforelse
                    @endif
                </div>
                @if ($productOptions)
                    {{ $productOptions->links('web.components.pagination') }}
                @endif
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
    <script src="{{ mix('js/web/product-deal-hot.js') }}"></script>
    @include('web.components.extend')
@endsection
