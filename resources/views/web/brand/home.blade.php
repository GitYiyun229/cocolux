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
                    <li class="breadcrumb-item active" aria-current="page">
                        Thương hiệu
                    </li>
                </ol>
            </nav>

            <div class="layout-page-brand mb-5">
                <div class="fw-bold mb-3 total-brand">Xem {{ $totalBrandCount }} thương hiệu</div>

                <div class="alphabet-brand mb-4">
                    @forelse($brands as $k => $item)
                    <a href="#brand_{{ $k }}" class="fw-bold text-uppercase alphabet-brand-item">
                        {{ $k }}
                    </a>
                    @empty
                    @endforelse
                </div>
                @forelse($brands as $k => $brand)
                <div class="group-brand mb-3" id="#brand_{{ $k }}">
                    <div class="group-title fw-bold text-uppercase">{{ $k }}</div>
                    <div class="group-item">
                        @forelse($brand as $k => $item)
                            <a href="" class="brand-template">
                                <img src="{{ $item->image?$item->image:'' }}" alt="{{ $item->name }}" class="img-fluid">
                                <div class="title">{{ $item->name }}</div>
                            </a>
                        @empty
                        @endforelse
                    </div>
                </div>
                @empty
                @endforelse
            </div>
        </div>

    </main>
@endsection

@section('link')
    @parent
    <link rel="stylesheet" href="{{ asset('/css/web/brand-list.css') }}">
@endsection

@section('script')
    @parent
@endsection
