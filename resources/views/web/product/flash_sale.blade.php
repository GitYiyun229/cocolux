@extends('web.layouts.web')

@section('content')
    <main>

        <div class="container">
            <div class="layout-page-deal-detail mb-5">
                <div class="layout-nav bg-white d-flex align-items-center mb-3">
                    <a href="{{ route('dealHotProducts') }}" class="fw-bold text-uppercase fs-6">Hot Deals</a>
                    <a href="{{ route('flashSaleProducts') }}" class="fw-bold text-uppercase fs-6 text-danger">Flash Deal</a>
                    <a href="{{ route('dealNowProducts') }}" class="fw-bold text-uppercase fs-6">Đang diễn ra</a>
                </div>

                <div class="layout-detail-main bg-white d-grid mb-4">
                    @if(count($productOptions))
                        @forelse($productOptions as $item)
                            @if(isset($item->slug))
                            <a href="{{ route('detailProduct',['slug'=>$item->slug, 'sku' =>$item->sku]) }}" class="product-template">
                                @if($item->promotionItem->price != $item->normal_price)
                                    <div class="product-discount">
                                        <span class="pe-1">{{ percentage_price($item->promotionItem->price, $item->normal_price) }}</span>
                                    </div>
                                @endif
                                <div class="product-thumbnail">
                                    <img src="{{ asset($item->image_first) }}" alt="{{ $item->title }}" class="img-fluid">
                                </div>
                                <div class="product-price">
                                    <div class="public-price">{{ format_money($item->promotionItem->price) }}</div>
                                    @if($item->promotionItem->price != $item->normal_price)
                                        <div class="origin-price">{{ format_money($item->normal_price) }}</div>
                                    @endif
                                </div>
                                <div class="product-brand">
                                    {{ $item->brand }}
                                </div>
                                <div class="product-title">
                                    {{ $item->title }}
                                </div>
                                @if($item->promotionItem && $item->promotionItem->applied_stop_time)
                                    <div class="product-progress-sale count-down" time-end="{{ $item->promotionItem->applied_stop_time }}"></div>
                                @endif
                            </a>
                            @else
                            @endif
                        @empty
                        @endforelse
                    @else
                        <p class="text-center">Không có deal khuyến mãi</p>
                    @endif
                </div>
                @if(count($productOptions))
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
    <script>
        $(".count-down").each(function (e) {
            countdowwn($(this));
        });

        function countdowwn(element) {
            let e = element.attr('time-end');
            let l = new Date(e).getTime();
            let n = setInterval(function () {
                let e = new Date().getTime();
                let t = l - e;
                let a = Math.floor(t / 864e5);
                let s = Math.floor((t % 864e5) / 36e5);
                let o = Math.floor((t % 36e5) / 6e4);
                e = Math.floor((t % 6e4) / 1e3);

                element.html(`
            <span>Còn ${a} ngày</span>

            <span>${s}</span>
            :
            <span>${o}</span>
            :
            <span>${e}</span>
        `);

                if (t < 0) {
                    clearInterval(n), element.html("Đã hết khuyến mại")
                };
            }, 1e3);
        }
    </script>
@endsection
