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
                    <input type="text" class="form-control" placeholder="Nhập mã đơn hàng" name="order" id="order">
                    <button class="btn  d-flex justify-content-center align-items-center" type="submit"><img
                            src="{{ asset('images/search-nhanh-icon.svg') }}" alt="" width="29" height="29"
                            class="img-fluid">Tra cứu</button>
                </div>
            </form>
            @if (!empty($data))
                <div class="TableOrder-Nhanh p-4 description-main-view">
                    <h3 class="m-0"><p class="d-flex align-items-center gap-2"> <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M11 17H13V11H11V17ZM12 9C12.2833 9 12.5208 8.90417 12.7125 8.7125C12.9042 8.52083 13 8.28333 13 8C13 7.71667 12.9042 7.47917 12.7125 7.2875C12.5208 7.09583 12.2833 7 12 7C11.7167 7 11.4792 7.09583 11.2875 7.2875C11.0958 7.47917 11 7.71667 11 8C11 8.28333 11.0958 8.52083 11.2875 8.7125C11.4792 8.90417 11.7167 9 12 9ZM12 22C10.6167 22 9.31667 21.7375 8.1 21.2125C6.88333 20.6875 5.825 19.975 4.925 19.075C4.025 18.175 3.3125 17.1167 2.7875 15.9C2.2625 14.6833 2 13.3833 2 12C2 10.6167 2.2625 9.31667 2.7875 8.1C3.3125 6.88333 4.025 5.825 4.925 4.925C5.825 4.025 6.88333 3.3125 8.1 2.7875C9.31667 2.2625 10.6167 2 12 2C13.3833 2 14.6833 2.2625 15.9 2.7875C17.1167 3.3125 18.175 4.025 19.075 4.925C19.975 5.825 20.6875 6.88333 21.2125 8.1C21.7375 9.31667 22 10.6167 22 12C22 13.3833 21.7375 14.6833 21.2125 15.9C20.6875 17.1167 19.975 18.175 19.075 19.075C18.175 19.975 17.1167 20.6875 15.9 21.2125C14.6833 21.7375 13.3833 22 12 22ZM12 20C14.2333 20 16.125 19.225 17.675 17.675C19.225 16.125 20 14.2333 20 12C20 9.76667 19.225 7.875 17.675 6.325C16.125 4.775 14.2333 4 12 4C9.76667 4 7.875 4.775 6.325 6.325C4.775 7.875 4 9.76667 4 12C4 14.2333 4.775 16.125 6.325 17.675C7.875 19.225 9.76667 20 12 20Z"
                                    fill="#C73030" />
                            </svg>Thông tin đơn hàng</p>
                    </h3>
                    <div class="arow-h3 mb-3"></div>
                    @forelse($data as $k => $item)
                        <div class=" d-flex gap-3 align-items-center mb-3">
                            <div class="order-left">
                                <p>Mã đơn hàng</p>
                                <p>Ngày đặt hàng : </p>
                                <p>Tên khách hàng:</p>
                                <p>Số điện thoại:</p>
                                <p>Giá trị đơn hàng:</p>
                                <p class="">Trạng thái hiện tại:</p>
                            </div>
                            <div class="order-right">
                                <p class="fw-bold">#{{ $item['id'] }}</p>
                                <p class="fw-bold"> {{ $item['createdDateTime'] }} </p>
                                <p class="fw-bold"> {{ $item['customerName'] }}</p>
                                <p class="fw-bold">{{ $item['customerMobile'] }}</p>
                                <p class="fw-bold cl-order">{{ number_format($item['calcTotalMoney'], 0, ',', '.') }} đ</p>
                                <p class="status-order m-0">{{ $item['statusName'] }}</p>
                            </div>
                        </div>
                         <div class="arow-h3 my-3"></div>
                        @if ($loop->iteration >= 1)
                            <div class=" py-3"></div>
                        @endif
                    @empty
                    @endforelse

                </div>
                <div class="modal-footer justify-content-center align-items-center flex-nowrap mb-4">
                    <button class="btn-more-less-view d-flex align-items-center gap-2 justify-content-center">
                        <span>Xem thêm</span>
                        <span>Thu gọn</span>
                        <i class="fa-solid fa-angle-down"></i>
                    </button>
                </div>
            @endif
        </div>
    </main>
@endsection

@section('link')
    @parent
    <link rel="stylesheet" href="{{ mix('css/web/cart-detail-success.css') }}">
@endsection

@section('script')
    @parent
    <script src="{{ mix('js/app.js') }}"></script>
    @include('web.components.extend')
    <script>
        $(".btn-more-less-view").click(function() {
            $(this).toggleClass("less");
            $(".description-main-view").toggleClass("less");
        });
    </script>
@endsection
