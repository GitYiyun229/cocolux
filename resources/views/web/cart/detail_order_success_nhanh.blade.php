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
            @if (!empty($data))
                <div class="TableOrder-Nhanh p-4 description-main-view">
                    <h3 class="m-0">
                        <p class="d-flex align-items-center gap-2">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M7 9V7H21V9H7ZM7 13V11H21V13H7ZM7 17V15H21V17H7ZM4 9C3.71667 9 3.47917 8.90417 3.2875 8.7125C3.09583 8.52083 3 8.28333 3 8C3 7.71667 3.09583 7.47917 3.2875 7.2875C3.47917 7.09583 3.71667 7 4 7C4.28333 7 4.52083 7.09583 4.7125 7.2875C4.90417 7.47917 5 7.71667 5 8C5 8.28333 4.90417 8.52083 4.7125 8.7125C4.52083 8.90417 4.28333 9 4 9ZM4 13C3.71667 13 3.47917 12.9042 3.2875 12.7125C3.09583 12.5208 3 12.2833 3 12C3 11.7167 3.09583 11.4792 3.2875 11.2875C3.47917 11.0958 3.71667 11 4 11C4.28333 11 4.52083 11.0958 4.7125 11.2875C4.90417 11.4792 5 11.7167 5 12C5 12.2833 4.90417 12.5208 4.7125 12.7125C4.52083 12.9042 4.28333 13 4 13ZM4 17C3.71667 17 3.47917 16.9042 3.2875 16.7125C3.09583 16.5208 3 16.2833 3 16C3 15.7167 3.09583 15.4792 3.2875 15.2875C3.47917 15.0958 3.71667 15 4 15C4.28333 15 4.52083 15.0958 4.7125 15.2875C4.90417 15.4792 5 15.7167 5 16C5 16.2833 4.90417 16.5208 4.7125 16.7125C4.52083 16.9042 4.28333 17 4 17Z"
                                    fill="#C73030" />
                            </svg>

                            Danh sách đơn hàng
                        </p>
                    </h3>
                    <div class="arow-h3 mb-3"></div>

                    <div class="d-flex justify-content-end gap-4">
                        <p>Tên khách hàng : </p>
                        <p> Số điện thoại :</p>
                    </div>
                    <div class="d-flex align-items-center mb-3">

                        <table class='ccs-table account-table order-detail-table table'>

                            <thead>
                                <tr>
                                    <th>Đơn hàng</th>
                                    <th>Tổng tiền</th>
                                    <th>Thời gian đặt hàng</th>
                                    <th>Trạng thái đơn hàng</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($data as $k => $item)
                                    <tr key={{ $k }}>
                                        <td class="py-3">
                                            <p class="m-0">#{{ $item['id'] }}</p>
                                        </td>

                                        <td class="py-3">
                                            <p class="m-0 cl-order">
                                                {{ number_format($item['calcTotalMoney'], 0, ',', '.') }}đ
                                            </p>
                                        </td>

                                        <td class="py-3">
                                            <p class="m-0"> {{ $item['createdDateTime'] }} </p>
                                        </td>

                                        <td class="py-3">
                                            <p class="status-order m-0">{{ $item['statusName'] }}</p>
                                        </td>

                                        <td class="py-3">
                                            <button type="button" class="btn btn-call-modal p-0 btn-value-order mt-2"
                                                data-value-order-nhanh="{{ json_encode($item) }}" data-bs-toggle="modal"
                                                data-bs-target="#info-order-detail">Chi tiết</button>
                                        </td>
                                    </tr>
                                    @if ($loop->iteration >= 1)
                                        <div class=" py-3"></div>
                                    @endif
                                @empty
                                @endforelse
                            </tbody>
                        </table>
                    </div>

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
    <!-- Modal -->
    <div class="modal fade" id="info-order-detail" tabindex="-1" aria-labelledby="couponModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center gap-2" id="couponModalLabel"> <svg width="24"
                            height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M7 9V7H21V9H7ZM7 13V11H21V13H7ZM7 17V15H21V17H7ZM4 9C3.71667 9 3.47917 8.90417 3.2875 8.7125C3.09583 8.52083 3 8.28333 3 8C3 7.71667 3.09583 7.47917 3.2875 7.2875C3.47917 7.09583 3.71667 7 4 7C4.28333 7 4.52083 7.09583 4.7125 7.2875C4.90417 7.47917 5 7.71667 5 8C5 8.28333 4.90417 8.52083 4.7125 8.7125C4.52083 8.90417 4.28333 9 4 9ZM4 13C3.71667 13 3.47917 12.9042 3.2875 12.7125C3.09583 12.5208 3 12.2833 3 12C3 11.7167 3.09583 11.4792 3.2875 11.2875C3.47917 11.0958 3.71667 11 4 11C4.28333 11 4.52083 11.0958 4.7125 11.2875C4.90417 11.4792 5 11.7167 5 12C5 12.2833 4.90417 12.5208 4.7125 12.7125C4.52083 12.9042 4.28333 13 4 13ZM4 17C3.71667 17 3.47917 16.9042 3.2875 16.7125C3.09583 16.5208 3 16.2833 3 16C3 15.7167 3.09583 15.4792 3.2875 15.2875C3.47917 15.0958 3.71667 15 4 15C4.28333 15 4.52083 15.0958 4.7125 15.2875C4.90417 15.4792 5 15.7167 5 16C5 16.2833 4.90417 16.5208 4.7125 16.7125C4.52083 16.9042 4.28333 17 4 17Z"
                                fill="#C73030" />
                        </svg>Chi tiết Đơn hàng</h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class=" d-flex gap-3 align-items-center mb-3">
                        <div class="order-left">
                            <p class="mb-1">Mã đơn hàng</p>
                            <p class="mb-1">Ngày đặt hàng : </p>
                            <p class="mb-1">Tên khách hàng:</p>
                            <p class="mb-1">Số điện thoại:</p>
                            <p class="mt-2">Trạng thái hiện tại:</p>
                        </div>
                        <div class="order-right">
                            <p class="fw-bold mb-1" id="Id_nhanh"></p>
                            <p class="fw-bold mb-1" id="CreatedDateTime"></p>
                            <p class="fw-bold mb-1" id="Name_MemberOrder"></p>
                            <p class="fw-bold mb-1" id="Phone_MemberPhone"></p>
                            <p class="status-order mb-0" id="Status_Name"></p>
                        </div>
                    </div>
                    <div>
                        <table class="ccs-table account-table order-detail-table table">
                            <thead>
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th>Đơn giá</th>
                                    <th>Số lượng</th>
                                    <th>Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody id="products-list-order">

                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-between">
                        <p>Tạm tính</p>
                        <p id="price_tamtinh"></p>

                    </div>
                    <div class="d-flex justify-content-between">
                        <p>Mã giảm giá/Thẻ quà tặng</p>
                        <p id="id_voucher">3453453</p>

                    </div>
                    <div class="d-flex justify-content-between">
                        <p>Phí giao hàng</p>
                        <p id="id_price_vanchuyen"></p>

                    </div>

                    <div class="border-top my-3"></div>
                    <div class="d-flex justify-content-between">
                        <p>Tổng giá trị đơn hàng</p>
                        <p id="id_price_total"></p>

                    </div>
                </div>
            </div>
        </div>
    </div>
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
