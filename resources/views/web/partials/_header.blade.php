@if (!$isMobile)
@if (isset($setting['image_top_head']) && !empty($setting['image_top_head']))
<div class="banner-top-image_top_head w-100 overflow-hidden" style="max-height:80px">
    <a href="{{ $setting['link_banner_header_top'] }}" title="cocolux" target="_blank">
        <img src="{{ $setting['image_top_head'] }}" alt="cocolux"
            class="img-fluid w-100 overflow-hidden" style="max-height:80px">
    </a>
</div>
@endif
@endif
<div class="header-top">
    <div class="container">
        <svg fill="currentColor" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512">
            <path
                d="M280 0C408.1 0 512 103.9 512 232c0 13.3-10.7 24-24 24s-24-10.7-24-24c0-101.6-82.4-184-184-184c-13.3 0-24-10.7-24-24s10.7-24 24-24zm8 192a32 32 0 1 1 0 64 32 32 0 1 1 0-64zm-32-72c0-13.3 10.7-24 24-24c75.1 0 136 60.9 136 136c0 13.3-10.7 24-24 24s-24-10.7-24-24c0-48.6-39.4-88-88-88c-13.3 0-24-10.7-24-24zM117.5 1.4c19.4-5.3 39.7 4.6 47.4 23.2l40 96c6.8 16.3 2.1 35.2-11.6 46.3L144 207.3c33.3 70.4 90.3 127.4 160.7 160.7L345 318.7c11.2-13.7 30-18.4 46.3-11.6l96 40c18.6 7.7 28.5 28 23.2 47.4l-24 88C481.8 499.9 466 512 448 512C200.6 512 0 311.4 0 64C0 46 12.1 30.2 29.5 25.4l88-24z" />
        </svg>
        <span class="ms-2">{{ $setting['hotline'] }}</span>
    </div>
</div>
<div class="header-main">
    <div class="container">
        <a href="{{ route('home') }}" title="cocolux" class="header-main-logo">
            <img src="{{ $setting['logo'] }}" alt="cocolux" class="img-fluid logo-full">
        </a>
        <a href="{{ route('home') }}" title="cocolux" class="header-main-logo-icon">
            <img src="{{ $setting['logo_scroll'] }}" alt="cocolux" class="img-fluid logo-icon">
        </a>
        @if (!$isMobile)
        <div class="header-menu">
            <div class="menu-item menu-site">
                <a href="">
                    <i class="fa-solid fa-bars"></i>
                    Danh mục sản phẩm
                </a>
                <div class="menu-content">
                    @forelse($cat_products as $item)
                    <div class="menu-item">
                        <a href="{{ route('catProduct', ['slug' => $item->slug, 'id' => $item->id]) }}"
                            class="menu-btn">{{ $item->title }} <i class="fa-solid fa-angle-right"></i></a>
                        @if (count($item->children) > 0)
                        <div class="menu-content">
                            <div class="position-relative h-100 w-100">
                                <div class="menu-group-top">
                                    <a
                                        href="{{ route('catProduct', ['slug' => $item->slug, 'id' => $item->id]) }}?sort=1">Nổi
                                        bật</a>
                                    <a
                                        href="{{ route('catProduct', ['slug' => $item->slug, 'id' => $item->id]) }}?sort=2">Bán
                                        chạy</a>
                                    <a
                                        href="{{ route('catProduct', ['slug' => $item->slug, 'id' => $item->id]) }}?sort=3">Hàng
                                        mới</a>
                                </div>
                                <div class="menu-group-bottom">
                                    @forelse($item->children as $child)
                                    <div class="menu-col-item">
                                        <a href="{{ route('catProduct', ['slug' => $child->slug, 'id' => $child->id]) }}"
                                            class="item-parent">{{ $child->title }}</a>
                                        @if (count($child->children) > 0)
                                        @forelse($child->children as $lv3)
                                        <a href="{{ route('catProduct', ['slug' => $lv3->slug, 'id' => $lv3->id]) }}"
                                            class="item-child">{{ $lv3->title }}</a>
                                        @empty
                                        @endforelse
                                        @endif
                                    </div>
                                    @empty
                                    @endforelse
                                </div>
                                <div class="menu-poster 2345234">
                                    @if (!empty($item->image))
                                    <img src="{{ $item->image }}" alt="342442">
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    @empty
                    @endforelse
                </div>
            </div>
        </div>
        @endif
        <div class="header-main-menu">
            <form action="{{ route('search') }}" name="search_product" id="search_product" method="get">
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle form-drop-btn" id="dropdown_change" type="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <span>Tất cả</span>
                    </button>
                    <div class="dropdown-menu header-main-dropdown">
                        <div class="dropdown-item item-parent">Tất cả</div>
                        @forelse($cat_products as $item)
                        <section>
                            <div class="dropdown-item item-parent" data-value="{{ $item->id }}">
                                {{ $item->title }}
                            </div>
                            @if (count($item->children) > 0)
                            @forelse($item->children as $child)
                            <div class="dropdown-item item-child" data-value="{{ $child->id }}">
                                {{ $child->title }}
                            </div>
                            @empty
                            @endforelse
                            @endif
                        </section>
                        @empty
                        @endforelse
                    </div>
                </div>
                <input type="text" class="form-control" name="keyword" id="keyword" value="{{ old('keyword') }}"
                    autocomplete="off" placeholder="Tìm sản phẩm bạn mong muốn..." required>
                <input type="hidden" name="categories" id="cat_product">
                <button type="submit" class="btn form-submit" name="submit-form-search" id="submit-form-search"
                    aria-label="Submit form search">
                    <img src="{{ asset('images/search-icon.svg') }}" alt="" width="29" height="29"
                        class="img-fluid">
                </button>
            </form>

            <a href="{{ route('showCart') }}" class="menu-btn">
                <img src="{{ asset('images/cart-icon.svg') }}" alt="">
                <span>Giỏ hàng</span>
                <span class="cart-items-total" id="number-added-cart">{{ getCart() }}</span>
            </a>

            <a href="tel:{{ $setting['hotline'] }}" class="menu-btn menu-call-hotline">
                <img src="{{ asset('images/hotline-icon.svg') }}" alt="hotline" class="img-fluid">
                <span>Hỗ trợ <br> Khách hàng</span>
            </a>
        </div>
    </div>
</div>
@if (!$isMobile)
<div class="header-bottom">
    <div class="container header-bottom-menu header-menu">
        {{-- <div class="menu-item menu-site @if (request()->route()->getName() == 'home') active @endif"> --}}
        <div class="menu-item menu-site @if (request()->route() && request()->route()->getName() == 'home') active @endif">

            <a href="">
                <i class="fa-solid fa-bars"></i>
                Danh mục sản phẩm
            </a>
            <div class="menu-content">
                @forelse($cat_products as $item)
                <div class="menu-item">
                    <a href="{{ route('catProduct', ['slug' => $item->slug, 'id' => $item->id]) }}"
                        class="menu-btn">{{ $item->title }} <i class="fa-solid fa-angle-right"></i></a>
                    @if (count($item->children) > 0)
                    <div class="menu-content">
                        <div class="position-relative h-100 w-100">
                            <div class="menu-group-top">
                                <a
                                    href="{{ route('catProduct', ['slug' => $item->slug, 'id' => $item->id]) }}?sort=1">Nổi
                                    bật</a>
                                <a
                                    href="{{ route('catProduct', ['slug' => $item->slug, 'id' => $item->id]) }}?sort=2">Bán
                                    chạy</a>
                                <a
                                    href="{{ route('catProduct', ['slug' => $item->slug, 'id' => $item->id]) }}?sort=3">Hàng
                                    mới</a>
                            </div>
                            <div class="menu-group-bottom">
                                @forelse($item->children as $child)
                                <div class="menu-col-item">
                                    <a href="{{ route('catProduct', ['slug' => $child->slug, 'id' => $child->id]) }}"
                                        class="item-parent">{{ $child->title }}</a>
                                    @if (count($child->children) > 0)
                                    @forelse($child->children as $lv3)
                                    <a href="{{ route('catProduct', ['slug' => $lv3->slug, 'id' => $lv3->id]) }}"
                                        class="item-child">{{ $lv3->title }}</a>
                                    @empty
                                    @endforelse
                                    @endif
                                </div>
                                @empty
                                @endforelse
                            </div>
                            <div class="menu-poster 342342">
                                @if (!empty($item->image))
                                <img src="{{ $item->image }}" alt="">
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                @empty
                @endforelse
            </div>
        </div>
        @if (!empty($menus))
        @forelse($menus as $item)
        <div class="menu-item">
            <a href="{{ $item->link }}">{{ $item->name }}</a>
            @if (count($item->children) > 0)
            <div class="menu-content">
                @forelse($item->children as $child)
                <div class="menu-item">
                    <a href="{{ $child->link }}">{{ $child->name }}</a>
                </div>
                @empty
                @endforelse
            </div>
            @endif
        </div>
        @empty
        @endforelse
        @endif
        <div class="menu-item menu-app ms-auto">

        </div>
        <div class="menu-item menu-search-order">
            <a href="">Tra cứu đơn hàng</a>
            <div class="menu-content">
                <form action="{{ route('searchOrder') }}" method="POST" name="search-order">
                    @csrf
                    <input type="text" class="form-control" placeholder="Nhập số điện thoại ,mã đơn hàng"
                        name="order" id="order">
                    <button class="btn" type="submit">Kiểm tra đơn hàng</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif