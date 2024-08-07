@extends('web.layouts.web')

@section('content')
    <main>

        <div class="container">
            <nav aria-label="breadcrumb" class="pt-3 pb-3 mb-4">
                {{ Breadcrumbs::render('homeBrand') }}
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
                <div class="group-brand mb-3" id="brand_{{ $k }}">
                    <div class="group-title fw-bold text-uppercase">{{ $k }}</div>
                    <div class="group-item">
                        @forelse($brand as $k => $item)
                            <a href="{{ route('detailBrand',['slug' => $item->slug,'id' => $item->id]) }}" class="brand-template">
                                <img src="{{ str_replace('https://cdn.cocolux.com', 'https://cocolux.com/storage/upload_image/images/cdn_images',($item->image ?$item->image:'')) }}" alt="{{ $item->name }}" class="img-fluid">
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
    <link rel="stylesheet" href="{{ mix('css/web/brand-list.css') }}">
@endsection

@section('script')
    @parent
    <script src="{{ mix('js/app.js') }}"></script>
    @include('web.components.extend')
@endsection
