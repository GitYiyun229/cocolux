@extends('web.layouts.web')

@section('content')
    <main>

        <div class="container">
            <nav aria-label="breadcrumb" class="pt-3 pb-3 mb-4">
                {{ Breadcrumbs::render('detailProduct', $product,$list_cats) }}
            </nav>
            <div class="layout-page-product-detail mb-5">
                <div class="layout-left">
                    <div class="layout-box layout-padding bg-white">
                        <div class="product-detail">
                            <div class="detail-thumbnail">
                                <div class="thumbnail-nav">
                                    @if(!empty($list_image))
                                        @forelse($list_image as $k => $item)
                                            <a data-index="{{ $k }}" class="thumbnail-item thumbnail-item-{{ $k }} @if( $k== 0) active @endif" data-bs-toggle="modal" data-bs-target="#imageModal">
                                                <img src="{{ asset(replace_image($item)) }}" alt="{{ $product->title }}" class="img-fluid">
                                            </a>
                                        @empty
                                        @endforelse
                                    @endif
                                </div>

                                <div class="thumbnail-image">
                                    <a href="" data-bs-toggle="modal" data-bs-target="#imageModal">
                                        <img src="{{ !empty($list_image)? asset(replace_image($list_image[0])):'' }}" alt="{{ $product->title }}" class="img-fluid detail-thumbnail-image">
                                    </a>
                                    <div class="detail-share">
                                        Thêm vào danh sách yêu thích
                                    </div>
                                </div>
                            </div>
                            <form action="{{ route('addToCartNow') }}" method="post">
                                @csrf
                                <div class="detail-infomation">
                                    @if($brand)
                                    <a href="{{ route('detailBrand',['slug'=>$brand->slug,'id'=>$brand->id]) }}" class="detail-brand fw-bold d-flex mb-1">{{ $brand->name }}</a>
                                    @endif

                                    <h1 class="detail-title fw-bold mb-1">{{ $product->title }}</h1>

                                    <div class="detail-sku mb-2">
                                        <div class="">Mã sản phẩm: {{ $product->sku }}</div> |
                                        <div class="star-rating" style="--rating: 4.6;"></div>
                                        <div class="review-count">0 đánh giá</div>
                                    </div>
                                    @if($flash_sale)
                                    <div class="detail-flash text-uppercase fw-bold mb-1">
                                        <div class="flash-title d-flex align-items-center">
                                            <img src="{{ asset('images/hot_icon.svg') }}" alt="flash sale" class="img-fluid">
                                            flash sale
                                        </div>
                                        <div class="flash-time d-flex align-items-center">
                                            <span class="fw-normal">Kết thúc trong</span>
                                            <div class="count-down d-flex align-items-center" time-end="{{ $flash_sale->applied_stop_time }}"></div>
                                        </div>
                                    </div>
                                    @endif

                                    <div class="detail-price mb-4">
                                        @if($flash_sale)
                                            <div class="public-price"><span class="fw-bold">{{ format_money($product->flash_deal->price) }}</span>(Đã bảo gồm VAT)</div>
                                            <div class="origin-price">
                                                <span>Giá hãng: {{ format_money($product->normal_price) }}</span>
                                                <span>- Tiết kiệm được {{ format_money(trim($product->normal_price) - trim($product->flash_deal->price)) }}</span>
                                                <span>({{ percentage_price($product->flash_deal->price, $product->normal_price) }})</span>
                                            </div>
                                        @elseif($hot_deal)
                                            <div class="public-price"><span class="fw-bold">{{ format_money($product->hot_deal->price) }}</span>(Đã bảo gồm VAT)</div>
                                            <div class="origin-price">
                                                <span>Giá hãng: {{ format_money($product->normal_price) }}</span>
                                                <span>- Tiết kiệm được {{ format_money(trim($product->normal_price) - trim($product->hot_deal->price)) }}</span>
                                                <span>({{ percentage_price($product->hot_deal->price, $product->normal_price) }})</span>
                                            </div>
                                        @else
                                            <div class="public-price"><span class="fw-bold">{{ format_money($product->price) }}</span>(Đã bảo gồm VAT)</div>
                                            @if($product->price != $product->normal_price)
                                                <div class="origin-price">
                                                    <span>Giá hãng: {{ format_money($product->normal_price) }}</span>
                                                    <span>- Tiết kiệm được {{ format_money($product->normal_price - $product->price) }}</span>
                                                    <span>({{ percentage_price($product->price, $product->normal_price) }})</span>
                                                </div>
                                            @endif
                                        @endif
                                    </div>

                                    <div class="detail-relate mb-4">
                                        @if(!empty($list_product_parent))
                                            @forelse($list_product_parent as $item)
                                                <a href="{{ route('detailProduct',['slug'=> !empty($item->slug)?trim($item->slug):trim($product_root->slug), 'sku' => $item->sku]) }}" class="@if ($product->id == $item->id) active @endif" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{ $item->title }}">
                                                    <img src="{{ asset($item->image_first) }}" alt="{{ $item->title }}" class="img-fluid">
                                                </a>
                                            @empty
                                            @endforelse
                                        @endif
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
                                    @if($count_store)
                                    <div class="detail-button">
                                        <div class="dropdown detail-address">
                                            <a class="btn btn-address" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fa-solid fa-circle-check"></i>
                                                {{ $count_store }}/13 Chi nhánh còn sản phẩm
                                            </a>

                                            @if($stores)
                                            <div class="dropdown-menu detail-addess-box">
                                                @forelse($stores as $cityName => $cityStore)
                                                <div class="address-item">
                                                    <p class="address-title text-uppercase mb-1">{{ $cityName }}</p>
                                                    @forelse($cityStore as $districtName => $districtStores)
                                                    <div class="address-group">
                                                        <p class="group-title mb-1">
                                                            <i class="fa-solid fa-circle-check"></i>
                                                            {{ $districtName }}
                                                        </p>
                                                        @forelse($districtStores as $wardName => $store)
{{--                                                        <div class="group-item mb-1">Tạm hết hàng tại Kho Media</div>--}}
                                                            <div class="group-item mb-1"><span>Còn hàng</span> tại {{ $store->name }}</div>
                                                        @empty
                                                        @endforelse
                                                    </div>
                                                    @empty
                                                    @endforelse
                                                </div>
                                                @empty
                                                @endforelse
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
                                            @endif
                                        </div>
                                        <input type="hidden" name="id_product" value="{{ $product->id }}">
                                        <button class="btn btn-add-card" type="button" onclick="order({{ $product->id }})">
                                            <i class="fa-solid fa-cart-plus"></i>
                                            Giỏ hàng
                                        </button>
                                        <button class="btn btn-buy-now" type="submit">
                                            <i class="fa-solid fa-cart-shopping"></i>
                                            Mua ngay
                                        </button>
                                    </div>
                                    @else
                                        <div class="detail-button">
                                            <button class="btn border w-100" type="button">
                                                Tạm hết hàng
                                            </button>
                                            <button class="btn btn-buy-now w-100" type="button">
                                                <i class="fa-solid fa-cart-shopping"></i>
                                                Thông báo khi có hàng
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="layout-box layout-padding bg-white">
                        <h2 class="layout-title mb-2 fw-bold">Thông tin sản phẩm</h2>

                        <div class="product-attribute">
                            @if(!empty($attribute_value))
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
                            @endif
                        </div>
                    </div>

                    <nav id="navbar-detail" class="navbar bg-white ">
                        <ul class="nav nav-pills">
                            <li class="nav-item">
                                <a class="nav-link nav-link-detail" href="#tab-des">Mô tả sản phẩm</a>
                            </li>
                            @if(!empty($attribute_value))
                            @forelse($attribute_value as $k => $item)
                                @if($item->value->type == 'ckeditor')
                                    <li class="nav-item">
                                        <a class="nav-link nav-link-detail" href="#tab-{{ $k }}">{{ $item->name }}</a>
                                    </li>
                                @endif
                            @empty
                            @endforelse
                            @endif
                        </ul>
                    </nav>
                    <div class="layout-box layout-padding bg-white" id="tab-des">
                        <h2 class="layout-title mb-2 fw-bold">Mô tả sản phẩm</h2>
                        <div class="layout-content-text">{!! replace_image($product->product->description) !!}</div>
                    </div>
                    @if(!empty($attribute_value))
                    @forelse($attribute_value as $k => $item)
                        @if($item->value->type == 'ckeditor')
                            <div class="layout-box layout-padding bg-white" id="tab-{{ $k }}">
                                <h2 class="layout-title mb-2 fw-bold">{{ $item->name }}</h2>
                                <div class="layout-content-text">{!! replace_image($item->value->name) !!}</div>
                            </div>
                        @endif
                    @empty
                    @endforelse
                    @endif

                    <div class="layout-box layout-padding bg-white d-none">
                        <h2 class="layout-title mb-2 fw-bold">Đánh giá</h2>
                        <p>Khách hàng đánh giá</p>

                        <div class="layout-rating mb-4">
                            <div class="layout-rating-item text-center">
                                <p>Đánh giá trung bình</p>
                                <div class="product-total-rating">
                                    4.8
                                </div>
                                <div class="product-total-review">30 nhận xét</div>
                            </div>
                            <div class="layout-rating-item">
                                @for($i = 5; $i >= 1; $i --)
                                <div class="product-rating-item d-grid align-items-center gap-1">
                                    <div class="">{{ $i }} sao</div>
                                    <div class="progress" role="progressbar" aria-label="Example 20px high" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                        <div class="progress-bar" style="width: 21%"></div>
                                    </div>
                                    <div>
                                        21%
                                    </div>
                                    <div class="">
                                        @switch($i)
                                            @case(1)
                                                Rất tệ
                                                @break
                                            @case(2)
                                                Không hài lòng
                                                @break
                                            @case(3)
                                                Bình thường
                                                @break
                                            @case(4)
                                                Hài lòng
                                                @break
                                            @case(5)
                                                Rất hài lòng
                                                @break
                                            @default
                                        @endswitch
                                    </div>
                                </div>
                                @endfor
                            </div>
                            <div class="layout-rating-item text-center">
                                <p>Chia sẻ cảm nghĩ của bạn về sản phẩm</p>
                                <button class="fw-bold text-white">Viết bình luận</button>
                            </div>
                        </div>

                        <form class="layout-review mb-4" id="formReivew" action="" method="POST" enctype="multipart/form-data">
                            <p class="mb-2">Đánh giá sản phẩm này *</p>
                            <div class="review-rating position-relative d-flex align-items-center mb-3 fs-4">
                                @for ($i = 1; $i <= 5; $i++)
                                <div class="review-rating-item" value="{{ $i }}">
                                    <i class="fa-solid fa-star"></i>
                                </div>
                                @endfor
                            </div>
                            <input type="hidden" name="rate" id="rate" value="0">
                            <input type="file" class="d-none" name="image" multiple id="image" accept="image/*" id="image">
                            <textarea name="content" id="content" rows="3" class="form-control mb-3" placeholder="Nhập mô tả ở đây"></textarea>
                            <div class="d-flex justify-content-between">
                                <p class="mb-0">Thêm ảnh sản phẩm (tối đa 5)</p>
                                <div class="text-end">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <div class="list-image-review d-flex align-items-center gap-2"></div>
                                        <a href="" class="submit-image d-inline-block fw-bold">Chọn hình</a>
                                    </div>
                                    <a href="" class="submit-review d-inline-block fw-bold">Gửi</a>
                                </div>
                            </div>
                        </form>

                        <div class="layout-feedback">
                            <div class="feedback-title mb-4 d-flex align-items-center justify-content-between">
                                <p class="mb-0">0 đánh giá cho sản phẩm này</p>
                                <div class="feedback-sort">
                                    <select name="" id="">
                                        <option value="">Ngày tạo mới nhất</option>
                                        <option value="">Ngày tạo lâu nhất</option>
                                    </select>
                                </div>
                            </div>
                            <div class="feedback-list">
                                <p class="mb-1 text-secondary">Chưa có đánh giá nào cho sản phẩm này</p>
                                <p class="mb-0">Hãy trở thành người đầu tiên đánh giá cho sản phẩm này...</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="layout-right">
                    <div class="layout-box bg-white">
                        <h4 class="h4-title fw-bold text-center mb-0">Sản phẩm cùng thương hiệu</h4>
                        @if(!empty($products))
                        @forelse($products as $item)
                        <a href="{{ route('detailProduct',['slug' => !empty($item->slug)?trim($item->slug):$item->product_slug, 'sku' => $item->sku]) }}" class="product-template">
                            @if($item->price != $item->normal_price)
                                <div class="product-discount">
                                    <span class="pe-1">{{ percentage_price($item->price, $item->normal_price) }}</span>
                                </div>
                            @endif
                            <div class="product-thumbnail">
                                <img src="{{ asset(replace_image($item->image_first)) }}" alt="{{ $item->title }}" class="img-fluid">
                            </div>
                            <div class="product-price">
                                <div class="public-price">{{ format_money($item->price) }}</div>
                                @if($item->price != $item->normal_price)
                                    <div class="origin-price">{{ format_money($item->normal_price) }}</div>
                                @endif
                            </div>
                            <div class="product-brand">
                                {{ $item->brand }}
                            </div>
                            <div class="product-title">
                                {{ $item->title }}
                            </div>
                        </a>
                        @empty
                        @endforelse
                        @endif
                        @if($brand)
                            <a href="{{ route('detailBrand',['slug'=>$brand->slug,'id'=>$brand->id]) }}" class="more-brand">Xem thêm</a>
                        @endif

                    </div>
                </div>
            </div>

            <div class="layout-fixed d-flex align-items-center position-fixed top-0 start-0 w-100 d-lg-none">
                <a href="javascript:void(0)" onclick="history.back()" class="d-flex align-items-center justify-content-center">
                    <i class="fa-solid fa-chevron-left"></i>
                </a>
                <span>{{ $product->title }}</span>
            </div>
        </div>

        <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0">
                    <div class="modal-body">
                        <button type="button" class="btn-close position-absolute" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div class="main-image position-relative">
                            <img src="{{ !empty($list_image)?asset(replace_image($list_image[0])):'' }}" class="img-fluid detail-thumbnail-image-modal" alt="{{ $product->image }}">
                            <a href="" class="btn-slide-prev position-absolute d-flex align-items-center justify-content-center text-white">
                                <i class="fa-solid fa-chevron-left"></i>
                            </a>
                            <a href="" class="btn-slide-next position-absolute d-flex align-items-center justify-content-center text-white">
                                <i class="fa-solid fa-chevron-right"></i>
                            </a>
                        </div>
                        <div class="main-right">
                            <div class="product-title fw-bold mb-2">{{ $product->title }}</div>
                            <div class="product-thumbnails">
                                @if(!empty($list_image))
                                @forelse($list_image as $k => $item)
                                <a data-index="{{ $k }}" class="modal-thumbnail-item thumbnail-item-{{ $k }} @if( $k== 0) active @endif">
                                    <img src="{{ asset(replace_image($item)) }}" alt="{{ $product->title }}" class="img-fluid">
                                </a>
                                @empty
                                @endforelse
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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

        $('.btn-slide-next').click(function(e) {
            changeSlide(e, 1);
        })

        $('.btn-slide-prev').click(function(e) {
            changeSlide(e, -1);
        })

        function changeSlide(e, type) {
            e.preventDefault();

            let currentElement = $('.modal-thumbnail-item.active');
            let index = parseInt(currentElement.attr('data-index'));
            let total = $('.modal-thumbnail-item').length;
            let changeIndex;

            if (type > 0) {
                changeIndex = index + 1 >= total ? 0 : index + 1;
            } else {
                changeIndex = index == 0 ? total - 1 : index - 1;
            }

            $('.modal-thumbnail-item.thumbnail-item-'+changeIndex).click();
        }

        $('.submit-image').click(function(e){
            e.preventDefault();
            $("#image").click();
        })

        $('#image').change(function() {
            const files = this.files;
            const maxAllowedFiles = 5;

            $('.list-image-review').empty();

            if (files.length > 5) {
                console.log('Chỉ được up tối đa 5 ảnh');
            }

            for (let i = 0; i < Math.min(maxAllowedFiles, files.length); i++) {
                const file = files[i];
                const image = $('<img class="img-fluid" width="50" height="50">').addClass('uploaded-image');
                const reader = new FileReader();
                reader.onload = function(e) {
                    image.attr('src', e.target.result);
                };
                reader.readAsDataURL(file);
                $('.list-image-review').append(image);
            }
        })

        $('.submit-review').click(function(e) {
            e.preventDefault();
            let content = $('#content').val();
            let rate = $('#rate').val();
            $('.review-rating p').remove();
            $('#content').next('p').remove();
            if (rate == 0){
                $('.review-rating').append('<p class="position-absolute text-danger m-0" style="left: 150px; font-size: 14px">Vui lòng đánh giá sản phẩm.</p>');
                return false;
            }
            if (!content.trim()) {
                $('#content').focus();
                $('<p class="mb-2 text-danger">Vui lòng nhập nội dung đánh giá của bạn.</p>').insertAfter("#content");
                return false;
            }
            $(this).closest('form').submit();
        })

        $('.review-rating-item').hover(function() {
            toggleStar(parseInt($(this).attr('value')))
        }, function() {
            toggleStar(parseInt($('#rate').val()))
        })

        $('.review-rating-item').click(function() {
            let value = parseInt($(this).attr('value'));
            $('#rate').val(value);
            toggleStar(value)
        })

        function toggleStar(value) {
            $(`.review-rating-item`).removeClass('active')
            for (let i = 1; i <= value; i++) {
                $(`.review-rating-item:eq(${i - 1})`).addClass('active')
            }
        }

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
            let index = $(this).attr('data-index');

            $('.detail-thumbnail-image').attr('src', src);
            $('.detail-thumbnail-image-modal').attr('src', src);

            $('.thumbnail-item').removeClass('active');
            $('.modal-thumbnail-item').removeClass('active');
            $('.thumbnail-item-'+index).addClass('active');
            // $(this).addClass('active');
        })

        $('.modal-thumbnail-item').click(function() {
            let src = $(this).find('img').attr('src');
            $('.detail-thumbnail-image-modal').attr('src', src);
            $('.modal-thumbnail-item').removeClass('active');
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
                    $("#number-added-cart").html(data.total);
                    Swal.fire(
                        'Thành công!',
                        'Thêm vào giỏ hàng thành công',
                        'success'
                    )
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Có lỗi xảy ra, Không thành công',
                    })
                }
            });
        }
    </script>
@endsection
