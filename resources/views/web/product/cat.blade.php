@extends('web.layouts.web')

@section('content')
    <main>

        <div class="container">
            <nav aria-label="breadcrumb" class="pt-3 pb-3 mb-4">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="#">
                            <i class="fa-solid fa-house-chimney"></i>
                            Trang chủ
                        </a>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">
                        Danh mục
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Trang điểm
                    </li>
                </ol>
            </nav>

            <div class="layout-page-products-list mb-5">
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
                                    @forelse($cats as $item)
                                    <a href="{{ route('catProduct',['slug' => $item->slug, 'id' => $item->id]) }}" class="filter-item @if($item->parent_id) filter-item-child @endif">{{ $item->title }}</a>
                                    @empty
                                    @endforelse
                                </div>
                            </div>
                            @forelse($attributes as $attribute)
                            <div class="filter-group">
                                <div class="filter-group-title">{{ $attribute->name }}</div>
                                <div class="filter-group-items">
                                    @forelse($attribute->attributeValue as $item)
                                    <a class="filter-item" href="">{{ $item->name }} <span class="d-none">(62)</span></a>
                                    @empty
                                    @endforelse
                                </div>
                            </div>
                            @empty
                            @endforelse
                        </div>
                    </div>
                    <div class="layout-list">
                        <div class="layout-title text-uppercase fw-bold">
                            <h1>{{ $cat->title }} ({{ $products->total() }} KẾT QUẢ)</h1>
                        </div>

                        <div class="layout-card">
                            <div class="card-group">
                                <div class="card-title">Lọc theo</div>
                                <div class="card-items">
                                    <a href="" class="card-item card-filter active">
                                        Danh mục - Trang điểm mặt
                                        <div class="del-icon">
                                            <img src="{{ asset('images/ic-delete.svg') }}" alt="del" class="img-fluid">
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="card-group">
                                <div class="card-title">Sắp xếp theo</div>
                                <div class="card-items">
                                    <a href="" class="card-item card-sort active">Nổi bật</a>
                                    <a href="" class="card-item card-sort">Bán chạy</a>
                                    <a href="" class="card-item card-sort">Hàng mới</a>
                                    <a href="" class="card-item card-sort">Giá cao tới thấp</a>
                                    <a href="" class="card-item card-sort">Giá thấp tới cao</a>
                                </div>
                            </div>
                        </div>

                        <div class="layout-list-items mb-4">
                            @forelse($products as $item)
                            <a href="{{ route('detailProduct',['slug' => $item->product->slug,'sku' => $item->sku]) }}" class="product-template">
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
                        </div>

                        {{ $products->links('web.components.pagination') }}
                    </div>
                </div>

                <div class="layout-bottom mb-5 bg-white">
                    <div class="layout-article less">
                        {!! $cat->content !!}
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
    <link rel="stylesheet" href="{{ asset('/css/web/product-cat.css') }}">
@endsection

@section('script')
    @parent
    <script>
        $('.btn-more-less').click(function() {
            $(this).toggleClass('less');
            $('.layout-article').toggleClass('less');
        })
    </script>
@endsection
