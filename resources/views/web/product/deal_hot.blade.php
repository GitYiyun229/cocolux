@extends('web.layouts.web')

@section('content')
    <main>

        <div class="container">
            <div class="layout-page-hot-deal mt-4 mb-4">
                <div class="layout-nav bg-white d-flex align-items-center mb-3">
                    <a href="" class="fw-bold text-uppercase fs-6 text-danger">Hot Deals</a>
                    <a href="" class="fw-bold text-uppercase fs-6">Flash Deal</a>
                    <a href="" class="fw-bold text-uppercase fs-6">Đang diễn ra</a>
                </div>

                <div class="layout-main d-grid">
                    <a href="" title="Cetaphil giảm 5%">
                        <img src="./img-example/1692691676494-curel-khuyen-mai-500x500.png" alt="Cetaphil giảm 5%" class="img-fluid mb-2">
                        <div class="fw-bold fs-5">Cetaphil giảm 5%</div>
                    </a>
                    <a href="" title="Cetaphil giảm 5%">
                        <img src="./img-example/1692691676494-curel-khuyen-mai-500x500.png" alt="Cetaphil giảm 5%" class="img-fluid mb-2">
                        <div class="fw-bold fs-5">Cetaphil giảm 5%</div>
                    </a>
                    <a href="" title="Cetaphil giảm 5%">
                        <img src="./img-example/1692691676494-curel-khuyen-mai-500x500.png" alt="Cetaphil giảm 5%" class="img-fluid mb-2">
                        <div class="fw-bold fs-5">Cetaphil giảm 5%</div>
                    </a>
                    <a href="" title="Cetaphil giảm 5%">
                        <img src="./img-example/1692691676494-curel-khuyen-mai-500x500.png" alt="Cetaphil giảm 5%" class="img-fluid mb-2">
                        <div class="fw-bold fs-5">Cetaphil giảm 5%</div>
                    </a>
                </div>
            </div>
        </div>

    </main>
@endsection

@section('link')
    @parent
    <link rel="stylesheet" href="{{ asset('/css/web/hot-deal.css') }}">
@endsection

@section('script')
    @parent
@endsection
