@extends('web.layouts.web')

@section('content')
    <main>
        <div class="container">
            <nav aria-label="breadcrumb" class="pt-3 pb-3 mb-4">
                {{ Breadcrumbs::render('detailOrderSuccess2') }}
            </nav>

        </div>

        <div class="container order-nhanh py-4">
            <form action="{{ route('searchOrder') }}" method="POST" name="search-order" class="form-search-nhanh mb-3">
                @csrf
                <h3 class="text mb-2"> Tra cứu đơn hàng </h3>
                <div class="buttom-search d-grid">
                    <input type="text" class="form-control"
                        placeholder="Nhập số điện thoại , mã Id nhanh hoặc mã đơn hàng WEB " name="order" id="order">
                    <button class="btn  d-flex justify-content-center align-items-center" type="submit"><img
                            src="{{ asset('images/search-nhanh-icon.svg') }}" alt="" width="29" height="29"
                            class="img-fluid">Tra cứu</button>
                </div>
            </form>

        </div>
    </main>
    <!-- Modal -->

@endsection

@section('link')
    @parent
    <link rel="stylesheet" href="{{ mix('css/web/cart-detail-success.css') }}">
@endsection

@section('script')
    @parent
    <script src="{{ mix('js/app.js') }}"></script>
    @include('web.components.extend')
  
@endsection
