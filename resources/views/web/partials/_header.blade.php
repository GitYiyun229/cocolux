<div class="header-top">
    <div class="container">
        <svg fill="currentColor" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><path d="M280 0C408.1 0 512 103.9 512 232c0 13.3-10.7 24-24 24s-24-10.7-24-24c0-101.6-82.4-184-184-184c-13.3 0-24-10.7-24-24s10.7-24 24-24zm8 192a32 32 0 1 1 0 64 32 32 0 1 1 0-64zm-32-72c0-13.3 10.7-24 24-24c75.1 0 136 60.9 136 136c0 13.3-10.7 24-24 24s-24-10.7-24-24c0-48.6-39.4-88-88-88c-13.3 0-24-10.7-24-24zM117.5 1.4c19.4-5.3 39.7 4.6 47.4 23.2l40 96c6.8 16.3 2.1 35.2-11.6 46.3L144 207.3c33.3 70.4 90.3 127.4 160.7 160.7L345 318.7c11.2-13.7 30-18.4 46.3-11.6l96 40c18.6 7.7 28.5 28 23.2 47.4l-24 88C481.8 499.9 466 512 448 512C200.6 512 0 311.4 0 64C0 46 12.1 30.2 29.5 25.4l88-24z"/></svg>
        <span class="ms-2">0988888825</span>
    </div>
</div>
<div class="header-main">
    <div class="container">
        <a href="{{ route('home') }}" title="cocolux" class="header-main-logo">
            <img src="{{ $setting['logo'] }}" alt="cocolux" class="img-fluid logo-full">
        </a>
        <a href="" title="cocolux" class="header-main-logo-icon">
            <img src="{{ $setting['logo_scroll'] }}" alt="cocolux" class="img-fluid logo-icon">
        </a>
        <div class="header-menu">
            <div class="menu-item menu-site">
                <a href="">
                    <i class="fa-solid fa-bars"></i>
                    Danh mục sản phẩm
                </a>
                <div class="menu-content">
                    @forelse($cat_products as $item)
                    <div class="menu-item">
                        <a href="" class="menu-btn">{{ $item->title }} <i class="fa-solid fa-angle-right"></i></a>
{{--                        @if($item->children)--}}
                        <div class="menu-content">
                            <div class="position-relative h-100 w-100">
                                <div class="menu-group-top">
                                    <a href="">Nổi bật</a>
                                    <a href="">Bán chạy</a>
                                    <a href="">Hàng mới</a>
                                </div>
                                <div class="menu-group-bottom">
                                    <div class="menu-col-item">
                                        <a href="" class="item-parent">Trang điểm mặt</a>
                                        <a href="" class="item-child">Kem Lót</a>
                                        <a href="" class="item-child">Kem nền - BB Cream</a>
                                        <a href="" class="item-child">Che khuyết điểm</a>
                                        <a href="" class="item-child">Phấn phủ</a>
                                        <a href="" class="item-child">Phấn má</a>
                                        <a href="" class="item-child">Phấn nước - Cushion</a>
                                        <a href="" class="item-child">Tạo khối - Hightlight</a>
                                    </div>
                                    <div class="menu-col-item">
                                        <a href="" class="item-parent">Trang điểm mắt</a>
                                        <a href="" class="item-child">Phấn mắt/ Nhũ mắt</a>
                                        <a href="" class="item-child">Kẻ mắt</a>
                                        <a href="" class="item-child">Kẻ chân mày</a>
                                        <a href="" class="item-child">Mascara</a>
                                    </div>
                                </div>
                                <div class="menu-poster">
                                    <img src="{{ asset('images/poster-example.jpeg') }}" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    @endforelse
                </div>
            </div>
        </div>
        <div class="header-main-menu">
            <form action="" name="" method="get">
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle form-drop-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span>Tất cả</span>
                    </button>
                    <div class="dropdown-menu header-main-dropdown">
                        <div class="dropdown-item item-parent">Tất cả</div>
                        <section>
                            <div class="dropdown-item item-parent">Trang Điểm</div>
                            <div class="dropdown-item item-child">Trang Điểm Mặt</div>
                            <div class="dropdown-item item-child">Trang Điểm Mắt</div>
                        </section>
                        <section>
                            <div class="dropdown-item item-parent">Son môi</div>
                            <div class="dropdown-item item-child">Son Thỏi</div>
                            <div class="dropdown-item item-child">Son Kem</div>
                            <div class="dropdown-item item-child">Son Dưỡng</div>
                            <div class="dropdown-item item-child">Son Bóng</div>
                            <div class="dropdown-item item-child">Mặt Nạ Ngủ Môi</div>
                            <div class="dropdown-item item-child">Tẩy da chết môi</div>
                        </section>
                        <section>
                            <div class="dropdown-item item-parent">Chăm Sóc Cơ Thể</div>
                            <div class="dropdown-item item-child">Chăm Sóc Răng Miệng</div>
                            <div class="dropdown-item item-child">Dưỡng Thể</div>
                            <div class="dropdown-item item-child">Body Mist - Xịt Thơm</div>
                            <div class="dropdown-item item-child">Làm Sạch</div>
                            <div class="dropdown-item item-child">Kem Tay</div>
                            <div class="dropdown-item item-child">Lăn Xịt Khử Mùi</div>
                            <div class="dropdown-item item-child">Kem Trị Rạn/ Tan Mỡ</div>
                            <div class="dropdown-item item-child">Chăm Sóc Vùng Kín</div>
                        </section>
                    </div>
                </div>
                <input type="text" class="form-control" name="keyword" id="keyword" placeholder="Tìm sản phẩm bạn mong muốn...">
                <a class="form-submit">
                    <img src="{{ asset('images/search-icon.svg') }}" alt="" class="img-fluid">
                </a>
            </form>

            <a href="{{ route('showCart') }}" class="menu-btn">
                <img src="{{ asset('images/cart-icon.svg') }}" alt="">
                <span>Giỏ hàng</span>
                <span class="cart-items-total" id="number-added-cart">{{ getCart() }}</span>
            </a>

            <a href="tel:0988888825" class="menu-btn menu-call-hotline">
                <img src="{{ asset('images/hotline-icon.svg') }}" alt="hotline" class="img-fluid">
                <span>Hỗ trợ <br> Khách hàng</span>
            </a>
        </div>
    </div>
</div>
<div class="header-bottom">
    <div class="container header-bottom-menu header-menu">
        <div class="menu-item menu-site @if (request()->route()->getName() == 'home') active @endif">
            <a href="">
                <i class="fa-solid fa-bars"></i>
                Danh mục sản phẩm
            </a>
            <div class="menu-content">
                <div class="menu-item">
                    <a href="" class="menu-btn">Trang điểm <i class="fa-solid fa-angle-right"></i></a>
                    <div class="menu-content">
                        <div class="position-relative h-100 w-100">
                            <div class="menu-group-top">
                                <a href="">Nổi bật</a>
                                <a href="">Bán chạy</a>
                                <a href="">Hàng mới</a>
                            </div>
                            <div class="menu-group-bottom">
                                <div class="menu-col-item">
                                    <a href="" class="item-parent">Trang điểm mặt</a>
                                    <a href="" class="item-child">Kem Lót</a>
                                    <a href="" class="item-child">Kem nền - BB Cream</a>
                                    <a href="" class="item-child">Che khuyết điểm</a>
                                    <a href="" class="item-child">Phấn phủ</a>
                                    <a href="" class="item-child">Phấn má</a>
                                    <a href="" class="item-child">Phấn nước - Cushion</a>
                                    <a href="" class="item-child">Tạo khối - Hightlight</a>
                                </div>
                                <div class="menu-col-item">
                                    <a href="" class="item-parent">Trang điểm mắt</a>
                                    <a href="" class="item-child">Phấn mắt/ Nhũ mắt</a>
                                    <a href="" class="item-child">Kẻ mắt</a>
                                    <a href="" class="item-child">Kẻ chân mày</a>
                                    <a href="" class="item-child">Mascara</a>
                                </div>
                            </div>
                            <div class="menu-poster">
                                <img src="{{ asset('images/poster-example.jpeg') }}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="menu-item">
                    <a href="" class="menu-btn">Son môi <i class="fa-solid fa-angle-right"></i></a>
                    <div class="menu-content">
                        <div class="position-relative h-100 w-100">
                            <div class="menu-group-top">
                                <a href="">Nổi bật</a>
                                <a href="">Bán chạy</a>
                                <a href="">Hàng mới</a>
                            </div>
                            <div class="menu-group-bottom">
                                <div class="menu-col-item">
                                    <a href="" class="item-parent">Son Thỏi</a>
                                </div>
                                <div class="menu-col-item">
                                    <a href="" class="item-parent">Son Bóng</a>
                                </div>
                                <div class="menu-col-item">
                                    <a href="" class="item-parent">Son Dưỡng</a>
                                </div>
                                <div class="menu-col-item">
                                    <a href="" class="item-parent">Mặt nạ ngủ môi</a>
                                </div>
                                <div class="menu-col-item">
                                    <a href="" class="item-parent">Tẩy da chết môi</a>
                                </div>
                            </div>
                            <div class="menu-poster">
                                <img src="{{ asset('images/poster-example.jpeg') }}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="menu-item">
                    <a href="" class="menu-btn">Chăm sóc da <i class="fa-solid fa-angle-right"></i></a>
                </div>
                <div class="menu-item">
                    <a href="" class="menu-btn">Chăm sóc cơ thể <i class="fa-solid fa-angle-right"></i></a>
                </div>
                <div class="menu-item">
                    <a href="" class="menu-btn">Chăm sóc tóc <i class="fa-solid fa-angle-right"></i></a>
                </div>
                <div class="menu-item">
                    <a href="" class="menu-btn">Dụng cụ <i class="fa-solid fa-angle-right"></i></a>
                </div>
                <div class="menu-item">
                    <a href="" class="menu-btn">Nước hoa <i class="fa-solid fa-angle-right"></i></a>
                </div>
                <div class="menu-item">
                    <a href="" class="menu-btn">Mỹ phẩm Hight-End <i class="fa-solid fa-angle-right"></i></a>
                </div>
                <div class="menu-item">
                    <a href="" class="menu-btn">Mỹ phẩm chức năng <i class="fa-solid fa-angle-right"></i></a>
                </div>
                <div class="menu-item">
                    <a href="" class="menu-btn">Gift Set <i class="fa-solid fa-angle-right"></i></a>
                </div>
                <div class="menu-item">
                    <a href="" class="menu-btn">Sản phẩm khác <i class="fa-solid fa-angle-right"></i></a>
                </div>
            </div>
        </div>
        <div class="menu-item">
            <a href="{{ route('detailPage',['slug' => 'gioi-thieu']) }}">Giới thiệu</a>
        </div>
        <div class="menu-item">
            <a href="{{ route('homeBrand') }}">Thương hiệu</a>
        </div>
        <div class="menu-item">
            <a href="">Khuyến mại</a>
            <div class="menu-content">
                <div class="menu-item">
                    <a href="">Hot Deals</a>
                </div>
                <div class="menu-item">
                    <a href="">Flash Deals</a>
                </div>
                <div class="menu-item">
                    <a href="">Đang diễn ra</a>
                </div>
            </div>
        </div>
        <div class="menu-item">
            <a href="">Hàng mới về</a>
        </div>
        <div class="menu-item">
            <a href="{{ route('homeArticle') }}">Xu hướng làm đẹp</a>
        </div>
        <div class="menu-item ms-auto">
            <a href=""><img src="{{ asset('images/smart-phone.svg') }}" alt="" class="ìm-fluid">Tải ứng dụng</a>
        </div>
        <div class="menu-item">
            <a href="">Xu Tra cứu đơn hàng</a>
        </div>
    </div>
</div>
