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
                                <img src="{{ asset(replace_image($item->image)) }}" alt="{{ $item->content }}" class="img-fluid">
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
            @if(count($list_coupon))
                <div class="list-coupon">
                    <h2 class="text-center">Mã khuyến mại</h2>
                    <div class="slide-main-coupon">
                        <div class="slide-template-slick-coupon">
                            @forelse($list_coupon as $item)
                                @if($item->items)
                                <div class="item-coupon">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="box-coupon box-coupon-left text-center">
                                            <svg width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="25" cy="25" r="25" fill="#C73030"/>
                                                <path d="M15 37.5V23.75H12.5V16.25H19C18.8958 16.0625 18.8281 15.8646 18.7969 15.6562C18.7656 15.4479 18.75 15.2292 18.75 15C18.75 13.9583 19.1146 13.0729 19.8438 12.3438C20.5729 11.6146 21.4583 11.25 22.5 11.25C22.9792 11.25 23.4271 11.3385 23.8438 11.5156C24.2604 11.6927 24.6458 11.9375 25 12.25C25.3542 11.9167 25.7396 11.6667 26.1562 11.5C26.5729 11.3333 27.0208 11.25 27.5 11.25C28.5417 11.25 29.4271 11.6146 30.1562 12.3438C30.8854 13.0729 31.25 13.9583 31.25 15C31.25 15.2292 31.2292 15.4427 31.1875 15.6406C31.1458 15.8385 31.0833 16.0417 31 16.25H37.5V23.75H35V37.5H15ZM27.5 13.75C27.1458 13.75 26.849 13.8698 26.6094 14.1094C26.3698 14.349 26.25 14.6458 26.25 15C26.25 15.3542 26.3698 15.651 26.6094 15.8906C26.849 16.1302 27.1458 16.25 27.5 16.25C27.8542 16.25 28.151 16.1302 28.3906 15.8906C28.6302 15.651 28.75 15.3542 28.75 15C28.75 14.6458 28.6302 14.349 28.3906 14.1094C28.151 13.8698 27.8542 13.75 27.5 13.75ZM21.25 15C21.25 15.3542 21.3698 15.651 21.6094 15.8906C21.849 16.1302 22.1458 16.25 22.5 16.25C22.8542 16.25 23.151 16.1302 23.3906 15.8906C23.6302 15.651 23.75 15.3542 23.75 15C23.75 14.6458 23.6302 14.349 23.3906 14.1094C23.151 13.8698 22.8542 13.75 22.5 13.75C22.1458 13.75 21.849 13.8698 21.6094 14.1094C21.3698 14.349 21.25 14.6458 21.25 15ZM15 18.75V21.25H23.75V18.75H15ZM23.75 35V23.75H17.5V35H23.75ZM26.25 35H32.5V23.75H26.25V35ZM35 21.25V18.75H26.25V21.25H35Z" fill="white"/>
                                            </svg>
                                        </div>
                                        <div class="box-coupon box-coupon-right w-100">
                                            @if($item->value_type == 1)
                                                <p class="sub-title-coupon">Giảm {{ $item->value }}đ</p>
                                            @else
                                                <p class="sub-title-coupon">Giảm {{ $item->value }}</p>
                                            @endif
                                            <div class="voucher-detail">
                                                {{ $item->name }}
                                                <p>Còn {{ $item->total_using_voucher }} mã, hết hạn trong {{ $item->time_end_voucher }} ngày</p>
                                            </div>
                                            <div class="progress">
                                                <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $item->progressbar }}%" aria-valuenow="{{ $item->progressbar }}" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center mt-1">
                                                <button type="button" class="btn btn-call-modal p-0 btn-value" data-value-coupon="{{ json_encode($item) }}" data-bs-toggle="modal" data-bs-target="#info-coupon-detail">Chi tiết</button>
                                                <button type="button" class="btn btn-dark btn-copy" data-coupon="{{ $item->items['code'] }}">Sao chép</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            @empty
                            @endforelse
                        </div>
                    </div>
                </div>
            @endif
            @if(count($product_flash))
            <div class="section-flash-mobile d-block slide-template bg-white mb-4">
                <div class="slide-top">
                    <div class="slide-title d-flex align-items-center gap-2">
                        <a href="{{ route('flashSaleProducts') }}" title="Flash Deal" class="d-flex align-items-center gap-2">
                            <img src="{{ asset('images/hot_icon.svg') }}" alt="flash deal" class="img-fluid" height="18" width="18">
                            <h2>Flash Deal</h2>
                        </a>
{{--                        |--}}
{{--                        <div is-title="true" class="count-down d-flex align-items-center gap-1" time-end="Oct 30 2023 20:00:00"></div>--}}
                    </div>
                    <a href="{{ route('flashSaleProducts') }}" class="slide-more">Xem tất cả</a>
                </div>
                <div class="slide-main">
                    <div class="slide-template-slick">
                        @if(!empty($product_flash))
                        @forelse($product_flash as $item)
                                <a href="{{ route('detailProduct',['slug'=>!empty($item->slug)?trim($item->slug):$item->product->slug, 'sku' =>$item->sku]) }}" class="product-template">
                                    @if($item->flash_deal->price != $item->normal_price)
                                        <div class="product-discount">
                                            <span class="pe-1">{{ percentage_price($item->flash_deal->price, $item->normal_price) }}</span>
                                        </div>
                                    @endif
                                    <div class="product-thumbnail">
                                        <img src="{{ asset($item->image_first) }}" alt="{{ $item->title }}" class="img-fluid">
                                    </div>
                                    <div class="product-price">
                                        <div class="public-price">{{ format_money($item->flash_deal->price) }}</div>
                                        @if($item->flash_deal->price != $item->normal_price)
                                            <div class="origin-price">{{ format_money($item->normal_price) }}</div>
                                        @endif
                                    </div>
                                    <div class="product-brand">
                                        {{ $item->brand }}
                                    </div>
                                    <div class="product-title">
                                        {{ $item->title }}
                                    </div>
                                    @if($item->flash_deal && $applied_stop_time[$item->flash_deal->id])
                                        <div class="product-progress-sale count-down" time-end="{{ $applied_stop_time[$item->flash_deal->id] }}"></div>
                                    @endif
                                </a>
                        @empty
                        @endforelse
                        @endif
                    </div>
                </div>
            </div>
            @endif
            @if(!empty($product_hots))
            <div class="slide-template bg-white mb-4">
                <div class="slide-top">
                    <a href="{{ route('itemHotProducts') }}" class="slide-title">
                        <h2>Sản phẩm hot</h2>
                    </a>
                    <a href="{{ route('itemHotProducts') }}" class="slide-more">
                        Xem tất cả
                    </a>
                </div>
                <div class="slide-main">
                    <div class="slide-template-slick">
                        @forelse($product_hots as $item)
                        <a href="{{ route('detailProduct',['slug'=> !empty($item->slug)?trim($item->slug):$item->product->slug, 'sku' =>$item->sku]) }}" class="product-template">
                            @if($item->flash_deal && in_array($item->flash_deal->id,$promotions_flash_id))
                                @if($item->flash_deal->price != $item->normal_price)
                                    <div class="product-discount">
                                        <span class="pe-1">{{ percentage_price($item->flash_deal->price, $item->normal_price) }}</span>
                                    </div>
                                @endif
                            @elseif($item->hot_deal && in_array($item->hot_deal->id,$promotions_hot_id))
                                @if($item->hot_deal->price != $item->normal_price)
                                    <div class="product-discount">
                                        <span class="pe-1">{{ percentage_price($item->hot_deal->price, $item->normal_price) }}</span>
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
                                @if($item->flash_deal && in_array($item->flash_deal->id,$promotions_flash_id))
                                    <div class="public-price">{{ format_money($item->flash_deal->price) }}</div>
                                    @if($item->flash_deal->price != $item->normal_price)
                                        <div class="origin-price">{{ format_money($item->normal_price) }}</div>
                                    @endif
                                @elseif($item->hot_deal && in_array($item->hot_deal->id,$promotions_hot_id))
                                    <div class="public-price">{{ format_money($item->hot_deal->price) }}</div>
                                    @if($item->hot_deal->price != $item->normal_price)
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
                </div>
            </div>
            @endif
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
                            <a href="{{ route('catProduct',['slug' => $cat->slug, 'id'=> $cat->id]) }}">
                                <img src="{{ asset(replace_image($cat->banner)) }}" alt="{{ $cat->title }}" class="img-fluid">
                            </a>
                        </div>
                        <div class="section-content">
                            @if($product_cats && !empty($product_cats[$cat->id]))
                            @forelse($product_cats[$cat->id] as $item)
                            <a href="{{ route('detailProduct',['slug'=> !empty($item->slug)?trim($item->slug):$item->product->slug, 'sku' => $item->sku]) }}" class="product-template">
                                @if($item->flash_deal && in_array($item->flash_deal->id,$promotions_flash_id))
                                    @if($item->flash_deal->price != $item->normal_price)
                                        <div class="product-discount">
                                            <span class="pe-1">{{ percentage_price($item->flash_deal->price, $item->normal_price) }}</span>
                                        </div>
                                    @endif
                                @elseif($item->hot_deal && in_array($item->hot_deal->id,$promotions_hot_id))
                                    @if($item->hot_deal->price != $item->normal_price)
                                        <div class="product-discount">
                                            <span class="pe-1">{{ percentage_price($item->hot_deal->price, $item->normal_price) }}</span>
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
                                    @if($item->flash_deal && in_array($item->flash_deal->id,$promotions_flash_id))
                                        <div class="public-price">{{ format_money($item->flash_deal->price) }}</div>
                                        @if($item->flash_deal->price != $item->normal_price)
                                            <div class="origin-price">{{ format_money($item->normal_price) }}</div>
                                        @endif
                                    @elseif($item->hot_deal && in_array($item->hot_deal->id,$promotions_hot_id))
                                        <div class="public-price">{{ format_money($item->hot_deal->price) }}</div>
                                        @if($item->hot_deal->price != $item->normal_price)
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
            @if(!empty($articles))
                <div class="section-article mb-5">
                    <div class="section-top">
                        <a href="{{ route('homeArticle') }}">
                            <h2 class="text-uppercase">Tin tức & sự kiện</h2>
                        </a>
                        <a href="{{ route('homeArticle') }}" class="text-uppercase">Xem tất cả</a>
                    </div>
                    <div class="section-main">

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
                    </div>
                </div>
            @endif
            @if(count($stores))
                <div class="section-store mb-5">
                    <div class="section-top">
                        <a href="#">
                            <h2 class="text-uppercase">Danh sách cửa hàng</h2>
                        </a>
                    </div>
                    <div class="section-store-main">
                        @forelse($stores as $item)
                            <div>
                                <a class='ccs-item-store--img'>
                                    <img src="{{ asset($item->image) }}" alt="{{ $item->name }}" class="img-fluid" />
                                </a>
                                <div class='ccs-item-store--text'>
                                    <span>{{ $item->name }}</span>
                                    <span>{{ $item->phone }}</span>
                                </div>
                            </div>
                        @empty
                        @endforelse
                    </div>
                </div>
            @endif
        </div>
    </main>
    <!-- Modal -->
    <div class="modal fade" id="info-coupon-detail" tabindex="-1" aria-labelledby="couponModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="couponModalLabel">Chi tiết Mã khuyến mãi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="box1">
                        <b id="name-coupon"></b>
                        <span id="des-coupon"></span>
                    </div>
                    <hr>
                    <div class="box2">
                        <span>Mã giảm giá</span>
                        <span class="coupon-here" id="coupon-here" data-coupon="">
                            <span id="coupon-modal"></span>
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M15.8334 15.8334H6.66669C6.20835 15.8334 5.81599 15.6702 5.4896 15.3438C5.16321 15.0174 5.00002 14.625 5.00002 14.1667V2.50004C5.00002 2.04171 5.16321 1.64935 5.4896 1.32296C5.81599 0.996568 6.20835 0.833374 6.66669 0.833374H12.5L17.5 5.83337V14.1667C17.5 14.625 17.3368 15.0174 17.0104 15.3438C16.684 15.6702 16.2917 15.8334 15.8334 15.8334ZM11.6667 6.66671V2.50004H6.66669V14.1667H15.8334V6.66671H11.6667ZM3.33335 19.1667C2.87502 19.1667 2.48266 19.0035 2.15627 18.6771C1.82988 18.3507 1.66669 17.9584 1.66669 17.5V5.83337H3.33335V17.5H12.5V19.1667H3.33335Z" fill="#C73030"/>
                            </svg>
                        </span>
                    </div>
                    <hr>
                    <div class="box3">
                        <p>Áp dụng từ</p>
                        <span id="startDate"></span> - <span id="endDate"></span>
                    </div>
                    <hr>
                    <div class="box4">
                        <div class="detail-coupon">Chi tiết</div>
                        <div id="description-coupon"></div>
                        <p>Có hiệu lực từ <span id="show_date">13/12/2023 - 19/12/2023</span></p>
                    </div>
                </div>
                <div class="modal-footer justify-content-between align-items-center flex-nowrap">
                    <button type="button" class="btn btn-white" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-dark coupon-end" id="coupon-end" data-coupon="">Sao chép</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('link')
    @parent
    <link href="{{ asset('js/web/slick/slick.css') }}" rel="stylesheet">
    <link href="{{ asset('js/web/slick/slick-theme.css') }}" rel="stylesheet">
    <link href="{{ asset('css/web/home.css') }}?v=2.0" rel="stylesheet">
@endsection

@section('script')
    @parent
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

        $('.section-store-main').slick({
            slidesToShow: 6,
            slidesToScroll: 6,
            dots: false,
            arrows: false,
            infinite: true,
            autoplay: true,
            speed: 500,
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 6,
                        slidesToScroll: 6,
                    }
                },
                {
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 4,
                    }
                },
                {
                    breakpoint: 767,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2,
                    }
                }
            ]

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

        $('.slide-template-slick-coupon').slick({
            slidesToShow: 4,
            slidesToScroll: 4,
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

        $('.btn-copy').click(function(){
            let value = $(this).data('coupon');
            let temp = $("<input>");
            $("body").append(temp);
            temp.val(value).select();
            try {
                document.execCommand("copy");
                console.log('Text copied to clipboard successfully');
                Swal.fire(
                    'Thành công!',
                    'Copy thành công',
                    'success'
                );
            } catch (err) {
                console.error('Error copying text to clipboard:', err);
            } finally {
                temp.remove();
            }
        })

        $('.modal-footer #coupon-end, .modal-body #coupon-here').click(function() {
            const coupon_here = document.querySelector(".modal-body #coupon-here #coupon-modal");

            // Tạo một đối tượng Range để chọn nội dung của phần tử
            const range = document.createRange();
            range.selectNode(coupon_here);

            // Lựa chọn nội dung của phần tử
            const selection = window.getSelection();
            selection.removeAllRanges();
            selection.addRange(range);

            try {
                document.execCommand("copy");

                // Kiểm tra xem nếu có clipboardData
                if (event.clipboardData) {
                    event.clipboardData.setData("text/plain", coupon_here.textContent);
                }

                Swal.fire(
                    'Thành công!',
                    'Copy thành công',
                    'success'
                );
            } catch (err) {
                console.error('Error copying text to clipboard:', err);
            } finally {
                // Xóa lựa chọn
                selection.removeAllRanges();
            }
        });

        $('.btn-value').click(function(){
            let value = $(this).data('value-coupon');
            $(".modal-body #name-coupon").text( 'Giảm ' + value.value );
            $(".modal-body #des-coupon").text( value.name );
            $(".modal-body #coupon-modal").text( value.items.code );
            $(".modal-body #coupon-here").data('coupon',value.items.code );
            $(".modal-footer #coupon-end").data('coupon',value.items.code );
            $(".modal-body #startDate").text( value.start_date );
            $(".modal-body #endDate").text( value.end_date );
            $(".modal-body #show_date").text( value.start_date + '- '+ value.end_date );
            $(".modal-body #description-coupon").text( value.description );
        })

    </script>
@endsection
