@extends('web.layouts.web')

@section('content')
<main>

    <div class="container">
        <div class="layout-page-hot-deal mt-4 mb-4">
            <div class="layout-nav bg-white d-flex align-items-center mb-3">
                <a href="{{ route('dealHotProducts') }}" class="fw-bold text-uppercase fs-6 text-danger">Hot Deals</a>
                <a href="{{ route('flashSaleProducts') }}" class="fw-bold text-uppercase fs-6">Flash Deal</a>
                <a href="{{ route('dealNowProducts') }}" class="fw-bold text-uppercase fs-6">Đang diễn ra</a>
            </div>

            <div class="layout-main d-grid">
                @forelse($promotions as $item)
                <a href="{{ $item->link ?? route('dealHotDetailProducts',['id' => $item->id]) }}" target="_blank" title="{{ $item->name }}">
                    <img src="{{ $item->thumbnail_url }}" alt="{{ $item->name }}" class="img-fluid mb-2">
                    <div class="fw-bold fs-5">{{ $item->name }}</div>
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
<link rel="stylesheet" href="{{ mix('css/web/hot-deal.css') }}">
@endsection

@section('script')
@parent
<script src="{{ mix('js/app.js') }}"></script>
@include('web.components.extend')
@endsection