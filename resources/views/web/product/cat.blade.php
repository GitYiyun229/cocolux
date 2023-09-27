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
                                    <a class="filter-item @if($item->parent_id) filter-item-child @endif">{{ $item->title }}</a>
                                    @empty
                                    @endforelse
                                </div>
                            </div>
                            @forelse($attributes as $attribute)
                            <div class="filter-group">
                                <div class="filter-group-title">{{ $attribute->name }}</div>
                                <div class="filter-group-items">
                                    @forelse($attribute->attributeValue as $item)
                                    <a class="filter-item">{{ $item->name }} <span>(62)</span></a>
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
                            <h1>Trang điểm (800 KẾT QUẢ)</h1>
                        </div>

                        <div class="layout-card">
                            <div class="card-group">
                                <div class="card-title">Lọc theo</div>
                                <div class="card-items">
                                    <a href="" class="card-item card-filter active">
                                        Danh mục - Trang điểm mặt
                                        <div class="del-icon">
                                            <img src="./images/ic-delete.svg" alt="del" class="img-fluid">
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

                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-center">
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>

                <div class="layout-bottom mb-5 bg-white">
                    <div class="layout-article less">
                        <p>
                            Ngày nay trang điểm đã trở thành một kỹ năng không thể thiếu đối với chị em phụ nữ. Nếu bạn đang tập tành học trang điểm, thì hãy đọc bài viết này để nắm được các bước trang điểm cơ bản cho người mới bắt đầu nhé.
                            Trang điểm là một nghệ thuật kỳ diệu, nhưng không phải là quá khó. Make up theo kiểu cơ bản và tự nhiên không đòi hỏi nhiều kỹ thuật hay dụng cụ. Bạn thậm chí có thể phối hợp màu sắc chỉ với những ngón tay của mình nếu như cảm thấy các dụng cụ make up không phù hợp với bạn. Vì thế đừng lo lắng bắt tay vào trang điểm ngay để có một gương mặt tươi tắn và rạng ngời!
                        </p>
                        <p>
                            <img src="./img-example/1644976001639-kem-nen-fit-me-maybelline-m-p-spf-22-300x300.jpeg" alt="">
                        </p>
                        <p>
                            Ngày nay trang điểm đã trở thành một kỹ năng không thể thiếu đối với chị em phụ nữ. Nếu bạn đang tập tành học trang điểm, thì hãy đọc bài viết này để nắm được các bước trang điểm cơ bản cho người mới bắt đầu nhé.
                            Trang điểm là một nghệ thuật kỳ diệu, nhưng không phải là quá khó. Make up theo kiểu cơ bản và tự nhiên không đòi hỏi nhiều kỹ thuật hay dụng cụ. Bạn thậm chí có thể phối hợp màu sắc chỉ với những ngón tay của mình nếu như cảm thấy các dụng cụ make up không phù hợp với bạn. Vì thế đừng lo lắng bắt tay vào trang điểm ngay để có một gương mặt tươi tắn và rạng ngời!
                        </p>
                        <p>
                            Ngày nay trang điểm đã trở thành một kỹ năng không thể thiếu đối với chị em phụ nữ. Nếu bạn đang tập tành học trang điểm, thì hãy đọc bài viết này để nắm được các bước trang điểm cơ bản cho người mới bắt đầu nhé.
                            Trang điểm là một nghệ thuật kỳ diệu, nhưng không phải là quá khó. Make up theo kiểu cơ bản và tự nhiên không đòi hỏi nhiều kỹ thuật hay dụng cụ. Bạn thậm chí có thể phối hợp màu sắc chỉ với những ngón tay của mình nếu như cảm thấy các dụng cụ make up không phù hợp với bạn. Vì thế đừng lo lắng bắt tay vào trang điểm ngay để có một gương mặt tươi tắn và rạng ngời!
                        </p>
                        <p>
                            Ngày nay trang điểm đã trở thành một kỹ năng không thể thiếu đối với chị em phụ nữ. Nếu bạn đang tập tành học trang điểm, thì hãy đọc bài viết này để nắm được các bước trang điểm cơ bản cho người mới bắt đầu nhé.
                            Trang điểm là một nghệ thuật kỳ diệu, nhưng không phải là quá khó. Make up theo kiểu cơ bản và tự nhiên không đòi hỏi nhiều kỹ thuật hay dụng cụ. Bạn thậm chí có thể phối hợp màu sắc chỉ với những ngón tay của mình nếu như cảm thấy các dụng cụ make up không phù hợp với bạn. Vì thế đừng lo lắng bắt tay vào trang điểm ngay để có một gương mặt tươi tắn và rạng ngời!
                        </p>
                        <p>
                            <img src="./img-example/1695263021297-review-son-kem-black-rouge-do-dat-500x500.jpeg" alt="">
                        </p>
                        <p>
                            Ngày nay trang điểm đã trở thành một kỹ năng không thể thiếu đối với chị em phụ nữ. Nếu bạn đang tập tành học trang điểm, thì hãy đọc bài viết này để nắm được các bước trang điểm cơ bản cho người mới bắt đầu nhé.
                            Trang điểm là một nghệ thuật kỳ diệu, nhưng không phải là quá khó. Make up theo kiểu cơ bản và tự nhiên không đòi hỏi nhiều kỹ thuật hay dụng cụ. Bạn thậm chí có thể phối hợp màu sắc chỉ với những ngón tay của mình nếu như cảm thấy các dụng cụ make up không phù hợp với bạn. Vì thế đừng lo lắng bắt tay vào trang điểm ngay để có một gương mặt tươi tắn và rạng ngời!
                        </p>
                        <p>
                            Ngày nay trang điểm đã trở thành một kỹ năng không thể thiếu đối với chị em phụ nữ. Nếu bạn đang tập tành học trang điểm, thì hãy đọc bài viết này để nắm được các bước trang điểm cơ bản cho người mới bắt đầu nhé.
                            Trang điểm là một nghệ thuật kỳ diệu, nhưng không phải là quá khó. Make up theo kiểu cơ bản và tự nhiên không đòi hỏi nhiều kỹ thuật hay dụng cụ. Bạn thậm chí có thể phối hợp màu sắc chỉ với những ngón tay của mình nếu như cảm thấy các dụng cụ make up không phù hợp với bạn. Vì thế đừng lo lắng bắt tay vào trang điểm ngay để có một gương mặt tươi tắn và rạng ngời!
                        </p>
                        <p>
                            Ngày nay trang điểm đã trở thành một kỹ năng không thể thiếu đối với chị em phụ nữ. Nếu bạn đang tập tành học trang điểm, thì hãy đọc bài viết này để nắm được các bước trang điểm cơ bản cho người mới bắt đầu nhé.
                            Trang điểm là một nghệ thuật kỳ diệu, nhưng không phải là quá khó. Make up theo kiểu cơ bản và tự nhiên không đòi hỏi nhiều kỹ thuật hay dụng cụ. Bạn thậm chí có thể phối hợp màu sắc chỉ với những ngón tay của mình nếu như cảm thấy các dụng cụ make up không phù hợp với bạn. Vì thế đừng lo lắng bắt tay vào trang điểm ngay để có một gương mặt tươi tắn và rạng ngời!
                        </p>
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
