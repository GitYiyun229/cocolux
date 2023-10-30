@extends('web.layouts.web')

@section('content')
    <main>

        <div class="container">
            <div class="layout-page-deal-detail mb-5">
                <div class="layout-banner mb-3">
                    <img src="{{ $promotion->thumbnail_url }}" alt="{{ $promotion->name }}" class="img-fluid w-100">
                </div>
                <div class="layout-detail-main bg-white d-grid">
                    @if(!empty($productOptions))
                    @forelse($productOptions as $item)
                    <a href="{{ route('detailProduct',['slug' => !empty($item->slug)?trim($item->slug):trim($item->product->slug),'sku' => $item->sku]) }}" class="product-template">
                        @if($item->price != $item->normal_price)
                            <div class="product-discount">
                                <span class="pe-1">{{ percentage_price($item->price, $item->normal_price) }}</span>
                            </div>
                        @endif
                        <div class="product-thumbnail">
                            <img src="{{ (json_decode($item->images)) ? json_decode($item->images)[0] : '' }}" alt="{{ $item->title }}" class="img-fluid">
                        </div>
                        <div class="product-price">
                            <div class="public-price">{{ format_money($item->price) }}</div>
                            @if($item->price != $item->normal_price)
                                <div class="origin-price">{{ format_money($item->normal_price) }}</div>
                            @endif
                        </div>
                        <div class="product-brand">
                            {{ $item->brand }}
                        </div>
                        <div class="product-title">
                            {{ $item->title }}
                        </div>
                        <div class="product-progress-sale count-down" time-end="{{ \Carbon\Carbon::parse($promotion->applied_stop_time)->format('M d Y H:i:s') }}"></div>
                    </a>
                    @empty
                    @endforelse
                    @endif
                </div>
            </div>
        </div>

    </main>
@endsection

@section('link')
    @parent
    <link rel="stylesheet" href="{{ asset('/css/web/deal-detail.css') }}">
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
