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
                                <img src="{{ asset($item->image_url) }}" alt="{{ $item->content }}" class="img-fluid">
                            </a>
                        </div>
                        @empty
                        @endforelse
                    </div>
                </div>
                <div class="banner-wrap">
                    @forelse($subBanner as $item)
                    <a href="{!! $item->url !!}">
                        <img src="{{ asset($item->image_url) }}" alt="{{ $item->content }}" class="img-fluid">
                    </a>
                    @empty
                    @endforelse
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
                        @forelse($product_hots as $item)
                        <a href="" class="product-template">
                            <div class="product-discount">
                                <span class="pe-1">5%</span>
                            </div>
                            <div class="product-thumbnail">
                                <img src="{{ asset($item->image) }}" alt="{{ $item->title }}" class="img-fluid">
                            </div>
                            <div class="product-price">
                                <div class="public-price">{{ format_money($item->productOption->first()->price) }}</div>
                                <div class="origin-price">{{ format_money($item->productOption->first()->normal_price) }}</div>
                            </div>
                            <div class="product-brand">
                                {{ $item->brand }}
                            </div>
                            <div class="product-title">
                                {{ $item->productOption->first()->title }}
                            </div>
                        </a>
                        @empty
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="slide-template bg-white mb-5">
                <div class="slide-top">
                    <a href="" class="slide-title">
                        <h3>Thương hiệu nổi bật</h3>
                    </a>
                    <a href="" class="slide-more">
                        Xem tất cả
                    </a>
                </div>
                <div class="slide-main">
                    <div class="slide-template-slick">
                        @forelse($attribute_brand as $item)
                        <a href="" class="brand-template">
                            <img src="{{ asset($item->image) }}" alt="{{ $item->name }}" class="img-fluid">
                            <div class="title">{{ $item->name }}</div>
                        </a>
                        @empty
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="section-product-category">
                <div class="section mb-5">
                    <div class="section-top">
                        <div class="section-menu">
                            <a href="" class="section-title">
                                <h2 class="text-uppercase mb-0">Trang điểm</h2>
                            </a>
                            <div class="section-sub-menu">
                                <a href="" class="text-uppercase">Trang điểm mặt</a>
                                <a href="" class="text-uppercase">Trang điểm mắt</a>
                            </div>
                        </div>
                        <a href="" class="section-more text-uppercase">Xem thêm</a>
                    </div>
                    <div class="section-main bg-white">
                        <div class="section-poster">
                            <a href="">
                                <img src="./img-example/1642039157957-trang-điểm.jpeg" alt="" class="img-fluid">
                            </a>
                        </div>
                        <div class="section-content">
                            <a href="" class="product-template">
                                <div class="product-discount">
                                    <span class="pe-1">5%</span>
                                </div>
                                <div class="product-thumbnail">
                                    <img src="./img-example/1644976001639-kem-nen-fit-me-maybelline-m-p-spf-22-300x300.jpeg" alt="Kem Nền Maybelline Fit Me Matte Poreless Foundation SPF 22 30ml" class="img-fluid">
                                </div>
                                <div class="product-price">
                                    <div class="public-price">254.600 đ</div>
                                    <div class="origin-price">268.000 đ</div>
                                </div>
                                <div class="product-brand">
                                    MAYBELLINE
                                </div>
                                <div class="product-title">
                                    Kem Nền Maybelline Fit Me Matte Poreless Foundation SPF 22 30ml
                                </div>
                            </a>
                            <a href="" class="product-template">
                                <div class="product-discount">
                                    <span class="pe-1">5%</span>
                                </div>
                                <div class="product-thumbnail">
                                    <img src="./img-example/1644976001639-kem-nen-fit-me-maybelline-m-p-spf-22-300x300.jpeg" alt="Kem Nền Maybelline Fit Me Matte Poreless Foundation SPF 22 30ml" class="img-fluid">
                                </div>
                                <div class="product-price">
                                    <div class="public-price">254.600 đ</div>
                                    <div class="origin-price">268.000 đ</div>
                                </div>
                                <div class="product-brand">
                                    MAYBELLINE
                                </div>
                                <div class="product-title">
                                    Kem Nền Maybelline Fit Me Matte Poreless Foundation SPF 22 30ml
                                </div>
                            </a>
                            <a href="" class="product-template">
                                <div class="product-discount">
                                    <span class="pe-1">5%</span>
                                </div>
                                <div class="product-thumbnail">
                                    <img src="./img-example/1644976001639-kem-nen-fit-me-maybelline-m-p-spf-22-300x300.jpeg" alt="Kem Nền Maybelline Fit Me Matte Poreless Foundation SPF 22 30ml" class="img-fluid">
                                </div>
                                <div class="product-price">
                                    <div class="public-price">254.600 đ</div>
                                    <div class="origin-price">268.000 đ</div>
                                </div>
                                <div class="product-brand">
                                    MAYBELLINE
                                </div>
                                <div class="product-title">
                                    Kem Nền Maybelline Fit Me Matte Poreless Foundation SPF 22 30ml
                                </div>
                            </a>
                            <a href="" class="product-template">
                                <div class="product-discount">
                                    <span class="pe-1">5%</span>
                                </div>
                                <div class="product-thumbnail">
                                    <img src="./img-example/1644976001639-kem-nen-fit-me-maybelline-m-p-spf-22-300x300.jpeg" alt="Kem Nền Maybelline Fit Me Matte Poreless Foundation SPF 22 30ml" class="img-fluid">
                                </div>
                                <div class="product-price">
                                    <div class="public-price">254.600 đ</div>
                                    <div class="origin-price">268.000 đ</div>
                                </div>
                                <div class="product-brand">
                                    MAYBELLINE
                                </div>
                                <div class="product-title">
                                    Kem Nền Maybelline Fit Me Matte Poreless Foundation SPF 22 30ml
                                </div>
                            </a>
                            <a href="" class="product-template">
                                <div class="product-discount">
                                    <span class="pe-1">5%</span>
                                </div>
                                <div class="product-thumbnail">
                                    <img src="./img-example/1644976001639-kem-nen-fit-me-maybelline-m-p-spf-22-300x300.jpeg" alt="Kem Nền Maybelline Fit Me Matte Poreless Foundation SPF 22 30ml" class="img-fluid">
                                </div>
                                <div class="product-price">
                                    <div class="public-price">254.600 đ</div>
                                    <div class="origin-price">268.000 đ</div>
                                </div>
                                <div class="product-brand">
                                    MAYBELLINE
                                </div>
                                <div class="product-title">
                                    Kem Nền Maybelline Fit Me Matte Poreless Foundation SPF 22 30ml
                                </div>
                            </a>
                            <a href="" class="product-template">
                                <div class="product-discount">
                                    <span class="pe-1">5%</span>
                                </div>
                                <div class="product-thumbnail">
                                    <img src="./img-example/1644976001639-kem-nen-fit-me-maybelline-m-p-spf-22-300x300.jpeg" alt="Kem Nền Maybelline Fit Me Matte Poreless Foundation SPF 22 30ml" class="img-fluid">
                                </div>
                                <div class="product-price">
                                    <div class="public-price">254.600 đ</div>
                                    <div class="origin-price">268.000 đ</div>
                                </div>
                                <div class="product-brand">
                                    MAYBELLINE
                                </div>
                                <div class="product-title">
                                    Kem Nền Maybelline Fit Me Matte Poreless Foundation SPF 22 30ml
                                </div>
                            </a>
                            <a href="" class="product-template">
                                <div class="product-discount">
                                    <span class="pe-1">5%</span>
                                </div>
                                <div class="product-thumbnail">
                                    <img src="./img-example/1644976001639-kem-nen-fit-me-maybelline-m-p-spf-22-300x300.jpeg" alt="Kem Nền Maybelline Fit Me Matte Poreless Foundation SPF 22 30ml" class="img-fluid">
                                </div>
                                <div class="product-price">
                                    <div class="public-price">254.600 đ</div>
                                    <div class="origin-price">268.000 đ</div>
                                </div>
                                <div class="product-brand">
                                    MAYBELLINE
                                </div>
                                <div class="product-title">
                                    Kem Nền Maybelline Fit Me Matte Poreless Foundation SPF 22 30ml
                                </div>
                            </a>
                            <a href="" class="product-template">
                                <div class="product-discount">
                                    <span class="pe-1">5%</span>
                                </div>
                                <div class="product-thumbnail">
                                    <img src="./img-example/1644976001639-kem-nen-fit-me-maybelline-m-p-spf-22-300x300.jpeg" alt="Kem Nền Maybelline Fit Me Matte Poreless Foundation SPF 22 30ml" class="img-fluid">
                                </div>
                                <div class="product-price">
                                    <div class="public-price">254.600 đ</div>
                                    <div class="origin-price">268.000 đ</div>
                                </div>
                                <div class="product-brand">
                                    MAYBELLINE
                                </div>
                                <div class="product-title">
                                    Kem Nền Maybelline Fit Me Matte Poreless Foundation SPF 22 30ml
                                </div>
                            </a>
                            <a href="" class="product-template">
                                <div class="product-discount">
                                    <span class="pe-1">5%</span>
                                </div>
                                <div class="product-thumbnail">
                                    <img src="./img-example/1644976001639-kem-nen-fit-me-maybelline-m-p-spf-22-300x300.jpeg" alt="Kem Nền Maybelline Fit Me Matte Poreless Foundation SPF 22 30ml" class="img-fluid">
                                </div>
                                <div class="product-price">
                                    <div class="public-price">254.600 đ</div>
                                    <div class="origin-price">268.000 đ</div>
                                </div>
                                <div class="product-brand">
                                    MAYBELLINE
                                </div>
                                <div class="product-title">
                                    Kem Nền Maybelline Fit Me Matte Poreless Foundation SPF 22 30ml
                                </div>
                            </a>
                            <a href="" class="product-template">
                                <div class="product-discount">
                                    <span class="pe-1">5%</span>
                                </div>
                                <div class="product-thumbnail">
                                    <img src="./img-example/1644976001639-kem-nen-fit-me-maybelline-m-p-spf-22-300x300.jpeg" alt="Kem Nền Maybelline Fit Me Matte Poreless Foundation SPF 22 30ml" class="img-fluid">
                                </div>
                                <div class="product-price">
                                    <div class="public-price">254.600 đ</div>
                                    <div class="origin-price">268.000 đ</div>
                                </div>
                                <div class="product-brand">
                                    MAYBELLINE
                                </div>
                                <div class="product-title">
                                    Kem Nền Maybelline Fit Me Matte Poreless Foundation SPF 22 30ml
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="section mb-5">
                    <div class="section-top">
                        <div class="section-menu">
                            <a href="" class="section-title">
                                <h2 class="text-uppercase mb-0">Trang điểm</h2>
                            </a>
                            <div class="section-sub-menu">
                                <a href="" class="text-uppercase">Trang điểm mặt</a>
                                <a href="" class="text-uppercase">Trang điểm mắt</a>
                            </div>
                        </div>
                        <a href="" class="section-more text-uppercase">Xem thêm</a>
                    </div>
                    <div class="section-main bg-white">
                        <div class="section-poster">
                            <a href="" class="section-poster">
                                <img src="./img-example/1642039157957-trang-điểm.jpeg" alt="" class="img-fluid">
                            </a>
                        </div>
                        <div class="section-content">
                            <a href="" class="product-template">
                                <div class="product-discount">
                                    <span class="pe-1">5%</span>
                                </div>
                                <div class="product-thumbnail">
                                    <img src="./img-example/1644976001639-kem-nen-fit-me-maybelline-m-p-spf-22-300x300.jpeg" alt="Kem Nền Maybelline Fit Me Matte Poreless Foundation SPF 22 30ml" class="img-fluid">
                                </div>
                                <div class="product-price">
                                    <div class="public-price">254.600 đ</div>
                                    <div class="origin-price">268.000 đ</div>
                                </div>
                                <div class="product-brand">
                                    MAYBELLINE
                                </div>
                                <div class="product-title">
                                    Kem Nền Maybelline Fit Me Matte Poreless Foundation SPF 22 30ml
                                </div>
                            </a>
                            <a href="" class="product-template">
                                <div class="product-discount">
                                    <span class="pe-1">5%</span>
                                </div>
                                <div class="product-thumbnail">
                                    <img src="./img-example/1644976001639-kem-nen-fit-me-maybelline-m-p-spf-22-300x300.jpeg" alt="Kem Nền Maybelline Fit Me Matte Poreless Foundation SPF 22 30ml" class="img-fluid">
                                </div>
                                <div class="product-price">
                                    <div class="public-price">254.600 đ</div>
                                    <div class="origin-price">268.000 đ</div>
                                </div>
                                <div class="product-brand">
                                    MAYBELLINE
                                </div>
                                <div class="product-title">
                                    Kem Nền Maybelline Fit Me Matte Poreless Foundation SPF 22 30ml
                                </div>
                            </a>
                            <a href="" class="product-template">
                                <div class="product-discount">
                                    <span class="pe-1">5%</span>
                                </div>
                                <div class="product-thumbnail">
                                    <img src="./img-example/1644976001639-kem-nen-fit-me-maybelline-m-p-spf-22-300x300.jpeg" alt="Kem Nền Maybelline Fit Me Matte Poreless Foundation SPF 22 30ml" class="img-fluid">
                                </div>
                                <div class="product-price">
                                    <div class="public-price">254.600 đ</div>
                                    <div class="origin-price">268.000 đ</div>
                                </div>
                                <div class="product-brand">
                                    MAYBELLINE
                                </div>
                                <div class="product-title">
                                    Kem Nền Maybelline Fit Me Matte Poreless Foundation SPF 22 30ml
                                </div>
                            </a>
                            <a href="" class="product-template">
                                <div class="product-discount">
                                    <span class="pe-1">5%</span>
                                </div>
                                <div class="product-thumbnail">
                                    <img src="./img-example/1644976001639-kem-nen-fit-me-maybelline-m-p-spf-22-300x300.jpeg" alt="Kem Nền Maybelline Fit Me Matte Poreless Foundation SPF 22 30ml" class="img-fluid">
                                </div>
                                <div class="product-price">
                                    <div class="public-price">254.600 đ</div>
                                    <div class="origin-price">268.000 đ</div>
                                </div>
                                <div class="product-brand">
                                    MAYBELLINE
                                </div>
                                <div class="product-title">
                                    Kem Nền Maybelline Fit Me Matte Poreless Foundation SPF 22 30ml
                                </div>
                            </a>
                            <a href="" class="product-template">
                                <div class="product-discount">
                                    <span class="pe-1">5%</span>
                                </div>
                                <div class="product-thumbnail">
                                    <img src="./img-example/1644976001639-kem-nen-fit-me-maybelline-m-p-spf-22-300x300.jpeg" alt="Kem Nền Maybelline Fit Me Matte Poreless Foundation SPF 22 30ml" class="img-fluid">
                                </div>
                                <div class="product-price">
                                    <div class="public-price">254.600 đ</div>
                                    <div class="origin-price">268.000 đ</div>
                                </div>
                                <div class="product-brand">
                                    MAYBELLINE
                                </div>
                                <div class="product-title">
                                    Kem Nền Maybelline Fit Me Matte Poreless Foundation SPF 22 30ml
                                </div>
                            </a>
                            <a href="" class="product-template">
                                <div class="product-discount">
                                    <span class="pe-1">5%</span>
                                </div>
                                <div class="product-thumbnail">
                                    <img src="./img-example/1644976001639-kem-nen-fit-me-maybelline-m-p-spf-22-300x300.jpeg" alt="Kem Nền Maybelline Fit Me Matte Poreless Foundation SPF 22 30ml" class="img-fluid">
                                </div>
                                <div class="product-price">
                                    <div class="public-price">254.600 đ</div>
                                    <div class="origin-price">268.000 đ</div>
                                </div>
                                <div class="product-brand">
                                    MAYBELLINE
                                </div>
                                <div class="product-title">
                                    Kem Nền Maybelline Fit Me Matte Poreless Foundation SPF 22 30ml
                                </div>
                            </a>
                            <a href="" class="product-template">
                                <div class="product-discount">
                                    <span class="pe-1">5%</span>
                                </div>
                                <div class="product-thumbnail">
                                    <img src="./img-example/1644976001639-kem-nen-fit-me-maybelline-m-p-spf-22-300x300.jpeg" alt="Kem Nền Maybelline Fit Me Matte Poreless Foundation SPF 22 30ml" class="img-fluid">
                                </div>
                                <div class="product-price">
                                    <div class="public-price">254.600 đ</div>
                                    <div class="origin-price">268.000 đ</div>
                                </div>
                                <div class="product-brand">
                                    MAYBELLINE
                                </div>
                                <div class="product-title">
                                    Kem Nền Maybelline Fit Me Matte Poreless Foundation SPF 22 30ml
                                </div>
                            </a>
                            <a href="" class="product-template">
                                <div class="product-discount">
                                    <span class="pe-1">5%</span>
                                </div>
                                <div class="product-thumbnail">
                                    <img src="./img-example/1644976001639-kem-nen-fit-me-maybelline-m-p-spf-22-300x300.jpeg" alt="Kem Nền Maybelline Fit Me Matte Poreless Foundation SPF 22 30ml" class="img-fluid">
                                </div>
                                <div class="product-price">
                                    <div class="public-price">254.600 đ</div>
                                    <div class="origin-price">268.000 đ</div>
                                </div>
                                <div class="product-brand">
                                    MAYBELLINE
                                </div>
                                <div class="product-title">
                                    Kem Nền Maybelline Fit Me Matte Poreless Foundation SPF 22 30ml
                                </div>
                            </a>
                            <a href="" class="product-template">
                                <div class="product-discount">
                                    <span class="pe-1">5%</span>
                                </div>
                                <div class="product-thumbnail">
                                    <img src="./img-example/1644976001639-kem-nen-fit-me-maybelline-m-p-spf-22-300x300.jpeg" alt="Kem Nền Maybelline Fit Me Matte Poreless Foundation SPF 22 30ml" class="img-fluid">
                                </div>
                                <div class="product-price">
                                    <div class="public-price">254.600 đ</div>
                                    <div class="origin-price">268.000 đ</div>
                                </div>
                                <div class="product-brand">
                                    MAYBELLINE
                                </div>
                                <div class="product-title">
                                    Kem Nền Maybelline Fit Me Matte Poreless Foundation SPF 22 30ml
                                </div>
                            </a>
                            <a href="" class="product-template">
                                <div class="product-discount">
                                    <span class="pe-1">5%</span>
                                </div>
                                <div class="product-thumbnail">
                                    <img src="./img-example/1644976001639-kem-nen-fit-me-maybelline-m-p-spf-22-300x300.jpeg" alt="Kem Nền Maybelline Fit Me Matte Poreless Foundation SPF 22 30ml" class="img-fluid">
                                </div>
                                <div class="product-price">
                                    <div class="public-price">254.600 đ</div>
                                    <div class="origin-price">268.000 đ</div>
                                </div>
                                <div class="product-brand">
                                    MAYBELLINE
                                </div>
                                <div class="product-title">
                                    Kem Nền Maybelline Fit Me Matte Poreless Foundation SPF 22 30ml
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="section-banner-middle mb-5">
                <a class="" href="">
                    <img alt="La Roche-Posay Sale 10%" src="./img-example/1642040388948-banner-cocolux-5.jpeg" class="img-fluid">
                </a>
                <a class="" href="">
                    <img alt="Maybelline Sale 10%" src="./img-example/1642040393768-banner-cocolux-6.jpeg" class="img-fluid">
                </a>
                <a class="" href="">
                    <img alt="Vichy sale 10%" src="./img-example/1642040399279-banner-cocolux-12.jpeg" class="img-fluid">
                </a>
            </div>

            <div class="section-article mb-5">
                <div class="section-top">
                    <a href="">
                        <h2 class="text-uppercase">Xem tất cả</h2>
                    </a>
                    <a href="" class="text-uppercase">Xem tất cả</a>
                </div>
                <div class="section-main">
                    @forelse($articles as $item)
                    <a href="" class="article-item" title="{{ $item->title }}">
                        <div class="article-img">
                            <img src="{{ asset($item->image) }}" alt="{{ $item->title }}" class="img-fluid">
                        </div>
                        <div class="article-title">
                            <span>
                                {{ $item->description }}
                            </span>
                        </div>
                    </a>
                    @empty
                    @endforelse
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
        });
    </script>
@endsection
