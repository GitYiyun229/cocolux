@extends('web.layouts.web')

@section('content')
    <main>

        <div class="container">
            <div class="section-banner-top mb-4">
                <div class="banner-slide">
                    <div class="banner-slick">
                        @forelse($slider as $item)
                        <div>
                            <a href="{!! $item->url !!}">
                                <img src="{{ asset(replace_image($item->image_url)) }}" alt="{{ $item->content }}" class="img-fluid">
                            </a>
                        </div>
                        @empty
                        @endforelse
                    </div>
                </div>
                <div class="banner-wrap">
                    @forelse($subBanner as $item)
                    <a href="{!! $item->url !!}">
                        <img src="{{ asset(replace_image($item->image_url)) }}" alt="{{ $item->content }}" class="img-fluid">
                    </a>
                    @empty
                    @endforelse
                </div>
            </div>

            <div class="section-categories-mobile d-grid d-lg-none mb-4">
                <a href="" class="item-category d-flex flex-column align-items-center text-center text-uppercase" data-bs-toggle="modal" data-bs-target="#categoriesModal">
                    <div class="section-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                    Danh mục
                </a>
                @forelse($cat_products as $item)
                <a href="{{ route('catProduct', ['slug' => $item->slug, 'id' => $item->id]) }}" class="item-category d-flex flex-column align-items-center text-center text-uppercase">
                    <img src="{{ asset(replace_image($item->logo)) }}" alt="{{ $item->title }}" class="img-fluid" onerror="this.src='{{ asset('/images/ic-lazy-load-3.png') }}'">
                    {{ $item->title }}
                </a>
                @empty
                @endforelse
            </div>

            <div class="modal modal-full fade" id="categoriesModal" tabindex="-1" aria-labelledby="categoriesModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body pt-0">
                            @if(!empty($cat_products))
                                @forelse($cat_products as $item)
                                <div class="d-flex gap-1 justify-content-between item-cate">
                                    <a href="{{ route('catProduct', ['slug' => $item->slug, 'id' => $item->id]) }}" class="cate-parent">
                                        {{ $item->title }}
                                    </a>
                                    @if ($item->children)
                                    <a class="btn-collapse" data-bs-toggle="collapse" href="#collapse{{ $item->id }}" role="button" aria-expanded="false" aria-controls="collapse{{ $item->id }}"></a>
                                    @endif
                                </div>

                                @if ($item->children)
                                <div class="collapse" id="collapse{{ $item->id }}">
                                    <div class="card border-0">
                                        @forelse($item->children as $child)
                                            <a href="{{ route('catProduct', ['slug' => $child->slug, 'id' => $child->id]) }}" class="cate-child">
                                                {{ $child->title }}
                                            </a>
                                        @empty
                                        @endforelse
                                    </div>
                                </div>
                                @endif
                                @empty
                                @endforelse
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="section-flash-mobile d-block d-lg-none slide-template bg-white mb-4">
                <div class="slide-top">
                    <div class="slide-title d-flex align-items-center gap-2">
                        <a href="" title="Flash Deal" class="d-flex align-items-center gap-2">
                            <img src="{{ asset('images/hot_icon.svg') }}" alt="flash deal" class="img-fluid" height="18" width="18">
                            <h2>Flash Deal</h2>
                        </a>
                        |
                        <div is-title="true" class="count-down d-flex align-items-center gap-1" time-end="Oct 30 2023 20:00:00"></div>
                    </div>
                    <a href="" class="slide-more">Xem tất cả</a>
                </div>
                <div class="slide-main">
                    <div class="slide-template-slick">
                        @if(!empty($product_hots))
                        @forelse($product_hots as $item)
                        <a href="{{ route('detailProduct',['slug'=>!empty($item->slug)?trim($item->slug):$item->product->slug, 'sku' =>$item->sku]) }}" class="product-template">
                            <div class="product-discount">
                                <span class="pe-1">5%</span>
                            </div>
                            <div class="product-thumbnail">
                                <img src="{{ asset($item->image_first) }}" alt="{{ $item->title }}" class="img-fluid">
                            </div>
                            <div class="product-price">
                                <div class="public-price">{{ format_money($item->price) }}</div>
                                <div class="origin-price">{{ format_money($item->normal_price) }}</div>
                            </div>
                            <div class="product-brand">
                                {{ $item->brand }}
                            </div>
                            <div class="product-title">
                                {{ $item->title }}
                            </div>
                            <div class="product-progress-sale count-down" time-end="Oct 30 2023 20:00:00"></div>
                        </a>
                        @empty
                        @endforelse
                        @endif
                    </div>
                </div>
            </div>

            <div class="slide-template bg-white mb-4">
                <div class="slide-top">
                    <a href="" class="slide-title">
                        <h2>Sản phẩm hot</h2>
                    </a>
                    <a href="" class="slide-more">
                        Xem tất cả
                    </a>
                </div>
                <div class="slide-main">
                    <div class="slide-template-slick">
                        @if(!empty($product_hots))
                        @forelse($product_hots as $item)
                        <a href="{{ route('detailProduct',['slug'=> !empty($item->slug)?trim($item->slug):$item->product->slug, 'sku' =>$item->sku]) }}" class="product-template">
                            <div class="product-discount">
                                <span class="pe-1">5%</span>
                            </div>
                            <div class="product-thumbnail">
                                <img src="{{ asset($item->image_first) }}" alt="{{ $item->title }}" class="img-fluid">
                            </div>
                            <div class="product-price">
                                <div class="public-price">{{ format_money($item->price) }}</div>
                                <div class="origin-price">{{ format_money($item->normal_price) }}</div>
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
                        @endif
                    </div>
                </div>
            </div>

            <div class="slide-template bg-white mb-5">
                <div class="slide-top">
                    <a href="{{ route('homeBrand') }}" class="slide-title">
                        <h3>Thương hiệu nổi bật</h3>
                    </a>
                    <a href="{{ route('homeBrand') }}" class="slide-more">
                        Xem tất cả
                    </a>
                </div>
                <div class="slide-main">
                    <div class="slide-template-slick">
                        @if(!empty($attribute_brand))
                        @forelse($attribute_brand as $item)
                        <a href="{{ route('detailBrand',['slug' => $item->slug,'id' => $item->id]) }}" class="brand-template">
                            <img src="{{ asset(replace_image($item->image)) }}" alt="{{ $item->name }}" class="img-fluid">
                            <div class="title">{{ $item->name }}</div>
                        </a>
                        @empty
                        @endforelse
                        @endif
                    </div>
                </div>
            </div>

            <div class="section-product-category">
                @if(!empty($cats))
                @forelse($cats as $cat)
                <div class="section mb-5">
                    <div class="section-top">
                        <div class="section-menu">
                            <a href="{{ route('catProduct',['slug' => $cat->slug, 'id'=> $cat->id]) }}" class="section-title">
                                <h2 class="text-uppercase mb-0">{{ $cat->title }}</h2>
                            </a>
                            <div class="section-sub-menu">
                                @if(!empty($cat_sub[$cat->id]))
                                @forelse($cat_sub[$cat->id] as $sub)
                                <a href="{{ route('catProduct',['slug' => $sub->slug, 'id'=> $sub->id]) }}" class="text-uppercase">{{ $sub->title }}</a>
                                @empty
                                @endforelse
                                @endif
                            </div>
                        </div>
                        <a href="{{ route('catProduct',['slug' => $cat->slug, 'id'=> $cat->id]) }}" class="section-more text-uppercase">Xem thêm</a>
                    </div>
                    <div class="section-main bg-white">
                        <div class="section-poster">
                            <a href="">
                                <img src="{{ asset(replace_image($cat->image)) }}" alt="" class="img-fluid">
                            </a>
                        </div>
                        <div class="section-content">
                            @if($product_cats && !empty($product_cats[$cat->id]))
                            @forelse($product_cats[$cat->id] as $item)
                            <a href="{{ route('detailProduct',['slug'=> !empty($item->slug)?trim($item->slug):$item->product->slug, 'sku' => $item->sku]) }}" class="product-template">
                                <div class="product-discount">
                                    <span class="pe-1">5%</span>
                                </div>
                                <div class="product-thumbnail">
                                    <img src="{{ asset($item->image_first) }}" alt="{{ $item->title }}" class="img-fluid">
                                </div>
                                <div class="product-price">
                                    <div class="public-price">{{ format_money($item->price) }}</div>
                                    <div class="origin-price">{{ format_money($item->normal_price) }}</div>
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
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                @endforelse
                @endif
            </div>

            <div class="section-banner-middle mb-5">
                @if(!empty($subBanner2))
                @forelse($subBanner2 as $item)
                <a class="" href="{{ $item->url }}">
                    <img alt="{{ $item->title }}" src="{{ asset(replace_image($item->image_url)) }}" class="img-fluid">
                </a>
                @empty
                @endforelse
                @endif
            </div>

            <div class="section-article mb-5">
                <div class="section-top">
                    <a href="{{ route('homeArticle') }}">
                        <h2 class="text-uppercase">Tin tức & sự kiện</h2>
                    </a>
                    <a href="{{ route('homeArticle') }}" class="text-uppercase">Xem tất cả</a>
                </div>
                <div class="section-main">
                    @if(!empty($articles))
                    @forelse($articles as $item)
                    <a href="{{ route('detailArticle',['slug'=>$item->slug,'id'=>$item->id]) }}" class="article-item" title="{{ $item->title }}">
                        <div class="article-img">
                            <img src="{{ asset(replace_image($item->image)) }}" alt="{{ $item->title }}" class="img-fluid">
                        </div>
                        <div class="article-title">
                            <span>
                                {{ $item->description }}
                            </span>
                        </div>
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
    <link href="{{ asset('js/web/slick/slick.css') }}" rel="stylesheet">
    <link href="{{ asset('js/web/slick/slick-theme.css') }}" rel="stylesheet">
    <link href="{{ asset('css/web/home.css') }}" rel="stylesheet">
@endsection

@section('script')
    @parent
    <script src="{{ asset('/js/web/slick/slick.js') }}"></script>
    <script src="{{ asset('/js/web/slick/slick.js') }}"></script>
    <script>
        $('.banner-slick').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: true,
            dots: true,
            infinite: true,
            autoplay: true,

        });

        $('.slide-template-slick').slick({
            slidesToShow: 5,
            slidesToScroll: 5,
            arrows: true,
            dots: false,
            infinite: true,
            autoplay: true,
            responsive: [
                {
                    breakpoint: 960,
                    settings: {
                        slidesToShow: 2.5,
                        slidesToScroll: 2
                    }
                }
            ]
        });

        $(".count-down").each(function (e) {
            countdowwn($(this));
        });

        function countdowwn(element) {
            let is_title = element.attr('is-title');
            let e = element.attr('time-end');
            let l = new Date(e).getTime();
            let n = setInterval(function () {
                let e = new Date().getTime();
                let t = l - e;
                let a = Math.floor(t / 864e5);
                let s = Math.floor((t % 864e5) / 36e5);
                let o = Math.floor((t % 36e5) / 6e4);
                e = Math.floor((t % 6e4) / 1e3);

                if (is_title) {
                    element.html(`
                        <span>${a}</span>
                        :
                        <span>${s}</span>
                        :
                        <span>${o}</span>
                        :
                        <span>${e}</span>
                    `);
                } else {
                    element.html(`
                        <span>Còn ${a} ngày</span>

                        <span>${s}</span>
                        :
                        <span>${o}</span>
                        :
                        <span>${e}</span>
                    `);
                }

                if (t < 0) {
                    clearInterval(n), element.html("Đã hết khuyến mại")
                };

            }, 1e3);
        }
    </script>
@endsection
