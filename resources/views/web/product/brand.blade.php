@extends('web.layouts.web')

@section('content')
    <main>

        <div class="container">
            <nav aria-label="breadcrumb" class="pt-3 pb-3 mb-4">
                {{ Breadcrumbs::render('detailBrand', $brand) }}
            </nav>

            <div class="layout-page-products-list mb-5">
                <form action="" id="form_filter" method="get">
                    <div class="layout-main mb-5 bg-white">
                        <div class="layout-filter">
                            <div class="layout-title text-uppercase fw-bold">
                                <i class="fa-solid fa-filter"></i>
                                <span>Bộ lọc tìm kiếm</span>
                            </div>
                            <div class="filter-list">
                                <div class="filter-group">
                                    <div class="filter-group-title">Danh mục</div>
                                    <div class="filter-group-items">
                                        @if (!empty($cats))
                                            @forelse($cats as $item)
                                                <a href="{{ route('catProduct', ['slug' => $item->slug, 'id' => $item->id]) }}"
                                                    class="filter-item @if ($item->parent_id) filter-item-child @endif">{{ $item->title }}</a>
                                            @empty
                                            @endforelse
                                        @endif
                                    </div>
                                </div>
                                @if (!empty($attributes))
                                    @forelse($attributes as $attribute)
                                        <div class="filter-group">
                                            <div class="filter-group-title">{{ $attribute->name }}</div>
                                            <div class="filter-group-items {{ $attribute->code }}">
                                                @if (!empty($attribute->attributeValue))
                                                    @forelse($attribute->attributeValue as $item)
                                                        <span class="filter-item" data-name="{{ $attribute->code }}"
                                                            data-value="{{ $item->id }}">
                                                            <input type="hidden" name="{{ $attribute->code }}"
                                                                value="{{ request($attribute->code) == $item->id ? $item->id : '' }}">
                                                            {{ $item->name }}
                                                            <span>({{ $countArray[$attribute->id . ':' . $item->id] }})</span>
                                                        </span>
                                                    @empty
                                                    @endforelse
                                                @endif
                                            </div>
                                        </div>
                                    @empty
                                    @endforelse
                                @endif
                            </div>
                        </div>
                        <div class="layout-list">
                            <div class="layout-title text-uppercase fw-bold">
                                <h1>{{ $brand->name }} ({{ $products->total() }} KẾT QUẢ)</h1>
                            </div>

                            <div class="layout-card">
                                <div class="card-group">
                                    <div class="card-title">Lọc theo</div>
                                    <div class="card-items">
                                        <span class="card-item card-filter active">
                                            Thương hiệu: {{ $brand->name }}
                                        </span>
                                        @if (!empty($attributes))
                                            @forelse($attributes as $attribute)
                                                @if (request($attribute->code))
                                                    <span class="card-item card-filter active">
                                                        {{ $attribute->name }}:
                                                        @if (!empty($attribute->attributeValue))
                                                            @forelse($attribute->attributeValue as $item)
                                                                @if (request($attribute->code) == $item->id)
                                                                    {{ $item->name }}
                                                                @endif
                                                            @empty
                                                            @endforelse
                                                        @endif
                                                        <div class="del-icon" data-code="{{ $attribute->code }}">
                                                            <img src="{{ asset('images/ic-delete.svg') }}" alt="del"
                                                                class="img-fluid">
                                                        </div>
                                                    </span>
                                                @endif
                                            @empty
                                            @endforelse
                                        @endif
                                    </div>
                                </div>
                                <div class="card-group">
                                    <div class="card-title">Sắp xếp theo</div>
                                    <div class="card-items">
                                        @if (!empty($sorts))
                                            @forelse($sorts as $k => $item)
                                                <span
                                                    class="card-item card-sort {{ request('sort') == $k ? 'active' : '' }}"
                                                    data-name="sort" data-value="{{ $k }}">
                                                    <input type="hidden" name="sort"
                                                        value="{{ request('sort') == $k ? $k : '' }}">
                                                    {{ $item }}
                                                </span>
                                            @empty
                                            @endforelse
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="layout-list-items mb-4">
                                @if (!empty($products))
                                    @forelse($products as $item)
                                        <a href="{{ route('detailProduct', ['slug' => !empty($item->slug) ? trim($item->slug) : trim($item->product->slug), 'sku' => $item->sku]) }}"
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
                                            @if (empty($item->stocks))
                                                <img src="{{ asset('images/ic-tam-het-hang.png') }}" alt="Tạm hết hàng"
                                                    class="img-fluid lazy position-absolute">
                                            @endif
                                            <div
                                                class="product-thumbnail position-relative @if ($item->promotionItem && $item->promotionItem->applied_stop_time) image-frame2 @endif">
                                                <img src="{{ asset($item->image_first) }}" alt="{{ $item->title }}"
                                                    class="img-fluid">
                                                @if (!empty($item->promotionItem->image_deal))
                                                    <div class="position-absolute  bottom-0 image-frame-top">
                                                        <img src="{{ asset(preg_replace('/\.(png|jpg|jpeg)$/i', '.webp', $item->promotionItem->image_deal)) }}"
                                                            alt="">
                                                    </div>
                                                @else
                                                    @if ($setting['frame_image_for_sale'])
                                                        <div class="position-absolute  bottom-0 image-frame-top"> <img
                                                                src="{{ asset($setting['frame_image_for_sale']) }}"
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
                                                        <div class="origin-price">{{ format_money($item->normal_price) }}
                                                        </div>
                                                    @endif
                                                @else
                                                    <div class="public-price">{{ format_money($item->price) }}</div>
                                                    @if ($item->price != $item->normal_price)
                                                        <div class="origin-price">{{ format_money($item->normal_price) }}
                                                        </div>
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

                            {{ $products->links('web.components.pagination') }}
                        </div>
                    </div>
                </form>

                <div class="layout-bottom mb-5 bg-white">
                    <div class="layout-article less">
                        {!! replace_image($brand->content) !!}
                    </div>
                    <div class="layout-btn-toggle d-flex align-items-center justify-content-center">
                        <button class="btn-more-less">
                            <span>Xem thêm</span>
                            <i class="fa-solid fa-angles-down"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </main>
@endsection

@section('link')
    @parent
    <link rel="stylesheet" href="{{ mix('css/web/product-cat.css') }}">
    <style>
        .image-frame2 {
            border-radius: 8px;
            display: inline-block;
            padding: 0px 5px 0px 5px;

        }

        .image-frame-top {
            top: 0px;
        }

       .product-template .product-thumbnail img {
            height: 188px;
        }
    </style>
@endsection

@section('script')
    @parent
    <script src="{{ mix('js/web/product-brand.js') }}"></script>
    @include('web.components.extend')
@endsection
