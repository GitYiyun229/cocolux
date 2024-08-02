@extends('web.layouts.web')

@section('content')
    <main>

        <div class="container">
            <form action="{{ route('order') }}" method="post" id="layoutForm" name="layoutForm">
                @csrf
                <div class="layout-page-payment mt-4 mb-5">
                    <div class="layout-form">
                        <div class="layout-title bg-white">
                            <span class="fw-bold">Thông tin nhận hàng</span>
                            <a href="" class="d-none">Đăng nhập để nhận hàng</a>
                        </div>

                        <div class="form-detail bg-white mb-4">
                            <div class="form-box d-none">
                                <label for="">Với tài khoản</label>
                                <div class="d-flex align-items-center justify-content-around">
                                    <a href=""
                                        class="login-facebook fw-bold d-flex align-items-center justify-content-center">
                                        <i class="fa-brands fa-facebook-f"></i>
                                        Facebook
                                    </a>
                                    <a href=""
                                        class="login-google fw-bold d-flex align-items-center justify-content-center">
                                        <i class="fa-brands fa-google"></i>
                                        Google
                                    </a>
                                </div>
                            </div>

                            <div class="form-box">
                                <label for="name">Họ và tên <span>*</span></label>
                                <input type="text" class="form-control" value="{{ old('name') }}" placeholder=""
                                    name="name" id="name" required>
                            </div>

                            <div class="form-box">
                                <label for="tel">Số điện thoại nhận hàng <span>*</span></label>
                                <input type="text" class="form-control" value="{{ old('tel') }}" placeholder=""
                                    name="tel" id="tel" required>
                            </div>

                            <div class="form-box">
                                <label for="city">Tỉnh thành <span>*</span></label>
                                <select name="city" id="city" class="selec2-box form-control"
                                    onchange="loaddistrict(this.value)" required>
                                    <option value="0" selected hidden disabled>Chọn Tỉnh/ Thành phố</option>
                                    @forelse($list_city as $item)
                                        <option value="{{ $item->code }}">{{ $item->name }}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>

                            <div class="form-box">
                                <label for="district">Quận huyện <span>*</span></label>
                                <select name="district" id="district" class="selec2-box form-control"
                                    onchange="loadward(this.value)" required>
                                    <option value="0" selected hidden disabled>Chọn Quận/ Huyện</option>
                                </select>
                            </div>

                            <div class="form-box">
                                <label for="ward">Phường xã <span>*</span></label>
                                <select name="ward" id="ward" class="selec2-box form-control" required>
                                    <option value="0" selected hidden disabled>Chọn Phường/ Xã</option>
                                </select>
                            </div>

                            <div class="form-box">
                                <label for="address">Địa chỉ chi tiết <span>*</span></label>
                                <input type="text" class="form-control" value="{{ old('address') }}" placeholder=""
                                    name="address" id="address" required>
                            </div>

                            <div class="form-box">
                                <label for="note">Ghi chú</label>
                                <textarea name="note" id="note" rows="4" placeholder="Nhập ghi chú nếu có" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="layout-title bg-white">
                            <span class="fw-bold">Vận chuyển & Thanh toán</span>
                        </div>
                        <div class="form-detail bg-white">
                            <p class="fw-bold mb-2">Hình thức thanh toán</p>

                            <div class="form-check mb-5">
                                <input class="form-check-input" type="radio" value="0" name="payment" id="payment0"
                                    checked>
                                <label class="form-check-label" for="payment0">
                                    Thanh toán khi nhận hàng (COD)
                                </label>
                            </div>

                            <div class="form-check mb-5">
                                <input class="form-check-input" type="radio" value="2" name="payment" id="payment2">
                                <label class="form-check-label d-flex align-items-center" for="payment2">
                                    Thanh toán qua cổng Bảo Kim <img src="{{ asset('images/icon-baokim.webp') }}"
                                        width="70px" class="img-fluid ms-2" alt="">
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" value="1" name="payment"
                                    id="payment1">
                                <label class="form-check-label" for="payment1">
                                    Chuyển khoản: Tên tài khoản: Phạm Tiến Lợi - Vietcombank : 103878062018 TP Hà Nội - Hội
                                    sở
                                </label>
                            </div>
                            <img src="{{ asset('images/payment-coco.jpg') }}" alt="payment" class="img-fluid"
                                width="300">
                        </div>
                    </div>

                    <div class="layout-detail">
                        <div class="detail-payment">
                            <div class="layout-title bg-white">
                                Danh sách sản phẩm
                            </div>
                            <div class="form-detail bg-white">
                                <div class="list-product mb-4">
                                    @forelse($cartItems as $item)
                                        <a class="item-product"
                                            href="{{ !empty($item['product']->slug) && !empty($item['product']->sku) ? route('detailProduct', ['slug' => $item['product']->slug, 'sku' => $item['product']->sku]) : '' }}">
                                            <img src="{{ $item['product']->image_first }}"
                                                alt="{{ $item['product']->title }}" class="img-fluid">
                                            <div class="item-info">
                                                <p class="item-brand mb-0 fw-bold text-uppercase">
                                                    {{ $item['product']->brand }}</p>
                                                <p class="item-title mb-0">{{ $item['product']->title }}</p>
                                                <p class="item-quantity mb-0">SL: <span
                                                        class="fw-bold">{{ $item['quantity'] }}</span></p>
                                            </div>
                                            <div class="item-price fw-bold">
                                                <div class="public-price">{{ format_money($item['price']) }}</div>
                                                <div class="origin-price">
                                                    {{ format_money($item['product']->normal_price) }}</div>
                                            </div>
                                            <input type="hidden" class="promotion"
                                                value="{{ $item['promotion'] ? $item['product']->id : null }}"
                                                name="promotion[]">
                                            <input type="hidden" class="product_item"
                                                value="{{ $item['product']->id }}" name="product_item[]">
                                        </a>
                                    @empty
                                    @endforelse
                                </div>

                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <span>Tạm tính:</span>
                                    <span>{{ format_money($total_price) }}</span>
                                    <input type="hidden" value="{{ $total_price }}" name="total_price"
                                        id="total_price">
                                    <input type="hidden" value="{{ $total_price_not_in_promotion }}"
                                        name="total_price_not_in_promotion" id="total_price_not_in_promotion">
                                    <input type="hidden" value="{{ $total_price_in_promotion }}"
                                        name="total_price_in_promotion" id="total_price_in_promotion">
                                </div>

                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <span>Phí vận chuyển:</span>
                                    <span id="price_ship">0 đ</span>
                                    <input type="hidden" value="0" name="price_ship_coco" id="price_ship_coco">
                                </div>

                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <span>Mã giảm giá:</span>
                                    <input type="text" value="" name="coupon" id="coupon">
                                    <button type="button" id="check_coupon" onclick="checkCoupon()"
                                        class="btn btn-warning">Check</button>
                                </div>

                                <hr>
                                <div class="align-items-center justify-content-between mb-3" id="coupon_if_have"
                                    style="display: none">
                                    <span>Giá trị giảm :</span>
                                    <span id="coupon_now">0 đ</span>
                                    <input type="hidden" value="0" name="price_coupon_now" id="price_coupon_now">
                                </div>

                                @if (count($list_coupon))
                                    <div class="list-coupon-view">
                                        <h2 class="text-right">
                                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M8.66072 4.03125L11.4821 6.85268L6.375 11.9598L3.55357 9.13839L8.66072 4.03125ZM6.77679 12.7723L12.2946 7.25446C12.4077 7.14137 12.4643 7.00744 12.4643 6.85268C12.4643 6.69791 12.4077 6.56399 12.2946 6.45089L9.0625 3.21875C8.95536 3.11161 8.82143 3.05803 8.66072 3.05803C8.5 3.05803 8.36607 3.11161 8.25893 3.21875L2.74107 8.7366C2.62798 8.8497 2.57143 8.98363 2.57143 9.13839C2.57143 9.29315 2.62798 9.42708 2.74107 9.54018L5.97321 12.7723C6.08036 12.8795 6.21429 12.933 6.375 12.933C6.53571 12.933 6.66964 12.8795 6.77679 12.7723ZM14.7143 7.08482L6.61607 15.192C6.39583 15.4122 6.125 15.5223 5.80357 15.5223C5.4881 15.5223 5.22024 15.4122 5 15.192L3.875 14.067C4.20833 13.7336 4.375 13.3289 4.375 12.8527C4.375 12.3765 4.20833 11.9717 3.875 11.6384C3.54167 11.3051 3.1369 11.1384 2.66071 11.1384C2.18452 11.1384 1.77976 11.3051 1.44643 11.6384L0.330357 10.5134C0.110119 10.2932 0 10.0253 0 9.70982C0 9.38839 0.110119 9.11756 0.330357 8.89732L8.42857 0.808034C8.64881 0.587796 8.91667 0.477676 9.23214 0.477676C9.55357 0.477676 9.82441 0.587796 10.0446 0.808034L11.1607 1.9241C10.8274 2.25744 10.6607 2.6622 10.6607 3.13839C10.6607 3.61458 10.8274 4.01934 11.1607 4.35268C11.494 4.68601 11.8988 4.85268 12.375 4.85268C12.8512 4.85268 13.256 4.68601 13.5893 4.35268L14.7143 5.46875C14.9345 5.68899 15.0446 5.95982 15.0446 6.28125C15.0446 6.59672 14.9345 6.86458 14.7143 7.08482Z"
                                                    fill="black" />
                                            </svg>
                                            Xem thêm mã giảm giá
                                        </h2>
                                        <div class="slide-main-coupon">
                                            <div
                                                class="slide-template-slide-coupon owl-carousel d-flex align-items-center justify-content-between gap-2 flex-row flex-wrap">
                                                @forelse($list_coupon as $item)
                                                    @if ($item->items)
                                                        <div class="item-coupon mb-2">
                                                            <div class="box-coupon box-coupon-right w-100">
                                                                @if ($item->value_type == 1)
                                                                    <button type="button"
                                                                        class="btn btn-call-modal btn-value  d-flex justify-content-center align-items-center gap-1"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#info-coupon-detail">
                                                                        <img src="{{ asset('images/ic-coupon-payment.svg') }}"
                                                                            alt="svg coupon" class="img-fluid lazy">
                                                                        <p class="sub-title-coupon">Giảm
                                                                            {{ $item->value }}đ</p>
                                                                    </button>
                                                                @else
                                                                    <button type="button"
                                                                        class="btn btn-call-modal btn-value d-flex justify-content-center align-items-center gap-1"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#info-coupon-detail">

                                                                        <img src="{{ asset('images/ic-coupon-payment.svg') }}"
                                                                            alt="svg coupon" class="img-fluid lazy">
                                                                        <p class="sub-title-coupon">Giảm
                                                                            {{ $item->value }}</p>
                                                                    </button>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endif
                                                @empty
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <span class="text-uppercase">Tổng cộng</span>
                                    <span class="fw-bold text-danger"
                                        id="total_price_ship">{{ format_money($total_price) }}</span>
                                </div>

                                <div class="detail-reward mb-3 text-center d-none">
                                    <div>Bạn sẽ nhận được</div>
                                    <div class="fw-bold text-uppercase text-danger">5892 coco coin</div>
                                </div>

                                <button type="submit" title="Đặt hàng"
                                    class="btn submit-layoutForm d-flex align-items-center justify-content-center text-white text-uppercase">
                                    Đặt hàng
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

    </main>
    <div class="modal fade" id="info-coupon-detail" tabindex="-1" aria-labelledby="couponModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="couponModalLabel">Chọn mã khuyến mại</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body list-coupon-modal description-main-view less">
                    @if (count($list_coupon))
                        @forelse($list_coupon as $item)
                            @if ($item->items)
                                <div class="item-coupon mb-3">
                                    <div class="">
                                        <div class=" d-flex align-items-center justify-content-center">
                                            <svg width="50" height="50" viewBox="0 0 50 50" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="25" cy="25" r="25" fill="#C73030" />
                                                <path
                                                    d="M15 37.5V23.75H12.5V16.25H19C18.8958 16.0625 18.8281 15.8646 18.7969 15.6562C18.7656 15.4479 18.75 15.2292 18.75 15C18.75 13.9583 19.1146 13.0729 19.8438 12.3438C20.5729 11.6146 21.4583 11.25 22.5 11.25C22.9792 11.25 23.4271 11.3385 23.8438 11.5156C24.2604 11.6927 24.6458 11.9375 25 12.25C25.3542 11.9167 25.7396 11.6667 26.1562 11.5C26.5729 11.3333 27.0208 11.25 27.5 11.25C28.5417 11.25 29.4271 11.6146 30.1562 12.3438C30.8854 13.0729 31.25 13.9583 31.25 15C31.25 15.2292 31.2292 15.4427 31.1875 15.6406C31.1458 15.8385 31.0833 16.0417 31 16.25H37.5V23.75H35V37.5H15ZM27.5 13.75C27.1458 13.75 26.849 13.8698 26.6094 14.1094C26.3698 14.349 26.25 14.6458 26.25 15C26.25 15.3542 26.3698 15.651 26.6094 15.8906C26.849 16.1302 27.1458 16.25 27.5 16.25C27.8542 16.25 28.151 16.1302 28.3906 15.8906C28.6302 15.651 28.75 15.3542 28.75 15C28.75 14.6458 28.6302 14.349 28.3906 14.1094C28.151 13.8698 27.8542 13.75 27.5 13.75ZM21.25 15C21.25 15.3542 21.3698 15.651 21.6094 15.8906C21.849 16.1302 22.1458 16.25 22.5 16.25C22.8542 16.25 23.151 16.1302 23.3906 15.8906C23.6302 15.651 23.75 15.3542 23.75 15C23.75 14.6458 23.6302 14.349 23.3906 14.1094C23.151 13.8698 22.8542 13.75 22.5 13.75C22.1458 13.75 21.849 13.8698 21.6094 14.1094C21.3698 14.349 21.25 14.6458 21.25 15ZM15 18.75V21.25H23.75V18.75H15ZM23.75 35V23.75H17.5V35H23.75ZM26.25 35H32.5V23.75H26.25V35ZM35 21.25V18.75H26.25V21.25H35Z"
                                                    fill="white" />
                                            </svg>
                                            <div class="box-coupon box-coupon-left text-center">
                                                @if ($item->value_type == 1)
                                                    <p class="sub-title-coupon">Giảm {{ $item->value }}đ</p>
                                                @else
                                                    <p class="sub-title-coupon">Giảm {{ $item->value }}</p>
                                                @endif
                                                <p class="mb-0">HSD : {{ $item->end_date }} </p>
                                            </div>
                                        </div>
                                        <div class="box-coupon box-coupon-right w-100">
                                            <div
                                                class="voucher-detail pb-2 description-main description-main{{ $item->id }} less">
                                                {{ $item->name }}


                                            </div>
                                            <div class="d-flex justify-content-between align-items-center mt-1">
                                                <div class="d-flex align-items-center justify-content-center">
                                                    <button class="btn-more-less d-flex align-items-center gap-2 fw-bold"
                                                        data-id="{{ $item->id }}">
                                                        <span>Xem thêm</span>
                                                        <span>Thu gọn</span>
                                                        <i class="fa-solid fa-angle-down"></i>
                                                    </button>
                                                </div>
                                                @if ($total_price >= $item->from_value)
                                                    <button type="button" class="btn btn-dark btn-apply"
                                                        data-coupon="{{ $item->items['code'] }}">Apply</button>
                                                @else
                                                    <button type="button" class="btn btn-white">No
                                                        Apply</button>
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @empty
                        @endforelse
                    @endif
                </div>
                <div class="modal-footer justify-content-between align-items-center flex-nowrap">
                    <button class="btn-more-less-view d-flex align-items-center gap-2 justify-content-center">
                        <span>Xem thêm</span>
                        <span>Thu gọn</span>
                        <i class="fa-solid fa-angle-down"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div id="loading-overlay">
        <div id="loading-spinner">
            <i class="fa fa-spinner fa-spin"></i> Loading...
        </div>
    </div>
@endsection

@section('link')
    @parent
    <link rel="stylesheet" href="{{ mix('css/web/cart-payment.css') }}">
@endsection

@section('script')
    @parent
    <script src="{{ mix('js/app.js') }}"></script>
    @include('web.components.extend')
    <script>
        const submitBtn = document.querySelector('.submit-layoutForm');
        const submitForm = document.querySelector('#layoutForm');
        const flashMessageBox = document.querySelector('#flash-message');
        const regexName = /^[\p{L}\s']+$/u;
        const regexTel = /^0\d{9}$/;

        submitBtn.addEventListener('click', function(e) {
            // e.preventDefault();

            if (!isValue('name', 'Quý khách chưa nhập họ tên')) {
                return false;
            }

            if (!isRegex('name', regexName, 'Tên chỉ chứa các kí tự Alphabet')) {
                return false;
            }

            if (!isValue('tel', 'Quý khách chưa nhập số điện thoại')) {
                return false;
            }

            if (!isRegex('tel', regexTel, 'Số điện thoại gồm 10 số, bắt đầu từ số 0')) {
                return false;
            }

            if (!isSelectValue('city', 'Quý khách chưa chọn Tỉnh/ Thành phố')) {
                return false;
            }

            if (!isSelectValue('district', 'Quý khách chưa chọn Quận/ Huyện phố')) {
                return false;
            }

            if (!isSelectValue('ward', 'Quý khách chưa chọn Phường/ Xã phố')) {
                return false;
            }

            if (!isValue('address', 'Quý khách chưa nhập địa chỉ')) {
                return false;
            }

            submitForm.submit()
        })

        function isValue(id, message) {
            let element = document.getElementById(id);

            if (element.value.trim() == '') {
                flashMessage(message);
                element.focus();
                return false;
            }

            return true;
        }

        function isSelectValue(id, message) {
            let element = document.getElementById(id);

            if (element.value == 0) {
                flashMessage(message);
                element.focus();
                return false;
            }

            return true;
        }

        function isRegex(id, regex, message) {
            let element = document.getElementById(id);

            if (regex.test(element.value) === false) {
                flashMessage(message);
                element.focus();
                return false;
            }

            return true;
        }

        function flashMessage(message) {
            flashMessageBox.querySelector('.toast-body').innerHTML = message;
            const toastBootstrap = bootstrap.Toast.getOrCreateInstance(flashMessageBox);
            toastBootstrap.show()
        }

        function loaddistrict(city_id) {
            $.ajax({
                type: 'post',
                url: '{{ route('loadDistrict') }}',
                dataType: 'JSON',
                data: {
                    city_id: city_id,
                    _token: "{{ csrf_token() }}",
                },
                success: function(data) {
                    let option = ''
                    option += `<option data-id="0" value="0">Chọn Quận/Huyện</option>`;
                    data.district.forEach(item => {
                        option += `<option value="${item.code}">${item.name}</option>`
                    });

                    $("#district").html(option);
                    $("#price_ship").html(formatMoney(data.price_ship));
                    $("#price_ship_coco").val(data.price_ship);
                    var price_coupon = $("#price_coupon_now").val();
                    let total_price_ship = (data.price_ship + parseInt($("#layoutForm #total_price").val())) -
                        parseInt(price_coupon);
                    $("#layoutForm #total_price_ship").html(formatMoney(total_price_ship));
                    return true;
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {}
            });
            return false;
        }

        function loadward(district_id) {
            $.ajax({
                type: 'post',
                url: '{{ route('loadWard') }}',
                dataType: 'JSON',
                data: {
                    city_id: $('#layoutForm #city').val(),
                    district_id: district_id,
                    _token: "{{ csrf_token() }}",
                },
                success: function(data) {
                    let option = ''
                    option += `<option data-id="0" value="0">Chọn Phường/ Xã</option>`;
                    data.ward.forEach(item => {
                        option += `<option value="${item.code}">${item.name}</option>`
                    });

                    $("#ward").html(option);
                    $("#price_ship").html(formatMoney(data.price_ship));
                    $("#price_ship_coco").val(data.price_ship);
                    var price_coupon = $("#price_coupon_now").val();
                    let total_price_ship = (data.price_ship + parseInt($("#layoutForm #total_price").val())) -
                        parseInt(price_coupon);
                    $("#layoutForm #total_price_ship").html(formatMoney(total_price_ship));
                    return true;
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {}
            });
            return false;
        }

        function formatMoney(price, current = 'đ', text = '0 đ') {
            if (!price) {
                return text;
            }
            return price.toLocaleString('vi-VN', {
                style: 'currency',
                currency: 'VND'
            });
        }



        function checkCoupon() {
            var coupon = $('#coupon').val();
            if (!coupon) {
                alert('Chưa nhập mã');
            }
            var not_in_promotion = $("input[name='promotion[]']:not([value=''])")
                .map(function() {
                    return $(this).val();
                }).get();

            var product_item = $("input[name='product_item[]']")
                .map(function() {
                    return $(this).val();
                }).get();

            $.ajax({
                type: 'post',
                url: '{{ route('checkCoupon') }}',
                dataType: 'JSON',
                data: {
                    coupon: $('#coupon').val(),
                    _token: "{{ csrf_token() }}",
                },
                success: function(result) {
                    if (result.error) {
                        alert(result.message);
                        $("#layoutForm #coupon_now").html("-" + formatMoney(0));
                        $("#price_coupon_now").val(0);
                        var price_ship = $("#price_ship_coco").val();
                        let total_price_ship_coupon = (parseInt(price_ship) + parseInt($(
                            "#layoutForm #total_price").val())) - 0;
                        $("#layoutForm #total_price_ship").html(formatMoney(total_price_ship_coupon));
                    } else {
                        let list_products_promotion = result.list_products_promotion;
                        var price_ship = $("#price_ship_coco").val();
                        let price_total_sale = parseInt($("#layoutForm #total_price_in_promotion")
                            .val()); // tong gia san pham sale
                        let price_total_not_sale = parseInt($("#layoutForm #total_price_not_in_promotion")
                            .val()); // tong gia san pham ko sale
                        // if (result.status === false) {
                        //     if (list_products_promotion) {
                        //         let list_product_pro = list_products_promotion.split(",");
                        //         if (parseInt(result.data.valueType) == 1) {
                        //             $("#layoutForm #coupon_if_have").css({
                        //                 "display": "flex"
                        //             });
                        //             $("#layoutForm #coupon_now").html("-" + formatMoney(parseInt(result.data
                        //                 .value)));
                        //             $("#price_coupon_now").val(result.data.value);
                        //             let total_price = price_total_sale + price_total_not_sale;
                        //             let total_price_ship_coupon = (parseInt(price_ship) + total_price) -
                        //                 parseInt(result.data.value);
                        //             $("#layoutForm #total_price_ship").html(formatMoney(
                        //                 total_price_ship_coupon));
                        //         } else {
                        //             $("#layoutForm #coupon_if_have").css({
                        //                 "display": "flex"
                        //             });
                        //             $("#layoutForm #coupon_now").html("-" + parseInt(result.data.value) +
                        //                 "%");
                        //             let total_price = price_total_sale + price_total_not_sale;
                        //             let coupon_ = parseInt(result.data.value);
                        //             let price_coupon = total_price * coupon_ / 100;
                        //             $("#price_coupon_now").val(price_coupon);
                        //             let total_price_ship_coupon = (parseInt(price_ship) + total_price) -
                        //                 price_coupon;
                        //             $("#layoutForm #total_price_ship").html(formatMoney(
                        //                 total_price_ship_coupon));
                        //         }
                        //     } else {
                        //         if (parseInt(result.data.valueType) == 1) {
                        //             $("#layoutForm #coupon_if_have").css({
                        //                 "display": "flex"
                        //             });
                        //             $("#layoutForm #coupon_now").html("-" + formatMoney(parseInt(result.data
                        //                 .value)));
                        //             $("#price_coupon_now").val(result.data.value);
                        //             let total_price = price_total_sale + price_total_not_sale;
                        //             let total_price_ship_coupon = (parseInt(price_ship) + total_price) -
                        //                 parseInt(result.data.value);
                        //             $("#layoutForm #total_price_ship").html(formatMoney(
                        //                 total_price_ship_coupon));
                        //         } else {
                        //             $("#layoutForm #coupon_if_have").css({
                        //                 "display": "flex"
                        //             });
                        //             $("#layoutForm #coupon_now").html("-" + parseInt(result.data.value) +
                        //                 "%");
                        //             let total_price = price_total_sale + price_total_not_sale;
                        //             let coupon_ = parseInt(result.data.value);
                        //             let price_coupon = total_price * coupon_ / 100;
                        //             $("#price_coupon_now").val(price_coupon);
                        //             let total_price_ship_coupon = (parseInt(price_ship) + total_price) -
                        //                 price_coupon;
                        //             $("#layoutForm #total_price_ship").html(formatMoney(
                        //                 total_price_ship_coupon));
                        //         }
                        //     }
                        // } else {
                        //     if (price_total_sale) {
                        //         alert('Voucher không áp dụng cho sản phẩm đang khuyến mãi');
                        //     } else {
                        //         if (list_products_promotion) {
                        //             let list_product_pro = list_products_promotion.split(",");
                        //             if (parseInt(result.data.valueType) == 1) {
                        //                 $("#layoutForm #coupon_if_have").css({
                        //                     "display": "flex"
                        //                 });
                        //                 $("#layoutForm #coupon_now").html("-" + formatMoney(parseInt(result.data
                        //                     .value)));
                        //                 $("#price_coupon_now").val(result.data.value);
                        //                 let total_price = price_total_sale + price_total_not_sale;
                        //                 let total_price_ship_coupon = (parseInt(price_ship) + total_price) -
                        //                     parseInt(result.data.value);
                        //                 $("#layoutForm #total_price_ship").html(formatMoney(
                        //                     total_price_ship_coupon));
                        //             } else {
                        //                 $("#layoutForm #coupon_if_have").css({
                        //                     "display": "flex"
                        //                 });
                        //                 $("#layoutForm #coupon_now").html("-" + parseInt(result.data.value) +
                        //                     "%");
                        //                 let total_price = price_total_sale + price_total_not_sale;
                        //                 let coupon_ = parseInt(result.data.value);
                        //                 let price_coupon = price_total_not_sale * coupon_ / 100;
                        //                 $("#price_coupon_now").val(price_coupon);
                        //                 let total_price_ship_coupon = (parseInt(price_ship) + total_price) -
                        //                     price_coupon;
                        //                 $("#layoutForm #total_price_ship").html(formatMoney(
                        //                     total_price_ship_coupon));
                        //             }
                        //         } else {
                        //             if (parseInt(result.data.valueType) == 1) {
                        //                 $("#layoutForm #coupon_if_have").css({
                        //                     "display": "flex"
                        //                 });
                        //                 $("#layoutForm #coupon_now").html("-" + formatMoney(parseInt(result.data
                        //                     .value)));
                        //                 $("#price_coupon_now").val(result.data.value);
                        //                 let total_price = price_total_sale + price_total_not_sale;
                        //                 let total_price_ship_coupon = (parseInt(price_ship) + total_price) -
                        //                     parseInt(result.data.value);
                        //                 $("#layoutForm #total_price_ship").html(formatMoney(
                        //                     total_price_ship_coupon));
                        //             } else {
                        //                 $("#layoutForm #coupon_if_have").css({
                        //                     "display": "flex"
                        //                 });
                        //                 $("#layoutForm #coupon_now").html("-" + parseInt(result.data.value) +
                        //                     "%");
                        //                 let total_price = price_total_sale + price_total_not_sale;
                        //                 let coupon_ = parseInt(result.data.value);
                        //                 let price_coupon = price_total_not_sale * coupon_ / 100;
                        //                 $("#price_coupon_now").val(price_coupon);
                        //                 let total_price_ship_coupon = (parseInt(price_ship) + total_price) -
                        //                     price_coupon;
                        //                 $("#layoutForm #total_price_ship").html(formatMoney(
                        //                     total_price_ship_coupon));
                        //             }
                        //         }
                        //     }
                        // }
                        if (result.status === false) {
                            if (list_products_promotion) {
                                let list_product_pro = list_products_promotion.split(",");
                                // applyCoupon(result, price_total_sale, price_total_not_sale, price_ship);
                                if (result.status_promition_price_coupon_list === true) {
                                    applyCoupon(result, price_total_sale, price_total_not_sale, price_ship);
                                } else {
                                    alert('Voucher không áp dụng cho danh sách sản phẩm này');
                                }
                            } else {
                                applyCoupon(result, price_total_sale, price_total_not_sale, price_ship);
                            }
                        } else {
                            if (price_total_sale) {
                                alert('Voucher không áp dụng cho sản phẩm đang khuyến mãi');
                            } else {
                                if (list_products_promotion) {
                                    let list_product_pro = list_products_promotion.split(",");
                                    // applyCoupon(result, price_total_sale, price_total_not_sale, price_ship);
                                    if (result.status_promition_price_coupon_list === true) {
                                        applyCoupon(result, price_total_sale, price_total_not_sale, price_ship);
                                    } else {
                                        alert('Voucher không áp dụng cho danh sách sản phẩm này');
                                    }
                                } else {
                                    applyCoupon(result, price_total_sale, price_total_not_sale, price_ship);
                                }
                            }
                        }
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {}
            });
            return false;
        }

        function applyCoupon(result, price_total_sale, price_total_not_sale, price_ship) {
            $("#layoutForm #coupon_if_have").css({
                "display": "flex"
            });
            let total_price = price_total_sale + price_total_not_sale;
            let total_price_ship_coupon;
            let coupon_value = parseInt(result.data.value);

            if (parseInt(result.data.valueType) == 1) {
                $("#layoutForm #coupon_now").html("-" + formatMoney(coupon_value));
                $("#price_coupon_now").val(coupon_value);
                // total_price_ship_coupon = (parseInt(price_ship) + total_price) - coupon_value;
                total_price_ship_coupon = Math.max(0, (parseInt(price_ship) + total_price) - coupon_value);
            } else {
                $("#layoutForm #coupon_now").html("-" + coupon_value + "%");
                let price_coupon = total_price * coupon_value / 100;
                $("#price_coupon_now").val(price_coupon);
                // total_price_ship_coupon = (parseInt(price_ship) + total_price) - price_coupon;
                total_price_ship_coupon = Math.max(0, (parseInt(price_ship) + total_price) - price_coupon);
            }

            $("#layoutForm #total_price_ship").html(formatMoney(total_price_ship_coupon));
        }
        $(document).ready(function() {
            // Hiệu ứng loading khi bắt đầu thực hiện Ajax
            $(document).ajaxStart(function() {
                $("#loading-overlay").show();
            });

            // Hiệu ứng kết thúc khi Ajax hoàn thành
            $(document).ajaxStop(function() {
                $("#loading-overlay").hide();
            });
        });
        $(".btn-more-less").click(function() {
            let lessID = parseInt($(this).attr('data-id'));
            $(this).toggleClass("less");
            $(".description-main" + lessID).toggleClass("less");
        });
        $(".btn-more-less-view").click(function() {
            $(this).toggleClass("less");
            $(".description-main-view").toggleClass("less");
        });

        $(".btn-apply").click(function() {
            let code = $(this).attr('data-coupon');
            $('#coupon').val(code);
            $("#check_coupon").trigger("click");
        });
    </script>
@endsection
