<footer>
    <div class="container">
        <div class="footer-top">
            <div class="footer-col">
                <a href="" title="cocolux m-0">
                    <img src="{{ $setting['logo_footer'] }}" alt="cocolux" class="img-fluid">
                </a>
                {!! $setting['content_under_logo_footer'] !!}
            </div>
            @if(!empty($menus_footer))
                @forelse($menus_footer as $item)
                    <div class="footer-col">
                        <p class="title">{{ $item->name }}</p>
                        @if(count($item->children) > 0)
                            @forelse($item->children as $child)
                                <a href="{{ $child->link }}" class="mt-2">{{ $child->name }}</a>
                            @empty
                            @endforelse
                        @endif
                    </div>
                @empty
                @endforelse
            @endif
            <div class="footer-col">
                <div class="dmca-cocolux mt-3">
                    <a href="https://www.dmca.com/Protection/Status.aspx?ID=4f30b842-a954-4ab6-8ce0-d5476814e254&amp;refurl=https://cocolux.com/thong-tin/gioi-thieu" title="DMCA.com Protection Status" class="dmca-badge">
                        <img src="https://images.dmca.com/Badges/dmca_protected_sml_120n.png?ID=4f30b842-a954-4ab6-8ce0-d5476814e254" alt="DMCA.com Protection Status">
                    </a>
                    <script src="https://images.dmca.com/Badges/DMCABadgeHelper.min.js" type="text/javascript"> </script>
                </div>
            </div>
            <div class="footer-col">
                <div class="fb-thumb">
                    <iframe frameborder="0" width="380" height="130" src="https://www.facebook.com/v9.0/plugins/page.php?adapt_container_width=true&amp;app_id=113869198637480&amp;channel=https%3A%2F%2Fstaticxx.facebook.com%2Fx%2Fconnect%2Fxd_arbiter%2F%3Fversion%3D46%23cb%3Df310a21b6f5a654%26domain%3Ddevelopers.facebook.com%26origin%3Dhttps%253A%252F%252Fdevelopers.facebook.com%252Ff3cf179cd85d47c%26relation%3Dparent.parent&amp;container_width=380&amp;height=130&amp;hide_cover=false&amp;href=https%3A%2F%2Fwww.facebook.com%2F/cocoluxofficial/&amp;locale=en_US&amp;sdk=joey&amp;show_facepile=false&amp;small_header=false&amp;tabs=none&amp;width=500"></iframe>
                </div>
                <div class="license-page">
                    <div class="link-app d-none">
                        <img src="{{ $setting['qr_code_appstore'] }}" alt="cocolux" class="img-fluid img-qr">
                        <div class="app-box">
                            <a href="{{ $setting['link_app_ios'] }}" target="_blank">
                                <img src="{{ asset('images/ic-appstore.svg') }}" alt="cocolux" class="img-fluid img-app">
                                <span> App Store</span>
                            </a>
                            <a href="{{ $setting['link_app_android'] }}" target="_blank">
                                <img src="{{ asset('images/ic-googleplay.svg') }}" alt="cocolux" class="img-fluid img-app">
                                <span> Google Play</span>
                            </a>
                        </div>
                    </div>
                    <div class="license-image">
                        <img src="{{ asset('images/BCT-noi-khong-voi-hang-gia.png') }}" alt="BCT nói không với hàng giả" class="img-fluid">
                        <a href="http://online.gov.vn/Home/WebDetails/80058" target="_blank"><img src="{{ asset('images/bo-cong-thuong-xanh.svg') }}" alt="Bộ công thương xanh" class="img-fluid"></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="footer-col">
                {!! $setting['footer_bottom_col_1'] !!}
            </div>
            <div class="footer-col">
                {!! $setting['footer_bottom_col_2'] !!}
            </div>
            <div class="footer-col">
                <p class="title-2">KẾT NỐI</p>
                <div class="link-icon">
                    <a href="{{ $setting['link_facebook'] }}" target="blank"><img src="{{ asset('images/ic-facebook.svg') }}" alt="cocolux" class="img-fluid"></a>
                    <a href="{{ $setting['link_instagram'] }}" target="blank"><img src="{{ asset('images/ic-insta.svg') }}" alt="cocolux" class="img-fluid"></a>
                    <a href="{{ $setting['link_youtube'] }}" target="blank"><img src="{{ asset('images/ic-youtube.svg') }}" alt="cocolux" class="img-fluid"></a>
                    <a href="{{ $setting['link_tiktok'] }}" class="ic-invert" target="blank"><img src="{{ asset('images/ic-tiktok.svg') }}" alt="cocolux" class="img-fluid filter-white"></a>
                    <a class="ic-invert ic-zalo" href="{{ $setting['link_zalo'] }}" target="blank"><img src="{{ asset('images/ic-zalo.svg') }}" alt="cocolux" class="img-fluid filter-white"></a>
                </div>
                <p class="title">PHƯƠNG THỨC THANH TOÁN</p>
                <div class="link-icon">
                    <img src="{{ asset('images/ic-cash.svg') }}" alt="cocolux" class="img-fluid">
                    <img src="{{ asset('images/ic-internet-banking.svg') }}" alt="cocolux" class="img-fluid">
                    <img src="{{ asset('images/ic-visa.svg') }}" alt="cocolux" class="img-fluid">
                    <img src="{{ asset('images/ic-mastercard.svg') }}" alt="cocolux" class="img-fluid">
                </div>
            </div>
            <div class="footer-col">
                <p class="title">ĐĂNG KÝ NHẬN BẢN TIN</p>
                <p>Đừng bỏ lỡ hàng ngàn sản phẩm và chương trình siêu hấp dẫn</p>
                <form action="{{ route('registerEmail') }}" method="post" name="form-footer" id="form-footer">
                    @csrf
                    <input type="text" placeholder="Vui lòng nhập email của bạn" name="footer_register" id="" autocomplete="off" class="form-control">
                    <button type="submit" class="btn btn-dark">ĐĂNG KÝ</button>
                </form>
            </div>
        </div>
    </div>
</footer>
