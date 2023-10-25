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
                <form action="{{ route('search') }}" id="form_filter" method="get">
                    <input type="hidden" name="keyword" value="{{ $keyword }}">
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
                                        <div class="filter-group-items {{ $attribute->code }}">
                                            @forelse($attribute->attributeValue as $item)
                                                <span class="filter-item" data-name="{{ $attribute->code }}" data-value="{{ $item->id }}" >
                                                    <input type="hidden" name="{{ $attribute->code }}" value="{{ request($attribute->code) == $item->id ? $item->id : '' }}">
                                                    {{ $item->name }} <span>({{ $countArray[$attribute->id.':'.$item->id] }})</span>
                                                </span>
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
                                <h1>({{ $products->total() }} KẾT QUẢ)</h1>
                            </div>

                            <div class="layout-card">
                                <div class="card-group">
                                    <div class="card-title">Lọc theo</div>
                                    <div class="card-items">
                                        <span class="card-item card-filter active">
                                            Từ khóa: {{ $keyword }}
                                        </span>
                                        @forelse($attributes as $attribute)
                                            @if(request($attribute->code))
                                                <span class="card-item card-filter active">
                                                    {{ $attribute->name }}:
                                                    @forelse($attribute->attributeValue as $item)
                                                        @if(request($attribute->code) == $item->id)
                                                            {{ $item->name }}
                                                        @endif
                                                    @empty
                                                    @endforelse
                                                    <div class="del-icon" data-code="{{ $attribute->code }}">
                                                        <img src="{{ asset('images/ic-delete.svg') }}" alt="del" class="img-fluid">
                                                    </div>
                                                </span>
                                            @endif
                                        @empty
                                        @endforelse

                                    </div>
                                </div>
                                <div class="card-group">
                                    <div class="card-title">Sắp xếp theo</div>
                                    <div class="card-items">
                                        @forelse($sorts as $k => $item)
                                        <span class="card-item card-sort {{ request('sort') == $k ? 'active' : '' }}" data-name="sort" data-value="{{ $k }}">
                                            <input type="hidden" name="sort" value="{{ request('sort') == $k ? $k : '' }}">
                                            {{ $item }}
                                        </span>
                                        @empty
                                        @endforelse
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
                </form>
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

        $('.filter-item').click(function () {
            var newValue = $(this).data('value');
            var className = $(this).data('name');
            $('.'+className).find('input[type="hidden"]').val(null);
            $(this).find('input[type="hidden"]').val(newValue);
            $('#form_filter').submit();
        });

        $('.card-item').click(function () {
            var newValue = $(this).data('value');
            $('.card-item').find('input[type="hidden"]').val(null);
            $(this).find('input[type="hidden"]').val(newValue);
            $('#form_filter').submit();
        });

        $('.del-icon').click(function () {
            var className = $(this).data('code');
            $('.'+className).find('input[type="hidden"]').val(null);
            $('#form_filter').submit();
        });

        $('#form_filter').submit(function () {
            $(this).find('input').each(function () {
                if ($(this).val() === '') {
                    $(this).remove(); // Loại bỏ input
                    // $(this).prop('disabled', true); // Vô hiệu hóa input
                }
            });
        });

    </script>
@endsection
