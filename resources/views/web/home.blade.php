@extends('web.layouts.web')
@section('preload')
    @forelse($slider as $k => $item)
        @if ($item->image_resize)
            <link rel="preload" fetchpriority="high" as="image" href="{{ asset($item->image_resize) }}" type="image/webp">
        @else
            <link rel="preload" as="image" href="{{ asset(replace_image($item->image)) }}">
        @endif
    @empty
    @endforelse
    <link rel="preload" as="style" media="screen" type="text/css" href="{{ mix('css/web/home.css') }}">
    <link rel="preload" href="{{ mix('js/web/home.js') }}" as="script" />
@endsection
@section('content')
    <main>


        <div class="container">
            <div class="section-banner-top mb-4">
                <div class="banner-slide">
                    <div class="banner-slick owl-carousel">
                        @forelse($slider as $k => $item)
                            <div>
                                <a href="{!! $item->url !!}" aria-label="{{ $item->content }}">
                                    @if ($item->image_resize)
                                        <img src="{{ asset(str_replace('larger', 'small', $item->image_resize)) }}"
                                            srcset="
                                            {{ asset(str_replace('larger', 'small', $item->image_resize)) }} 400w,
                                            {{ asset(str_replace('larger', 'small', $item->image_resize)) }} 800w,
                                            {{ asset($item->image_resize) }} 1200w"
                                            sizes="(max-width: 600px) 400px,
                                        (max-width: 1024px)
800px,
                                        1200px"
                                            alt="{{ $item->content }}" width="700" height="400" class="img-fluid">
                                    @else
                                        <img src="{{ asset(replace_image($item->image)) }}" alt="{{ $item->content }}"
                                            width="700" height="400" class="img-fluid">
                                    @endif
                                </a>
                            </div>
                        @empty
                        @endforelse
                    </div>
                </div>
                @if (!$isMobile)
                    <div class="banner-wrap">
                        @forelse($subBanner as $item)
                            <a href="{!! $item->url !!}" aria-label="{{ $item->content }}">
                                <img src="{{ asset(replace_image($item->image_url)) }}" alt="{{ $item->content }}"
                                    width="390" height="195" class="img-fluid">
                            </a>
                        @empty
                        @endforelse
                    </div>
                @endif
            </div>
            @if ($isMobile)
                <div class="section-categories-mobile d-grid d-lg-none mb-4">
                    <a href="" class="item-category d-flex flex-column align-items-center text-center text-uppercase"
                        data-bs-toggle="modal" data-bs-target="#categoriesModal">
                        <div class="section-icon">
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                        Danh mục
                    </a>
                    @forelse($cat_products as $item)
                        <a href="{{ route('catProduct', ['slug' => $item->slug, 'id' => $item->id]) }}"
                            class="item-category d-flex flex-column align-items-center text-center text-uppercase">
                            <img data-src="{{ asset(replace_image($item->logo)) }}" alt="{{ $item->title }}"
                                class="img-fluid lazy" onerror="this.src='{{ asset('/images/ic-lazy-load-3.png') }}'">
                            {{ $item->title }}
                        </a>
                    @empty
                    @endforelse
                    <a href="{{ route('StoreCocolux') }}"
                        class="item-category d-flex flex-column align-items-center text-center text-uppercase">
                        <img data-src="{{ asset('images/He-thong-cua-hang.webp') }}" alt="Hệ thống cửa hàng Cocolux"
                            class="img-fluid lazy" onerror="this.src='{{ asset('/images/ic-lazy-load-3.png') }}'">
                        Hệ thống cửa hàng
                    </a>
                    <a href="{{ route('CocoluxSearchNhanh') }}"
                        class="item-category d-flex flex-column align-items-center text-center text-uppercase">
                        <img data-src="{{ asset('images/Tim-kiem-don-hang.png') }}" alt="Tra cứu đơn hàng Cocolux"
                            class="img-fluid lazy" onerror="this.src='{{ asset('/images/ic-lazy-load-3.svg') }}'">
                        Tra cứu đơn hàng
                    </a>
                </div>
            @endif

            <div class="modal modal-full fade" id="categoriesModal" tabindex="-1" aria-labelledby="categoriesModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body pt-0">
                            @if (!empty($cat_products))
                                @forelse($cat_products as $item)
                                    <div class="d-flex gap-1 justify-content-between item-cate">
                                        <a href="{{ route('catProduct', ['slug' => $item->slug, 'id' => $item->id]) }}"
                                            class="cate-parent">
                                            {{ $item->title }}
                                        </a>
                                        @if ($item->children)
                                            <a class="btn-collapse" data-bs-toggle="collapse"
                                                href="#collapse{{ $item->id }}" role="button" aria-expanded="false"
                                                aria-controls="collapse{{ $item->id }}"></a>
                                        @endif
                                    </div>

                                    @if ($item->children)
                                        <div class="collapse" id="collapse{{ $item->id }}">
                                            <div class="card border-0">
                                                @forelse($item->children as $child)
                                                    <a href="{{ route('catProduct', ['slug' => $child->slug, 'id' => $child->id]) }}"
                                                        class="cate-child">
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
            @if (count($list_coupon))
                <div class="list-coupon">
                    <h2 class="text-center">Mã khuyến mại</h2>
                    <div class="slide-main-coupon">
                        <div class="slide-template-slide-coupon owl-carousel justify-content-center">
                            @forelse($list_coupon as $item)
                                @if ($item->items)
                                    <div class="item-coupon">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="box-coupon box-coupon-left text-center">
                                                <svg width="50" height="50" viewBox="0 0 50 50" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <circle cx="25" cy="25" r="25" fill="#C73030" />
                                                    <path
                                                        d="M15 37.5V23.75H12.5V16.25H19C18.8958 16.0625 18.8281 15.8646 18.7969 15.6562C18.7656 15.4479 18.75 15.2292 18.75 15C18.75 13.9583 19.1146 13.0729 19.8438 12.3438C20.5729 11.6146 21.4583 11.25 22.5 11.25C22.9792 11.25 23.4271 11.3385 23.8438 11.5156C24.2604 11.6927 24.6458 11.9375 25 12.25C25.3542 11.9167 25.7396 11.6667 26.1562 11.5C26.5729 11.3333 27.0208 11.25 27.5 11.25C28.5417 11.25 29.4271 11.6146 30.1562 12.3438C30.8854 13.0729 31.25 13.9583 31.25 15C31.25 15.2292 31.2292 15.4427 31.1875 15.6406C31.1458 15.8385 31.0833 16.0417 31 16.25H37.5V23.75H35V37.5H15ZM27.5 13.75C27.1458 13.75 26.849 13.8698 26.6094 14.1094C26.3698 14.349 26.25 14.6458 26.25 15C26.25 15.3542 26.3698 15.651 26.6094 15.8906C26.849 16.1302 27.1458 16.25 27.5 16.25C27.8542 16.25 28.151 16.1302 28.3906 15.8906C28.6302 15.651 28.75 15.3542 28.75 15C28.75 14.6458 28.6302 14.349 28.3906 14.1094C28.151 13.8698 27.8542 13.75 27.5 13.75ZM21.25 15C21.25 15.3542 21.3698 15.651 21.6094 15.8906C21.849 16.1302 22.1458 16.25 22.5 16.25C22.8542 16.25 23.151 16.1302 23.3906 15.8906C23.6302 15.651 23.75 15.3542 23.75 15C23.75 14.6458 23.6302 14.349 23.3906 14.1094C23.151 13.8698 22.8542 13.75 22.5 13.75C22.1458 13.75 21.849 13.8698 21.6094 14.1094C21.3698 14.349 21.25 14.6458 21.25 15ZM15 18.75V21.25H23.75V18.75H15ZM23.75 35V23.75H17.5V35H23.75ZM26.25 35H32.5V23.75H26.25V35ZM35 21.25V18.75H26.25V21.25H35Z"
                                                        fill="white" />
                                                </svg>
                                            </div>
                                            <div class="box-coupon box-coupon-right w-100">
                                                @if ($item->value_type == 1)
                                                    <p class="sub-title-coupon">Giảm {{ $item->value }}đ</p>
                                                @else
                                                    <p class="sub-title-coupon">Giảm {{ $item->value }}</p>
                                                @endif
                                                <div class="voucher-detail pb-2">
                                                    {{ $item->name }}

                                                </div>
                                                <div class="progress">
                                                    <div class="progress-bar bg-danger" role="progressbar"
                                                        style="width: {{ $item->progressbar }}%"
                                                        aria-valuenow="{{ $item->progressbar }}" aria-valuemin="0"
                                                        aria-valuemax="100"
                                                        aria-label="Progress: {{ $item->progressbar }}%">
                                                    </div>
                                                </div>

                                                <div class="d-flex justify-content-between align-items-center mt-1">
                                                    <button type="button" class="btn btn-call-modal p-0 btn-value"
                                                        data-value-coupon="{{ json_encode($item) }}"
                                                        data-bs-toggle="modal" data-bs-target="#info-coupon-detail">Chi
                                                        tiết</button>
                                                    <button type="button" class="btn btn-dark btn-copy"
                                                        data-coupon="{{ $item->items['code'] }}">Sao chép</button>
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
            @if (count($product_flash))
                <div class="section-flash-mobile d-block slide-template bg-white mb-4 pt-1">
                    <div class="slide-top">
                        <div class="slide-title d-flex align-items-center gap-2">
                            <a href="{{ route('flashSaleProducts') }}" title="Flash Deal"
                                class="d-flex align-items-center gap-2">
                                <img data-src="{{ asset('images/hot_icon.svg') }}" alt="flash deal icon"
                                    class="img-fluid lazy" height="18" width="18">
                                <h2>Flash Deal</h2>
                            </a>
                            {{--                        | --}}
                            {{--                        <div is-title="true" class="count-down d-flex align-items-center gap-1" time-end="Oct 30 2023 20:00:00"></div> --}}
                        </div>
                        <a href="{{ route('flashSaleProducts') }}" class="slide-more">Xem tất cả</a>
                    </div>
                    <div class="slide-main">
                        <div class="slide-template-slide owl-carousel">
                            @if (!empty($product_flash))
                                @forelse($product_flash as $item_fl)
                                    <a href="{{ route('detailProduct', ['slug' => trim($item_fl->slug), 'sku' => $item_fl->sku]) }}"
                                        class="product-template">
                                        @if ($item_fl->promotionItem->price != $item_fl->normal_price)
                                            <div class="product-discount">
                                                <span
                                                    class="pe-1">{{ percentage_price($item_fl->promotionItem->price, $item_fl->normal_price) }}</span>
                                            </div>
                                        @endif
                                        <div
                                            class="product-thumbnail position-relative @if ($item_fl->promotionItem && $item_fl->promotionItem->applied_stop_time) image-frame1 @endif">

                                            <picture>
                                                <source
                                                    srcset="{{ asset(preg_replace('/\.(png|jpg|jpeg)$/i', '.webp', $item_fl->image_first)) }}"
                                                    type="image/webp">
                                                <img src="{{ asset($item_fl->image_first) }}"
                                                    alt="{{ $item_fl->title }}" class="img-fluid">
                                            </picture>

                                            @if (!empty($item_fl->promotionItem->image_deal))
                                                <div class="position-absolute top-0 image-frame-top">
                                             
                                                        <img src="{{ asset($item_fl->promotionItem->image_deal) }}" alt="">
                                                </div>
                                            @endif
                                        </div>
                                        <div class="product-price px-2">
                                            <div class="public-price">{{ format_money($item_fl->promotionItem->price) }}
                                            </div>
                                            @if ($item_fl->promotionItem->price != $item_fl->normal_price)
                                                <div class="origin-price">{{ format_money($item_fl->normal_price) }}</div>
                                            @endif
                                        </div>
                                        <div class="product-brand px-2" style="height: 18px">
                                            {{ $item_fl->brand ?? $item_fl->opbrand }}
                                        </div>
                                        <div class="product-title px-2">
                                            {{ $item_fl->title }}
                                        </div>
                                        @if ($item_fl->promotionItem && $item_fl->promotionItem->applied_stop_time)
                                            <div class="product-progress-sale count-down"
                                                time-end="{{ $item_fl->promotionItem->applied_stop_time }}"></div>
                                        @endif
                                    </a>
                                @empty
                                @endforelse
                            @endif
                        </div>
                    </div>
                </div>
            @endif
            @if (!empty($product_hots))
                <div class="slide-template bg-white mb-4 pt-2">
                    <div class="slide-top">
                        <a href="{{ route('itemHotProducts') }}" class="slide-title d-flex align-items-center gap-2">
                               <img data-src="{{ asset('images/hot_tag.svg') }}" alt="flash deal icon"
                                    class="img-fluid lazy" height="18" width="18">
                            <h2>Sản phẩm hot</h2>
                        </a>
                        <a href="{{ route('itemHotProducts') }}" class="slide-more">
                            Xem tất cả
                        </a>
                    </div>
                    <div class="slide-main">
                        <div class="slide-template-slide owl-carousel">
                            @forelse($product_hots as $item)
                                <a href="{{ route('detailProduct', ['slug' => !empty($item->slug) ? trim($item->slug) : $item->product->slug, 'sku' => $item->sku]) }}"
                                    class="product-template">
                                    @if ($item->promotionItem)
                                        @if ($item->promotionItem->price != $item->normal_price)
                                            <div class="product-discount">
                                                <span
                                                    class="pe-1">{{ percentage_price($item->promotionItem->price, $item->normal_price) }}</span>
                                            </div>
                                        @endif
                                    @else
                                        @if ($item->price != $item->normal_price)
                                            <div class="product-discount">
                                                <span
                                                    class="pe-1">{{ percentage_price($item->price, $item->normal_price) }}</span>
                                            </div>
                                        @endif
                                    @endif
                                    <div
                                        class="product-thumbnail position-relative  @if ($item->promotionItem && $item->promotionItem->applied_stop_time) image-frame1 @endif">
                                        <picture>
                                            <source
                                                srcset="{{ asset(preg_replace('/\.(png|jpg|jpeg)$/i', '.webp', $item->image_first)) }}"
                                                type="image/webp">
                                            <img src="{{ asset($item->image_first) }}" alt="{{ $item->title }}"
                                                class="img-fluid">
                                        </picture>
                                        @if ($setting['frame_image_for_hot'])
                                            <div class="position-absolute top-0 bottom-0"> <img
                                                    src="{{ asset($setting['frame_image_for_hot']) }}" alt="">
                                            </div>
                                        @else
                                            @if ($setting['frame_image_for_sale'])
                                                <div class="position-absolute top-0 bottom-0">
                                                    <img src="{{ asset($setting['frame_image_for_sale']) }}"
                                                        alt="">
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                    <div class="product-price px-2">
                                        @if ($item->promotionItem)
                                            <div class="public-price">{{ format_money($item->promotionItem->price) }}
                                            </div>
                                            @if ($item->promotionItem->price != $item->normal_price)
                                                <div class="origin-price">{{ format_money($item->normal_price) }}</div>
                                            @endif
                                        @else
                                            <div class="public-price">{{ format_money($item->price) }}</div>
                                            @if ($item->price != $item->normal_price)
                                                <div class="origin-price">{{ format_money($item->normal_price) }}</div>
                                            @endif
                                        @endif
                                    </div>
                                    <div class="product-brand px-2" style="height: 18px">
                                        {{ $item->brand ?? $item->opbrand }}
                                    </div>
                                    <div class="product-title px-2">
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
                        <h2>Thương hiệu nổi bật</h2>
                    </a>
                    <a href="{{ route('homeBrand') }}" class="slide-more">
                        Xem tất cả
                    </a>
                </div>
                <div class="slide-main">
                    <div class="slide-template-slide slide-brand owl-carousel">
                        @if (!empty($attribute_brand))
                            @forelse($attribute_brand as $item)
                                <a href="{{ route('detailBrand', ['slug' => $item->slug, 'id' => $item->id]) }}"
                                    class="brand-template">
                                    <img data-src="{{ asset(replace_image($item->image)) }}"
                                        alt="{{ $item->name }} logo" class="img-fluid lazy">
                                    <div class="title">{{ $item->name }}</div>
                                </a>
                            @empty
                            @endforelse
                        @endif
                    </div>
                </div>
            </div>

            <div class="section-product-category">
                @if (!empty($cats))
                    @forelse($cats as $cat)
                        <div class="section mb-5">
                            <div class="section-top">
                                <div class="section-menu">
                                    <a href="{{ route('catProduct', ['slug' => $cat->slug, 'id' => $cat->id]) }}"
                                        class="section-title">
                                        <h2 class="text-uppercase mb-0">{{ $cat->title }}</h2>
                                    </a>
                                    <div class="section-sub-menu">
                                        @if (!empty($cat_sub[$cat->id]))
                                            @forelse($cat_sub[$cat->id] as $sub)
                                                <a href="{{ route('catProduct', ['slug' => $sub->slug, 'id' => $sub->id]) }}"
                                                    class="text-uppercase">{{ $sub->title }}</a>
                                            @empty
                                            @endforelse
                                        @endif
                                    </div>
                                </div>
                                <a href="{{ route('catProduct', ['slug' => $cat->slug, 'id' => $cat->id]) }}"
                                    class="section-more text-uppercase">Xem thêm</a>
                            </div>
                            <div class="section-main bg-white">
                                <div class="section-poster">
                                    <a href="{{ route('catProduct', ['slug' => $cat->slug, 'id' => $cat->id]) }}">
                                        <img data-src="{{ asset(replace_image($cat->banner)) }}"
                                            alt="{{ $cat->title }}" class="img-fluid lazy">
                                    </a>
                                </div>
                                <div class="section-content">
                                    @if ($product_cats && !empty($product_cats[$cat->id]))
                                        @forelse($product_cats[$cat->id] as $item)
                                            <a href="{{ route('detailProduct', ['slug' => !empty($item->slug) ? trim($item->slug) : $item->product->slug, 'sku' => $item->sku]) }}"
                                                class="product-template @if (
                                                    $item->promotionItem ||
                                                        ($setting['frame_image_for_sale'] && $item->promotionItem && $item->promotionItem->applied_stop_time)) khung-sale @endif">
                                                @if ($item->promotionItem)
                                                    @if ($item->promotionItem->price != $item->normal_price)
                                                        <div class="product-discount">
                                                            <span
                                                                class="pe-1">{{ percentage_price($item->promotionItem->price, $item->normal_price) }}</span>
                                                        </div>
                                                    @endif
                                                @else
                                                    @if ($item->price != $item->normal_price)
                                                        <div class="product-discount">
                                                            <span
                                                                class="pe-1">{{ percentage_price($item->price, $item->normal_price) }}</span>
                                                        </div>
                                                    @endif
                                                @endif
                                                <div
                                                    class="product-thumbnail position-relative  @if ($item->promotionItem && $item->promotionItem->applied_stop_time) image-frame-home-1 @endif">
                                                    <picture>
                                                        <source
                                                            srcset="{{ asset(preg_replace('/\.(png|jpg|jpeg)$/i', '.webp', $item->image_first)) }}"
                                                            type="image/webp">
                                                        <img data-src="{{ asset($item->image_first) }}"
                                                            alt="{{ $item->title }}" class="img-fluid lazy">
                                                    </picture>
                                                    @if ($item->promotionItem && !empty($item->promotionItem->image_deal))
                                                        <div class="position-absolute top-0 image-frame-top">
                                                            <img src="{{ asset($item->promotionItem->image_deal) }}"
                                                                alt="">
                                                        </div>
                                                    @else
                                                        @if (!empty($setting['frame_image_for_sale']) && $item->promotionItem && !empty($item->promotionItem->applied_stop_time))
                                                            <div class="position-absolute top-0 image-frame-top">
                                                                <img src="{{ asset($setting['frame_image_for_sale']) }}"
                                                                    alt="">
                                                            </div>
                                                        @endif
                                                    @endif
                                                </div>

                                                <div class="product-price">
                                                    @if ($item->promotionItem)
                                                        <div class="public-price">
                                                            {{ format_money($item->promotionItem->price) }}</div>
                                                        @if ($item->promotionItem->price != $item->normal_price)
                                                            <div class="origin-price">
                                                                {{ format_money($item->normal_price) }}</div>
                                                        @endif
                                                    @else
                                                        <div class="public-price">{{ format_money($item->price) }}</div>
                                                        @if ($item->price != $item->normal_price)
                                                            <div class="origin-price">
                                                                {{ format_money($item->normal_price) }}</div>
                                                        @endif
                                                    @endif
                                                </div>
                                                <div class="product-brand" style="height: 18px">
                                                    {{ $item->brand ?? $item->opbrand }}
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
                @if (!empty($subBanner2))
                    @forelse($subBanner2 as $item)
                        <a class="" href="{{ $item->url }}" aria-label="{{ $item->content }}">
                            <img alt="{{ $item->content }}" data-src="{{ asset(replace_image($item->image_url)) }}"
                                class="img-fluid lazy">
                        </a>
                    @empty
                    @endforelse
                @endif
            </div>
            @if (!empty($articles) && !$isMobile)
                <div class="section-article mb-5">
                    <div class="section-top">
                        <a href="{{ route('homeArticle') }}">
                            <h2 class="text-uppercase">Tin tức & sự kiện</h2>
                        </a>
                        <a href="{{ route('homeArticle') }}" class="text-uppercase">Xem tất cả</a>
                    </div>
                    <div class="section-main">

                        @forelse($articles as $item)
                            <a href="{{ route('detailArticle', ['slug' => $item->slug, 'id' => $item->id]) }}"
                                class="article-item" title="{{ $item->title }}">
                                <div class="article-img">
                                    <img data-src="{{ asset(replace_image($item->image)) }}" alt="{{ $item->title }}"
                                        class="img-fluid lazy">
                                </div>
                                <div class="article-title">
                                    <span>
                                        {!! strip_tags($item->description) !!}
                                    </span>
                                </div>
                            </a>
                        @empty
                        @endforelse
                    </div>
                </div>
            @endif
            @if (count($stores))
                <div class="section-store mb-5">
                    <div class="section-top">
                        <a href="#">
                            <h2 class="text-uppercase">Danh sách cửa hàng</h2>
                        </a>
                    </div>
                    <div class="section-store-main owl-carousel">
                        @forelse($stores as $item)
                            <div>
                                <a class='ccs-item-store--img'>
                                    <img data-src="{{ asset($item->image) }}" alt="{{ $item->name }}"
                                        class="img-fluid lazy" />
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
    <div class="modal fade" id="info-coupon-detail" tabindex="-1" aria-labelledby="couponModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="couponModalLabel">Chi tiết Mã khuyến mại</h5>
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
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M15.8334 15.8334H6.66669C6.20835 15.8334 5.81599 15.6702 5.4896 15.3438C5.16321 15.0174 5.00002 14.625 5.00002 14.1667V2.50004C5.00002 2.04171 5.16321 1.64935 5.4896 1.32296C5.81599 0.996568 6.20835 0.833374 6.66669 0.833374H12.5L17.5 5.83337V14.1667C17.5 14.625 17.3368 15.0174 17.0104 15.3438C16.684 15.6702 16.2917 15.8334 15.8334 15.8334ZM11.6667 6.66671V2.50004H6.66669V14.1667H15.8334V6.66671H11.6667ZM3.33335 19.1667C2.87502 19.1667 2.48266 19.0035 2.15627 18.6771C1.82988 18.3507 1.66669 17.9584 1.66669 17.5V5.83337H3.33335V17.5H12.5V19.1667H3.33335Z"
                                    fill="#C73030" />
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

                        <p class="infomotion-coupon-option">Không áp dụng đồng thời CTKM khác</p>

                    </div>
                </div>
                <div class="modal-footer justify-content-between align-items-center flex-nowrap">
                    <button type="button" class="btn btn-white" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-dark coupon-end" id="coupon-end" data-coupon="">Sao
                        chép</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('link')
    @parent
    <link href="{{ mix('css/web/home.css') }}" rel="stylesheet">
@endsection

@section('script')
    @parent
    <script src="{{ mix('js/web/home_jq_owl.js') }}"></script>
    <script src="{{ mix('js/web/home_bs.js') }}"></script>
    <script src="{{ mix('js/web/home.js') }}"></script>

    @include('web.components.extend')
@endsection
