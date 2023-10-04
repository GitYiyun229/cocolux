@extends('web.layouts.web')

@section('content')
    <main>

        <div class="container">
            <nav aria-label="breadcrumb" class="pt-3 pb-3 mb-4">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="#">
                            <i class="fa-solid fa-house-chimney"></i>
                            Trang chủ
                        </a>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">
                        Trang điểm
                    </li>
                    <li class="breadcrumb-item" aria-current="page">
                        Trang điểm mặt
                    </li>
                    <li class="breadcrumb-item" aria-current="page">
                        Kem nền - BB Cream
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Kem Nền Maybelline Fit Me Matte Poreless Foundation SPF 22 30ml
                    </li>
                </ol>
            </nav>

            <div class="layout-page-product-detail mb-5">
                <div class="layout-left">
                    <div class="layout-box layout-padding bg-white">
                        <div class="product-detail">
                            <div class="detail-thumbnail">
                                <div class="thumbnail-nav">
                                    @forelse($list_image as $k => $item)
                                    <a class="thumbnail-item @if( $k== 0) active @endif">
                                        <img src="{{ $item }}" alt="{{ $product->title }}" class="img-fluid">
                                    </a>
                                    @empty
                                    @endforelse
                                </div>

                                <div class="thumnail-image">
                                    <img src="{{ $list_image[0] }}" alt="{{ $product->title }}" class="img-fluid" id="detail-thumbnail-image">

                                    <div class="detail-share">
                                        Thêm vào danh sách yêu thích
                                    </div>
                                </div>
                            </div>

                            <div class="detail-infomation">
                                <a href="" class="detail-brand fw-bold d-flex mb-1">{{ $product->product->brand }}</a>

                                <h1 class="detail-title fw-bold mb-1">{{ $product->title }}</h1>

                                <div class="detail-sku mb-2">
                                    <div class="">Mã sản phẩm: {{ $product->sku }}</div> |
                                    <div class="star-rating" style="--rating: 4.6;"></div>
                                    <div class="review-count">0 đánh giá</div>
                                </div>

                                <div class="detail-flash text-uppercase fw-bold mb-1 d-none">
                                    <div class="flash-title d-flex align-items-center">
                                        <img src="/images/hot_icon.svg" alt="flash sale" class="img-fluid">
                                        flash sale
                                    </div>
                                    <div class="flash-time d-flex align-items-center">
                                        <span class="fw-normal">Kết thúc trong</span>
                                        <!-- $time_end = date('M d Y H:i:s', strtotime($time_end)); -->
                                        <div class="count-down d-flex align-items-center" time-end="Sep 30 2023 20:00:00"></div>
                                    </div>
                                </div>

                                <div class="detail-price mb-4">
                                    <div class="public-price"><span class="fw-bold">{{ format_money($product->price) }}</span>(Đã bảo gồm VAT)</div>
                                    <div class="origin-price">
                                        <span>Giá hãng: {{ format_money($product->nomal_price) }}</span>
                                        <span>- Tiết kiệm được 14.400 đ</span>
                                        <span>(5%)</span>
                                    </div>
                                </div>

                                <div class="detail-relate mb-4">
                                    @forelse($list_product_parent as $item)
                                    <a href="{{ route('detailProduct',['slug'=> !empty($item->slug)?$item->slug:$product_root->slug, 'sku' => $item->sku]) }}" class="@if ($product->id == $item->id) active @endif" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{ $item->title }}">
                                        <img src="{{ json_decode($item->images)[0] }}" alt="{{ $item->title }}" class="img-fluid">
                                    </a>
                                    @empty
                                    @endforelse
                                </div>

                                <div class="detail-quantity mb-4">
                                    <label for="quantity">Số lượng:</label>
                                    <input type="number" id="quantity" name="quantity" class="form-control" value="1" min="1">
                                </div>

                                <div class="detail-flash-progess mb-3 d-none">
                                    <div class="progress w-100" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                        <div class="progress-bar" style="width: 25%"></div>
                                    </div>
                                    <span>25%</span>
                                </div>

                                <div class="detail-button">
                                    <div class="dropdown detail-address">
                                        <a class="btn btn-address" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa-solid fa-circle-check"></i>
                                            10/13 Chi nhánh còn sản phẩm
                                        </a>

                                        <div class="dropdown-menu detail-addess-box">
                                            <div class="address-item">
                                                <p class="address-title text-uppercase mb-1">Hà Nội</p>
                                                <div class="address-group">
                                                    <p class="group-title mb-1">
                                                        <i class="fa-solid fa-circle-check"></i>
                                                        Đống Đa
                                                    </p>
                                                    <div class="group-item mb-1">Tạm hết hàng tại Kho Media</div>
                                                    <div class="group-item mb-1">Tạm hết hàng tại Kho Live</div>
                                                    <div class="group-item mb-1"><span>Còn hàng</span> tại Cocolux 14 B7 Phạm Ngọc Thạch</div>
                                                    <div class="group-item mb-1"><span>Còn hàng</span> tại Cocolux 80 Chùa Bộc</div>
                                                </div>
                                                <div class="address-group">
                                                    <p class="group-title mb-1">
                                                        <i class="fa-solid fa-circle-check"></i>
                                                        Huyện Gia Lâm
                                                    </p>
                                                    <div class="group-item mb-1 mb-1"><span>Còn hàng</span> tại Cocolux Vincom Mega Mall Smart City</div>
                                                </div>
                                                <div class="address-group">
                                                    <p class="group-title mb-1">
                                                        <i class="fa-solid fa-circle-check"></i>
                                                        Huyện Gia Lâm
                                                    </p>
                                                    <div class="group-item"><span>Còn hàng</span> tại Cocolux Ocean Park</div>
                                                </div>
                                                <div class="address-group">
                                                    <p class="group-title mb-1">
                                                        <i class="fa-solid fa-circle-check"></i>
                                                        Quận Cầu Giấy
                                                    </p>
                                                    <div class="group-item mb-1"><span>Còn hàng</span> tại Cocolux 128 Xuân Thủy</div>
                                                    <div class="group-item mb-1"><span>Còn hàng</span> tại Cocolux 65 Hồ tùng mậu</div>
                                                    <div class="group-item mb-1"><span>Còn hàng</span> tại Cocolux 136 Cầu Giấy</div>
                                                </div>
                                            </div>
                                            <div class="address-item">
                                                <p class="address-title text-uppercase mb-1">Hồ chí minh</p>
                                                <div class="address-group">
                                                    <p class="group-title mb-1">
                                                        <i class="fa-solid fa-circle-check"></i>
                                                        Đống Đa
                                                    </p>
                                                    <div class="group-item mb-1">Tạm hết hàng tại Kho Media</div>
                                                    <div class="group-item mb-1">Tạm hết hàng tại Kho Live</div>
                                                    <div class="group-item mb-1"><span>Còn hàng</span> tại Cocolux 14 B7 Phạm Ngọc Thạch</div>
                                                    <div class="group-item mb-1"><span>Còn hàng</span> tại Cocolux 80 Chùa Bộc</div>
                                                </div>
                                                <div class="address-group">
                                                    <p class="group-title mb-1">
                                                        <i class="fa-solid fa-circle-check"></i>
                                                        Huyện Gia Lâm
                                                    </p>
                                                    <div class="group-item mb-1 mb-1"><span>Còn hàng</span> tại Cocolux Vincom Mega Mall Smart City</div>
                                                </div>
                                                <div class="address-group">
                                                    <p class="group-title mb-1">
                                                        <i class="fa-solid fa-circle-check"></i>
                                                        Huyện Gia Lâm
                                                    </p>
                                                    <div class="group-item"><span>Còn hàng</span> tại Cocolux Ocean Park</div>
                                                </div>
                                                <div class="address-group">
                                                    <p class="group-title mb-1">
                                                        <i class="fa-solid fa-circle-check"></i>
                                                        Quận Cầu Giấy
                                                    </p>
                                                    <div class="group-item mb-1"><span>Còn hàng</span> tại Cocolux 128 Xuân Thủy</div>
                                                    <div class="group-item mb-1"><span>Còn hàng</span> tại Cocolux 65 Hồ tùng mậu</div>
                                                    <div class="group-item mb-1"><span>Còn hàng</span> tại Cocolux 136 Cầu Giấy</div>
                                                </div>
                                            </div>
                                            <div class="contact">
                                                <span>
                                                    <i class="fa-regular fa-clock"></i>
                                                    8:00 AM - 22:00 PM
                                                </span>
                                                <span>
                                                    <i class="fa-solid fa-phone"></i>
                                                    <a href="tel:0988888825">0988888825</a>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-add-card" onclick="order({{ $product->id }})">
                                        <i class="fa-solid fa-cart-plus"></i>
                                        Giỏ hàng
                                    </button>
                                    <button class="btn btn-buy-now">
                                        <i class="fa-solid fa-cart-shopping"></i>
                                        Mua ngay
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="layout-box layout-padding bg-white">
                        <h2 class="layout-title mb-2 fw-bold">Thông tin sản phẩm</h2>

                        <div class="product-attribute">
                            @forelse($attribute_value as $item)
                                @if($item->value->type == 'select')
                                    <div class="attribute-item">
                                        <div class="attribute-title">
                                            {{ $item->name }}
                                        </div>
                                        <div class="attribute-value">
                                            {{ $item->value->name }}
                                        </div>
                                    </div>
                                @endif
                            @empty
                            @endforelse
                        </div>
                    </div>

                    <nav id="navbar-detail" class="navbar bg-white ">
                        <ul class="nav nav-pills">
                            @forelse($attribute_value as $k => $item)
                                @if($item->value->type == 'ckeditor')
                                    <li class="nav-item">
                                        <a class="nav-link nav-link-detail" href="#tab-{{ $k }}">{{ $item->name }}</a>
                                    </li>
                                @endif
                            @empty
                            @endforelse
                        </ul>
                    </nav>
                    @forelse($attribute_value as $k => $item)
                        @if($item->value->type == 'ckeditor')
                            <div class="layout-box layout-padding bg-white" id="tab-{{ $k }}">
                                <h2 class="layout-title mb-2 fw-bold d-none">{{ $item->name }}</h2>
                                <div class="layout-content-text">{!! $item->value->name !!}</div>
                            </div>
                        @endif
                    @empty
                    @endforelse
                </div>

                <div class="layout-right">
                    <div class="layout-box bg-white">
                        <h4 class="h4-title fw-bold text-center mb-0">Sản phẩm cùng thương hiệu</h4>
                        @forelse($products as $item)
                        <a href="{{ route('detailProduct',['slug' => $item->slug, 'sku' => $item->sku]) }}" class="product-template">
                            <div class="product-discount">
                                <span class="pe-1">5%</span>
                            </div>
                            <div class="product-thumbnail">
                                <img src="{{ asset($item->image) }}" alt="{{ $item->title }}" class="img-fluid">
                            </div>
                            <div class="product-price">
                                <div class="public-price">{{ format_money($item->productOption->first()->price) }}</div>
                                <div class="origin-price">{{ format_money($item->productOption->first()->normal_price) }}</div>
                            </div>
                            <div class="product-brand">
                                {{ $item->brand }}
                            </div>
                            <div class="product-title">
                                {{ $item->productOption->first()->title }}
                            </div>
                        </a>
                        @empty
                        @endforelse

                        <a href="/link-to-brand" class="more-brand">Xem thêm</a>
                    </div>
                </div>
            </div>

            <div class="mb-2"></div>
        </div>

    </main>
@endsection

@section('link')
    @parent
    <link rel="stylesheet" href="{{ asset('/css/web/product-detail.css') }}">
@endsection

@section('script')
    @parent
    <script>
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

        $('.nav-link-detail').click(function(e) {
            e.preventDefault();
            let target = $(this).attr('href');
            target = target.replace(/.+(?=#)/g, '');
            $('html, body').css('scroll-behavior', 'auto').animate({
                'scrollTop': $(target).offset().top - 120
            }, 800);
        })

        $('.detail-address').mouseenter(function() {
            $(this).dropdown('show');
        })

        $('.detail-address').mouseleave(function() {
            $(this).dropdown('hide');
        })

        $('.thumbnail-item').click(function() {
            let src = $(this).find('img').attr('src');
            $('#detail-thumbnail-image').attr('src', src);
            $('.thumbnail-item').removeClass('active');
            $(this).addClass('active');
        })

        $(".count-down").each(function (e) {
            countdowwn($(this));
        });

        $(document).on("scroll", onScroll);

        function onScroll(event){
            let scrollPos = $(document).scrollTop();
            $('.nav-link-detail').each(function () {
                let currLink = $(this);
                let refElement = $(currLink.attr("href"));
                if (refElement.position().top - 140 <= scrollPos && refElement.position().top - 140 + refElement.height() > scrollPos) {
                    $('.nav-link-detail').removeClass("active");
                    currLink.addClass("active");
                } else {
                    currLink.removeClass("active");
                }
            });
        }

        function countdowwn(element) {
            let e = element.attr('time-end');
            let l = new Date(e).getTime();
            let n = setInterval(function () {
                let e = new Date().getTime();
                let t = l - e;
                let a = Math.floor(t / 864e5);
                let s = Math.floor((t % 864e5) / 36e5);
                let o = Math.floor((t % 36e5) / 6e4);
                e = Math.floor((t % 6e4) / 1e3);

                element.html(`
            <span>${a}</span>
            :
            <span>${s}</span>
            :
            <span>${o}</span>
            :
            <span>${e}</span>
        `);

                if (t < 0) {
                    clearInterval(n), element.html("Đã hết khuyến mại")
                };

            }, 1e3);
        }
    </script>

    <script>
        function order(id_prd) {
            var quantity = $("#quantity").val();
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '{{ route('addToCart') }}',
                data: {
                    quantity: quantity?quantity:1,
                    id: id_prd,
                    _token: $('meta[name="csrf-token"]').attr("content")
                },
                success: function (data) {
                    console.log(data);
                    $("#number-added-cart").html(data.total);
                }
            });
        }
    </script>
@endsection
