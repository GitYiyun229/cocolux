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
                                    <div class="detail-share d-none">
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
                                    @if($product->promotionItem && $product->promotionItem->type == 'flash_deal')
                                    <div class="detail-flash text-uppercase fw-bold mb-1">
                                        <div class="flash-title d-flex align-items-center">
                                            <img src="{{ asset('images/hot_icon.svg') }}" alt="flash sale" class="img-fluid">
                                            flash sale
                                        </div>
                                        <div class="flash-time d-flex align-items-center">
                                            <span class="fw-normal">Kết thúc trong</span>
                                            <div class="count-down d-flex align-items-center" time-end="{{ $product->promotionItem->applied_stop_time }}"></div>
                                        </div>
                                    </div>
                                    @endif

                                    <div class="detail-price mb-4">
                                        @if($product->promotionItem)
                                            <div class="public-price"><span class="fw-bold">{{ format_money($product->promotionItem->price) }}</span>(Đã bảo gồm VAT)</div>
                                            @if($product->normal_price)
                                            <div class="origin-price">
                                                <span>Giá hãng: {{ format_money($product->normal_price) }}</span>
                                                <span>- Tiết kiệm được {{ format_money(trim($product->normal_price) - trim($product->promotionItem->price)) }}</span>
                                                <span>({{ percentage_price($product->promotionItem->price, $product->normal_price) }})</span>
                                            </div>
                                            @endif
                                        @else
                                            <div class="public-price"><span class="fw-bold">{{ format_money($product->price) }}</span>(Đã bảo gồm VAT)</div>
                                            @if($product->normal_price && $product->price != $product->normal_price)
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
                                    @if($setting['policy_ship'])
                                        <div class="policy_ship mb-3">{!! $setting['policy_ship'] !!}</div>
                                    @endif
                                    @if($count_store)
                                    <div class="detail-button">
                                        <div class="dropdown detail-address">
                                            <a class="btn btn-address" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fa-solid fa-circle-check"></i>
                                                {{ $count_store }}/17 Chi nhánh còn sản phẩm
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
                                        <button class="btn btn-add-card" type="button" onclick="window.orderProduct({{ $product->id }})">
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

                    <div class="layout-box layout-padding bg-white">
                        <h2 class="layout-title mb-2 fw-bold">Đánh giá</h2>
                        <p>Khách hàng đánh giá</p>

                        <div class="layout-rating mb-4">
                            <div class="layout-rating-item text-center">
                                <p>Đánh giá trung bình</p>
                                <div class="product-total-rating">
                                    {{ $averageRating }}
                                </div>
                                <div class="product-total-review">{{ count($comments) }} nhận xét</div>
                            </div>
                            <div class="layout-rating-item">
                                @foreach($percentages as $rating => $percentage)
                                <div class="product-rating-item d-grid align-items-center gap-1">
                                    <div class="">{{ $rating }} sao</div>
                                    <div class="progress" role="progressbar" aria-label="Example 20px high" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                        <div class="progress-bar" style="width: {{ $percentage }}%"></div>
                                    </div>
                                    <div>
                                        {{ $percentage }}%
                                    </div>
                                    <div class="">
                                        @switch($rating)
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
                                @endforeach
                            </div>
                            <div class="layout-rating-item text-center">
                                <p>Chia sẻ cảm nghĩ của bạn về sản phẩm</p>
                                <button class="fw-bold text-white">Viết bình luận</button>
                            </div>
                        </div>

                        <form class="layout-review mb-4" id="formReivew" action="{{ route('commentProduct') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <p class="mb-2">Đánh giá sản phẩm này *</p>
                            <div class="review-rating position-relative d-flex align-items-center mb-3 fs-4">
                                @for ($i = 1; $i <= 5; $i++)
                                    <div class="review-rating-item" value="{{ $i }}">
                                        <i class="fa-solid fa-star"></i>
                                    </div>
                                @endfor
                            </div>
                            <input type="hidden" name="rate" id="rate" value="0">
                            <input type="hidden" name="product_id" id="product_id" value="{{ $product_root->id }}">
                            <input type="file" class="d-none" name="image" multiple id="image" accept="image/*" id="image">
                            <textarea name="content" id="content" rows="3" class="form-control mb-3" placeholder="Nhập mô tả ở đây" required></textarea>
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="name-field">
                                        <label for="name" class="mb-1">Name:</label>
                                        <input type="text" id="name" name="name" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="phone-field">
                                        <label for="phone" class="mb-1">Số điện thoại:</label>
                                        <input type="text" id="phone" name="phone" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <p class="mb-0 d-none">Thêm ảnh sản phẩm (tối đa 5)</p>
                                <div class="text-end">
{{--                                    <div class="d-flex align-items-center gap-2 mb-2">--}}
{{--                                        <div class="list-image-review d-flex align-items-center gap-2"></div>--}}
{{--                                        <a href="" class="submit-image d-inline-block fw-bold">Chọn hình</a>--}}
{{--                                    </div>--}}
                                    <button type="submit" class="submit-review d-inline-block fw-bold">Gửi</button>
                                </div>
                            </div>
                        </form>

                        <div class="layout-feedback">
                            <div class="feedback-title mb-4 d-flex align-items-center justify-content-between">
                                <p class="mb-0">{{ count($comments) }} đánh giá cho sản phẩm này</p>
                                <div class="feedback-sort d-none">
                                    <select name="" id="">
                                        <option value="">Ngày tạo mới nhất</option>
                                        <option value="">Ngày tạo lâu nhất</option>
                                    </select>
                                </div>
                            </div>
                            <div class="feedback-list">
                                @if(!count($comments))
                                    <p class="mb-1 text-secondary">Chưa có đánh giá nào cho sản phẩm này</p>
                                    <p class="mb-0">Hãy trở thành người đầu tiên đánh giá cho sản phẩm này...</p>
                                @else
                                    @foreach($comments as $comment)
                                        <div class="alert alert-light" role="alert">
                                            <p class="fw-bold mb-2">{{ $comment->name }}</p>
                                            <div class="review-rating-item-comment mb-2" >
                                                @for ($i = 1; $i <= $comment->rating; $i++)
                                                    <i class="fa-solid fa-star active"></i>
                                                @endfor
                                                @for ($i = 1; $i <= (5 - $comment->rating); $i++)
                                                    <i class="fa-solid fa-star"></i>
                                                @endfor
                                            </div>
                                            {{ $comment->content }}
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>

                    @if($product_in_cat)
                        <div class="list-product-article mb-4">
                            <div class="title-product-same">
                                <span>
                                 Sản phẩm cùng danh mục
                                </span>
                            </div>
                            <div class="slide-template-slick">
                                @forelse($product_in_cat as $item)
                                    <a href="{{ route('detailProduct',['slug'=> !empty($item->slug)?trim($item->slug):$item->product->slug, 'sku' =>$item->sku]) }}" class="product-template">
                                        @if($item->promotionItem)
                                            @if($item->promotionItem->price != $item->normal_price)
                                                <div class="product-discount">
                                                    <span class="pe-1">{{ percentage_price($item->promotionItem->price, $item->normal_price) }}</span>
                                                </div>
                                            @endif
                                        @else
                                            @if($item->price != $item->normal_price)
                                                <div class="product-discount">
                                                    <span class="pe-1">{{ percentage_price($item->price, $item->normal_price) }}</span>
                                                </div>
                                            @endif
                                        @endif
                                        <div class="product-thumbnail">
                                            <img src="{{ asset($item->image_first) }}" alt="{{ $item->title }}" class="img-fluid">
                                        </div>
                                        <div class="product-price">
                                            @if($item->promotionItem)
                                                <div class="public-price">{{ format_money($item->promotionItem->price) }}</div>
                                                @if($item->promotionItem->price != $item->normal_price)
                                                    <div class="origin-price">{{ format_money($item->normal_price) }}</div>
                                                @endif
                                            @else
                                                <div class="public-price">{{ format_money($item->price) }}</div>
                                                @if($item->price != $item->normal_price)
                                                    <div class="origin-price">{{ format_money($item->normal_price) }}</div>
                                                @endif
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
                            </div>
                        </div>
                    @endif
                </div>

                <div class="layout-right">
                    <div class="layout-box bg-white">
                        <h4 class="h4-title fw-bold text-center mb-0">Sản phẩm cùng thương hiệu</h4>
                        @if(!empty($products))
                        @forelse($products as $item)
                        <a href="{{ route('detailProduct',['slug' => !empty($item->slug)?trim($item->slug):$item->product_slug, 'sku' => $item->sku]) }}" class="product-template">
                            @if($item->promotionItem)
                                @if($item->promotionItem->price != $item->normal_price)
                                    <div class="product-discount">
                                        <span class="pe-1">{{ percentage_price($item->promotionItem->price, $item->normal_price) }}</span>
                                    </div>
                                @endif
                            @else
                                @if($item->normal_price && $item->price != $item->normal_price)
                                    <div class="product-discount">
                                        <span class="pe-1">{{ percentage_price($item->price, $item->normal_price) }}</span>
                                    </div>
                                @endif
                            @endif
                            <div class="product-thumbnail">
                                <img src="{{ asset(replace_image($item->image_first)) }}" alt="{{ $item->title }}" class="img-fluid">
                            </div>
                            <div class="product-price">
                                @if($item->promotionItem)
                                    <div class="public-price">{{ format_money($item->promotionItem->price) }}</div>
                                    @if($item->promotionItem->price != $item->normal_price)
                                        <div class="origin-price">{{ format_money($item->normal_price) }}</div>
                                    @endif
                                @else
                                    <div class="public-price">{{ format_money($item->price) }}</div>
                                    @if($item->normal_price && $item->price != $item->normal_price)
                                        <div class="origin-price">{{ format_money($item->normal_price) }}</div>
                                    @endif
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
    <link rel="stylesheet" href="{{ mix('css/web/product-detail.css') }}">
@endsection

@section('script')
    @parent
    <script src="{{ mix('js/web/product-detail.js') }}"></script>
    @include('web.components.extend')
    <script>
        window.addToCart = '{{ route('addToCart') }}';
    </script>
@endsection
