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
                            <a href="">Đăng nhập để nhận hàng</a>
                        </div>

                        <div class="form-detail bg-white mb-4">
                            <div class="form-box">
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
                                    <a class="item-product">
                                        <img src="{{ $item['image'][0] }}" alt="{{ $item['product']->title }}" class="img-fluid">
                                        <div class="item-info">
                                            <p class="item-brand mb-0 fw-bold text-uppercase">{{ $item['product']->brand }}</p>
                                            <p class="item-title mb-0">{{ $item['product']->title }}</p>
                                            <p class="item-quantity mb-0">SL: <span class="fw-bold">{{ $item['quantity'] }}</span></p>
                                        </div>
                                        <div class="item-price fw-bold">
                                            <div class="public-price">{{ format_money($item['product']->price) }}</div>
                                            <div class="origin-price">{{ format_money($item['product']->normal_price) }}</div>
                                        </div>
                                    </a>
                                    @empty
                                    @endforelse
                                </div>

                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <span>Tạm tính:</span>
                                    <span>{{ format_money($total_price) }}</span>
                                </div>

                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <span>Phí vận chuyển:</span>
                                    <span>0 đ</span>
                                </div>

                                <hr>

                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <span class="text-uppercase">Tổng cộng</span>
                                    <span class="fw-bold text-danger">{{ format_money($total_price) }}</span>
                                </div>

                                <div class="detail-reward mb-3 text-center">
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

@endsection

@section('link')
    @parent
    <link rel="stylesheet" href="{{ asset('/css/web/cart-payment.css') }}">
@endsection

@section('script')
    @parent
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
                    return true;
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                }
            });
            return false;
        }
    </script>
@endsection
