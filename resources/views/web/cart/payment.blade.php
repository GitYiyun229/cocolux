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
                                    <a href="" class="login-facebook fw-bold d-flex align-items-center justify-content-center">
                                        <i class="fa-brands fa-facebook-f"></i>
                                        Facebook
                                    </a>
                                    <a href="" class="login-google fw-bold d-flex align-items-center justify-content-center">
                                        <i class="fa-brands fa-google"></i>
                                        Google
                                    </a>
                                </div>
                            </div>

                            <div class="form-box">
                                <label for="name">Họ và tên <span>*</span></label>
                                <input type="text" class="form-control" value="{{ old('name') }}" placeholder="" name="name" id="name" required>
                            </div>

                            <div class="form-box">
                                <label for="tel">Số điện thoại nhận hàng <span>*</span></label>
                                <input type="text" class="form-control" value="{{ old('tel') }}" placeholder="" name="tel" id="tel" required>
                            </div>

                            <div class="form-box">
                                <label for="city">Tỉnh thành <span>*</span></label>
                                <select name="city" id="city" class="selec2-box form-control" onchange="loaddistrict(this.value)" required>
                                    <option value="0" selected hidden disabled>Chọn Tỉnh/ Thành phố</option>
                                    @forelse($list_city as $item)
                                    <option value="{{ $item->code }}">{{ $item->name }}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>

                            <div class="form-box">
                                <label for="district">Quận huyện <span>*</span></label>
                                <select name="district" id="district" class="selec2-box form-control" onchange="loadward(this.value)" required>
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
                                <input type="text" class="form-control" value="{{ old('address') }}" placeholder="" name="address" id="address" required>
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
                                <input class="form-check-input" type="radio" value="0" name="payment" id="payment0" checked>
                                <label class="form-check-label" for="payment0">
                                    Thanh toán khi nhận hàng (COD)
                                </label>
                            </div>

                            <div class="form-check mb-5">
                                <input class="form-check-input" type="radio" value="2" name="payment" id="payment2">
                                <label class="form-check-label d-flex align-items-center" for="payment2">
                                    Thanh toán qua cổng Bảo Kim <img src="{{ asset('images/icon-baokim.webp') }}" width="70px" class="img-fluid ms-2" alt="">
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" value="1" name="payment" id="payment1">
                                <label class="form-check-label" for="payment1">
                                    Chuyển khoản: Tên tài khoản: Phạm Tiến Lợi - Vietcombank : 103878062018 TP Hà Nội - Hội sở
                                </label>
                            </div>
                            <img src="{{ asset('images/payment-coco.jpg') }}" alt="payment" class="img-fluid" width="300">
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
                                    <a class="item-product" href="{{ (!empty($item['product']->slug) && !empty($item['product']->sku))?route('detailProduct', ['slug' => $item['product']->slug,'sku'=> $item['product']->sku ]):'' }}">
                                        <img src="{{ $item['image'][0] }}" alt="{{ $item['product']->title }}" class="img-fluid">
                                        <div class="item-info">
                                            <p class="item-brand mb-0 fw-bold text-uppercase">{{ $item['product']->brand }}</p>
                                            <p class="item-title mb-0">{{ $item['product']->title }}</p>
                                            <p class="item-quantity mb-0">SL: <span class="fw-bold">{{ $item['quantity'] }}</span></p>
                                        </div>
                                        <div class="item-price fw-bold">
                                            <div class="public-price">{{ format_money($item['price']) }}</div>
                                            <div class="origin-price">{{ format_money($item['product']->normal_price) }}</div>
                                        </div>
                                        <input type="hidden" class="promotion" value="{{ $item['promotion']?$item['product']->id:null }}" name="promotion[]" >
                                        <input type="hidden" class="product_item" value="{{ $item['product']->id }}" name="product_item[]" >
                                    </a>
                                    @empty
                                    @endforelse
                                </div>

                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <span>Tạm tính:</span>
                                    <span>{{ format_money($total_price) }}</span>
                                    <input type="hidden" value="{{ $total_price }}" name="total_price" id="total_price">
                                    <input type="hidden" value="{{ $total_price_not_in_promotion }}" name="total_price_not_in_promotion" id="total_price_not_in_promotion">
                                    <input type="hidden" value="{{ $total_price_in_promotion }}" name="total_price_in_promotion" id="total_price_in_promotion">
                                </div>

                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <span>Phí vận chuyển:</span>
                                    <span id="price_ship">0 đ</span>
                                    <input type="hidden" value="0" name="price_ship_coco" id="price_ship_coco">
                                </div>

                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <span>Mã giảm giá:</span>
                                    <input type="text" value="" name="coupon" id="coupon">
                                    <button type="button" id="check_coupon" onclick="checkCoupon()" class="btn btn-warning">Check</button>
                                </div>

                                <hr>
                                <div class="align-items-center justify-content-between mb-3" id="coupon_if_have" style="display: none">
                                    <span>Mã giảm giá đang áp dụng:</span>
                                    <span id="coupon_now">0 đ</span>
                                    <input type="hidden" value="0" name="price_coupon_now" id="price_coupon_now">
                                </div>

                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <span class="text-uppercase">Tổng cộng</span>
                                    <span class="fw-bold text-danger" id="total_price_ship">{{ format_money($total_price) }}</span>
                                </div>

                                <div class="detail-reward mb-3 text-center d-none">
                                    <div>Bạn sẽ nhận được</div>
                                    <div class="fw-bold text-uppercase text-danger">5892 coco coin</div>
                                </div>

                                <button type="submit" title="Đặt hàng" class="btn submit-layoutForm d-flex align-items-center justify-content-center text-white text-uppercase">
                                    Đặt hàng
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

    </main>
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

            if (!isRegex('name', regexName, 'Tên chỉ chứa các kí tự Alphabet')){
                return false;
            }

            if (!isValue('tel', 'Quý khách chưa nhập số điện thoại')) {
                return false;
            }

            if (!isRegex('tel', regexTel, 'Số điện thoại gồm 10 số, bắt đầu từ số 0')){
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

        function isValue(id, message){
            let element = document.getElementById(id);

            if (element.value.trim() == '') {
                flashMessage(message);
                element.focus();
                return false;
            }

            return true;
        }

        function isSelectValue(id, message){
            let element = document.getElementById(id);

            if (element.value == 0) {
                flashMessage(message);
                element.focus();
                return false;
            }

            return true;
        }

        function isRegex(id, regex, message){
            let element = document.getElementById(id);

            if(regex.test(element.value) === false) {
                flashMessage(message);
                element.focus();
                return false;
            }

            return true;
        }

        function flashMessage(message){
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
                success: function (data) {
                    let option = ''
                    option += `<option data-id="0" value="0">Chọn Quận/Huyện</option>`;
                    data.district.forEach(item => {
                        option += `<option value="${item.code}">${item.name}</option>`
                    });

                    $("#district").html(option);
                    $("#price_ship").html(formatMoney(data.price_ship));
                    $("#price_ship_coco").val(data.price_ship);
                    var price_coupon = $("#price_coupon_now").val();
                    let total_price_ship = (data.price_ship + parseInt($("#layoutForm #total_price").val())) - parseInt(price_coupon);
                    $("#layoutForm #total_price_ship").html(formatMoney(total_price_ship));
                    return true;
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                }
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
                success: function (data) {
                    let option = ''
                    option += `<option data-id="0" value="0">Chọn Phường/ Xã</option>`;
                    data.ward.forEach(item => {
                        option += `<option value="${item.code}">${item.name}</option>`
                    });

                    $("#ward").html(option);
                    $("#price_ship").html(formatMoney(data.price_ship));
                    $("#price_ship_coco").val(data.price_ship);
                    var price_coupon = $("#price_coupon_now").val();
                    let total_price_ship = (data.price_ship + parseInt($("#layoutForm #total_price").val())) - parseInt(price_coupon);
                    $("#layoutForm #total_price_ship").html(formatMoney(total_price_ship));
                    return true;
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                }
            });
            return false;
        }

        function formatMoney(price, current = 'đ', text = '0 đ') {
            if (!price) {
                return text;
            }
            return price.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
        }

        function checkCoupon() {
            var coupon = $('#coupon').val();
            if(!coupon){
                alert('Chưa nhập mã');
            }
            var not_in_promotion = $("input[name='promotion[]']:not([value=''])")
                .map(function(){return $(this).val();}).get();

            var product_item = $("input[name='product_item[]']")
                .map(function(){return $(this).val();}).get();

            $.ajax({
                type: 'post',
                url: '{{ route('checkCoupon') }}',
                dataType: 'JSON',
                data: {
                    coupon: $('#coupon').val(),
                    _token: "{{ csrf_token() }}",
                },
                success: function (result) {
                    if(result.error){
                        alert(result.message);
                        $("#layoutForm #coupon_now").html("-"+formatMoney(0));
                        $("#price_coupon_now").val(0);
                        var price_ship = $("#price_ship_coco").val();
                        let total_price_ship_coupon = (parseInt(price_ship) + parseInt($("#layoutForm #total_price").val())) - 0;
                        $("#layoutForm #total_price_ship").html(formatMoney(total_price_ship_coupon));
                    }else{
                        let list_products_promotion = result.list_products_promotion;
                        var price_ship = $("#price_ship_coco").val();
                        let price_total_sale = parseInt($("#layoutForm #total_price_in_promotion").val()); // tong gia san pham sale
                        let price_total_not_sale = parseInt($("#layoutForm #total_price_not_in_promotion").val()); // tong gia san pham ko sale
                        if(price_total_not_sale){
                            if (list_products_promotion){
                                let list_product_pro = list_products_promotion.split(",");
                                if(parseInt(result.data.valueType) == 1){
                                    $("#layoutForm #coupon_if_have").css({"display": "flex"});
                                    $("#layoutForm #coupon_now").html("-"+formatMoney(parseInt(result.data.value)));
                                    $("#price_coupon_now").val(result.data.value);
                                    let total_price = price_total_sale + price_total_not_sale;
                                    let total_price_ship_coupon = (parseInt(price_ship) + total_price) - parseInt(result.data.value);
                                    $("#layoutForm #total_price_ship").html(formatMoney(total_price_ship_coupon));
                                }else{
                                    $("#layoutForm #coupon_if_have").css({"display": "flex"});
                                    $("#layoutForm #coupon_now").html("-"+parseInt(result.data.value)+"%");
                                    let total_price = price_total_sale + price_total_not_sale;
                                    let coupon_ = parseInt(result.data.value);
                                    let price_coupon = price_total_not_sale * coupon_/100;
                                    $("#price_coupon_now").val(price_coupon);
                                    let total_price_ship_coupon = (parseInt(price_ship) + total_price) - price_coupon;
                                    $("#layoutForm #total_price_ship").html(formatMoney(total_price_ship_coupon));
                                }
                            }else{
                                if(parseInt(result.data.valueType) == 1){
                                    $("#layoutForm #coupon_if_have").css({"display": "flex"});
                                    $("#layoutForm #coupon_now").html("-"+formatMoney(parseInt(result.data.value)));
                                    $("#price_coupon_now").val(result.data.value);
                                    let total_price = price_total_sale + price_total_not_sale;
                                    let total_price_ship_coupon = (parseInt(price_ship) + total_price) - parseInt(result.data.value);
                                    $("#layoutForm #total_price_ship").html(formatMoney(total_price_ship_coupon));
                                }else{
                                    $("#layoutForm #coupon_if_have").css({"display": "flex"});
                                    $("#layoutForm #coupon_now").html("-"+parseInt(result.data.value)+"%");
                                    let total_price = price_total_sale + price_total_not_sale;
                                    let coupon_ = parseInt(result.data.value);
                                    let price_coupon = price_total_not_sale * coupon_/100;
                                    $("#price_coupon_now").val(price_coupon);
                                    let total_price_ship_coupon = (parseInt(price_ship) + total_price) - price_coupon;
                                    $("#layoutForm #total_price_ship").html(formatMoney(total_price_ship_coupon));
                                }
                            }
                        }else{
                            alert('Voucher không áp dụng cho sản phẩm đang khuyến mại');
                        }
                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                }
            });
            return false;
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
    </script>
@endsection
