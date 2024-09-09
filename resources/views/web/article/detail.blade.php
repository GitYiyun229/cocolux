@extends('web.layouts.web')

@section('content')
    <main>

        <div class="container">
            <nav aria-label="breadcrumb" class="pt-3 pb-3 mb-4">
                {{ Breadcrumbs::render('detailArticle', $parent_cat, $article) }}
            </nav>

            <div class="layout-page-news-list mb-5">
                <div class="layout-menu">
                    <div class="news-categories layout-box bg-white">
                        <p class="mb-0 text-center text-uppercase fw-bold layout-title text-red">Blog làm đẹp</p>
                        @forelse($cat_article as $parent)
                            <a href="{{ route('catArticle', ['slug' => $parent->slug, 'id' => $parent->id]) }}"
                                class="category-item @if ($article->category->id == $parent->id) active fw-bold @endif level-0">
                                {{ $parent->title }}
                            </a>
                            @if (count($parent->children) > 0)
                                @forelse($parent->children as $child)
                                    <a href="{{ route('catArticle', ['slug' => $child->slug, 'id' => $child->id]) }}"
                                        class="category-item @if ($article->category->id == $child->id) active fw-bold @endif level-1">{{ $child->title }}</a>
                                @empty
                                @endforelse
                            @endif
                        @empty
                        @endforelse
                    </div>

                    <div class="products-hot layout-box bg-white">
                        <p class="mb-0 text-center text-uppercase fw-bold layout-title text-red">Sản phẩm hot</p>
                        @forelse($product_hots as $item)
                            <a href="{{ route('detailProduct', ['slug' => !empty($item->slug) ? trim($item->slug) : $item->product->slug, 'sku' => $item->sku]) }}"
                                class="product-template">
                                @if ($item->promotionItem)
                                    @if ($item->promotionItem->price != $item->normal_price)
                                        <div class="product-discount">
                                            <span
                                                class="pe-1">{{ percentage_price($item->promotionItem->price, $item->normal_price) }}</span>
                                        </div>
                                    @endif
                                @else
                                    @if ($item->price != $item->normal_price)
                                        <div class="product-discount">
                                            <span
                                                class="pe-1">{{ percentage_price($item->price, $item->normal_price) }}</span>
                                        </div>
                                    @endif
                                @endif
                                <div class="product-thumbnail">
                                    <img src="{{ asset($item->image_first) }}" alt="{{ $item->title }}" class="img-fluid">
                                </div>
                                <div class="product-price">
                                    @if ($item->promotionItem)
                                        <div class="public-price">{{ format_money($item->promotionItem->price) }}</div>
                                        @if ($item->promotionItem->price != $item->normal_price)
                                            <div class="origin-price">{{ format_money($item->normal_price) }}</div>
                                        @endif
                                    @else
                                        <div class="public-price">{{ format_money($item->price) }}</div>
                                        @if ($item->price != $item->normal_price)
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

                <div class="layout-main">
                    <div class="layout-main-detail layout-box layout-padding bg-white">
                        <h1 class="detail-title text-center fw-bold mb-4">
                            {{ $article->title }}
                        </h1>

                        <div class="detail-summary">
                            {!! $article->description !!}
                        </div>
                        @if ($products_choose)
                            <div class="list-product-article mb-4">
                                <div class="slide-template-slick">
                                    @forelse($products_choose as $item)
                                        <a href="{{ route('detailProduct', ['slug' => !empty($item->slug) ? trim($item->slug) : $item->product->slug, 'sku' => $item->sku]) }}"
                                            class="product-template">
                                            @if ($item->promotionItem)
                                                @if ($item->promotionItem->price != $item->normal_price)
                                                    <div class="product-discount">
                                                        <span
                                                            class="pe-1">{{ percentage_price($item->promotionItem->price, $item->normal_price) }}</span>
                                                    </div>
                                                @endif
                                            @else
                                                @if ($item->price != $item->normal_price)
                                                    <div class="product-discount">
                                                        <span
                                                            class="pe-1">{{ percentage_price($item->price, $item->normal_price) }}</span>
                                                    </div>
                                                @endif
                                            @endif
                                            <div class="product-thumbnail position-relative @if (!empty($item->image_deal)) image-frame1 @endif">
                                                <img src="{{ asset($item->image_first) }}" alt="{{ $item->title }}"
                                                    class="img-fluid">
                                                @if (!empty($item->image_deal))
                                                    <div class="position-absolute top-0 image-frame-top">
                                                        {{-- <img src="{{ asset(preg_replace('/\.(png|jpg|jpeg)$/i', '.webp', $item->image_deal)) }}"
                                                            alt=""> --}}
                                                        <img src="{{ asset( $item->image_deal) }}"
                                                            alt="">
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="product-price">
                                                @if ($item->promotionItem)
                                                    <div class="public-price">
                                                        {{ format_money($item->promotionItem->price) }}</div>
                                                    @if ($item->promotionItem->price != $item->normal_price)
                                                        <div class="origin-price">{{ format_money($item->normal_price) }}
                                                        </div>
                                                    @endif
                                                @else
                                                    <div class="public-price">{{ format_money($item->price) }}</div>
                                                    @if ($item->price != $item->normal_price)
                                                        <div class="origin-price">{{ format_money($item->normal_price) }}
                                                        </div>
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
                            @if ($article->link_cat)
                                <p class="text-center mb-4">
                                    <a href="{{ $article->link_cat }}" class="border rounded p-3 py-2"
                                        style="font-size: 13px">Xem thêm {{ $article->name_cat }} <i
                                            class="fa-solid fa-chevron-right"></i></a>
                                </p>
                            @endif
                            @if ($article->banner_up)
                                <div class="my-3">
                                    <img src="{{ asset($article->banner_up) }}" alt="{{ $article->title }}"
                                        class="img-fluid d-block mx-auto">
                                </div>
                            @endif
                        @endif
                        <div class="toc-content @if (empty($article->has_toc)) d-none @endif" id="left1">
                            <div class="title-toc-blog">
                                Mục lục:
                            </div>
                            <div class="my-toc-blog">
                                <ul id="toc"></ul>
                            </div>
                        </div>
                        <div class="detail-content">
                            {!! replace_image($article->content) !!}
                        </div>
                        @if (!empty($article->content_faq))
                            <div class="faq-for-article">
                                <div class="title-faq">

                                    <span>
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <g clip-path="url(#clip0_407_691)">
                                                <path d="M4 6H2V22H18V20H4V6Z" fill="black" />
                                                <path
                                                    d="M6 2V18H22V2H6ZM13.51 10.16C13.92 9.43 14.69 9 15.14 8.36C15.62 7.68 15.35 6.42 14 6.42C13.12 6.42 12.68 7.09 12.5 7.65L11.13 7.08C11.51 5.96 12.52 5 13.99 5C15.22 5 16.07 5.56 16.5 6.26C16.87 6.86 17.08 7.99 16.51 8.83C15.88 9.76 15.28 10.04 14.95 10.64C14.82 10.88 14.77 11.04 14.77 11.82H13.25C13.26 11.41 13.19 10.74 13.51 10.16ZM12.95 13.95C12.95 13.36 13.42 12.91 14 12.91C14.59 12.91 15.04 13.36 15.04 13.95C15.04 14.53 14.6 15 14 15C13.42 15 12.95 14.53 12.95 13.95Z"
                                                    fill="black" />
                                            </g>
                                            <defs>
                                                <clipPath id="clip0_407_691">
                                                    <rect width="24" height="24" fill="white" />
                                                </clipPath>
                                            </defs>
                                        </svg>
                                        Câu hỏi thường gặp
                                    </span>
                                </div>
                                <div class="detail-content-faq">
                                    {!! $article->content_faq !!}
                                </div>
                            </div>
                        @endif
                        @if ($products_choose_down)
                            <div class="list-product-article mb-4">
                                <div class="title-product-same">
                                    <span>
                                        Một số sản phẩm tương tự
                                    </span>
                                </div>
                                <div class="slide-template-slick">
                                    @forelse($products_choose_down as $item)
                                        <a href="{{ route('detailProduct', ['slug' => !empty($item->slug) ? trim($item->slug) : $item->product->slug, 'sku' => $item->sku]) }}"
                                            class="product-template">
                                            @if ($item->promotionItem)
                                                @if ($item->promotionItem->price != $item->normal_price)
                                                    <div class="product-discount">
                                                        <span
                                                            class="pe-1">{{ percentage_price($item->promotionItem->price, $item->normal_price) }}</span>
                                                    </div>
                                                @endif
                                            @else
                                                @if ($item->price != $item->normal_price)
                                                    <div class="product-discount">
                                                        <span
                                                            class="pe-1">{{ percentage_price($item->price, $item->normal_price) }}</span>
                                                    </div>
                                                @endif
                                            @endif
                                            <div class="product-thumbnail position-relative @if (!empty($item->image_deal)) image-frame1 @endif">
                                                <img src="{{ asset($item->image_first) }}" alt="{{ $item->title }}"
                                                    class="img-fluid">
                                                       @if (!empty($item->image_deal))
                                                    <div class="position-absolute top-0 image-frame-top">
                                                        <img src="{{ asset(preg_replace('/\.(png|jpg|jpeg)$/i', '.webp', $item->image_deal)) }}"
                                                            alt="">
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="product-price">
                                                @if ($item->promotionItem)
                                                    <div class="public-price">
                                                        {{ format_money($item->promotionItem->price) }}</div>
                                                    @if ($item->promotionItem->price != $item->normal_price)
                                                        <div class="origin-price">{{ format_money($item->normal_price) }}
                                                        </div>
                                                    @endif
                                                @else
                                                    <div class="public-price">{{ format_money($item->price) }}</div>
                                                    @if ($item->price != $item->normal_price)
                                                        <div class="origin-price">{{ format_money($item->normal_price) }}
                                                        </div>
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
                        @if ($article->banner_down)
                            <div class="my-3">
                                <img src="{{ asset($article->banner_down) }}" alt="{{ $article->title }}"
                                    class="img-fluid d-block mx-auto">
                            </div>
                        @endif
                        @if ($article_add)
                            <div class="blog-for-article">
                                <div class="title-blog">
                                    <span>
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M5 21C4.45 21 3.97917 20.8042 3.5875 20.4125C3.19583 20.0208 3 19.55 3 19V5C3 4.45 3.19583 3.97917 3.5875 3.5875C3.97917 3.19583 4.45 3 5 3H16L21 8V19C21 19.55 20.8042 20.0208 20.4125 20.4125C20.0208 20.8042 19.55 21 19 21H5ZM5 19H19V9H15V5H5V19ZM7 17H17V15H7V17ZM7 9H12V7H7V9ZM7 13H17V11H7V13Z"
                                                fill="black" />
                                        </svg>
                                        Blog cùng phong cách
                                    </span>
                                </div>
                                <div class="detail-content-blog">
                                    <div class="row">
                                        @foreach ($article_add as $article_item)
                                            <div class="col-md-4">
                                                <a href="{{ route('detailArticle', ['slug' => $article_item->slug, 'id' => $article_item->id]) }}"
                                                    title="{{ $article_item->title }}">
                                                    <img src="{{ asset($article_item->image_change_url) }}"
                                                        alt="{{ $article_item->title }}" class="img-fluid rounded">
                                                    <h4 class="my-3 title-blog-item">{{ $article_item->title }}</h4>
                                                    <div class="summary-blog d-none">
                                                        {!! $article_item->description !!}
                                                    </div>
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif

                    </div>
                </div>

                <div class="layout-relate">
                    <div class="layout-box bg-white">
                        <p class="mb-0 pe-2 ps-2 text-uppercase fw-bold layout-title">Tin tức liên quan</p>
                        @forelse($article_in_cat as $item)
                            <a href="{{ route('detailArticle', ['slug' => $item->slug, 'id' => $item->id]) }}"
                                class="news-item p-2 mb-3">
                                <div class="news-img" title="{{ $item->title }}">
                                    <img src="{{ asset($item->image_change_url) }}" alt="{{ $item->title }}"
                                        class="img-fluid">
                                </div>
                                <div class="news-main">
                                    <p class="news-title fw-bold">{{ $item->title }}</p>
                                    <div class="news-time">
                                        <img src="{{ asset('images/ic-datetime.svg') }}" alt="datetime"
                                            class="img-fluid">
                                        {{ $item->format_date_created }}
                                    </div>
                                    <div class="news-summary">
                                        {{ html_entity_decode(strip_tags($item->description)) }}
                                    </div>
                                </div>
                            </a>
                        @empty
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

    </main>
@endsection

@section('link')
    @parent
    <link rel="stylesheet" href="{{ mix('css/web/article-list.css') }}" data-cfasync="false">
    <link rel="stylesheet" href="{{ mix('css/web/article-detail.css') }}?ver=2.0" data-cfasync="false">
@endsection

@section('script')
    @parent
    <script src="{{ mix('js/web/article-detail.js') }}"></script>
    @include('web.components.extend')
    <script src="{{ asset('/js/web/jquery-3.7.1.min.js') }}" data-cfasync="false"></script>
    <script src="{{ asset('/js/web/jquery.toc.js') }}" data-cfasync="false"></script>
    <script data-cfasync="false">
        $("#toc").toc({
            content: ".layout-main .detail-content",
            headings: "h1,h2,h3,h4"
        });
    </script>
@endsection
