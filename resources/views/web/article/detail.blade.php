@extends('web.layouts.web')

@section('content')
    <main>

        <div class="container">
            <nav aria-label="breadcrumb" class="pt-3 pb-3 mb-4">
                {{ Breadcrumbs::render('detailArticle', $parent_cat,$article) }}
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
                            @if(count($parent->children) > 0)
                                @forelse($parent->children as $child)
                                    <a href="{{ route('catArticle', ['slug' => $child->slug, 'id' => $child->id]) }}" class="category-item @if ($article->category->id == $child->id) active fw-bold @endif level-1">{{ $child->title }}</a>
                                @empty
                                @endforelse
                            @endif
                        @empty
                        @endforelse
                    </div>

                    <div class="products-hot layout-box bg-white">
                        <p class="mb-0 text-center text-uppercase fw-bold layout-title text-red">Sản phẩm hot</p>
                        @forelse($product_hots as $item)
                            <a href="{{ route('detailProduct',['slug'=> !empty($item->slug)?trim($item->slug):$item->product->slug, 'sku' =>$item->sku]) }}" class="product-template">
                                @if($item->flash_deal && in_array($item->flash_deal->id,$promotions_flash_id))
                                    @if($item->flash_deal->price != $item->normal_price)
                                        <div class="product-discount">
                                            <span class="pe-1">{{ percentage_price($item->flash_deal->price, $item->normal_price) }}</span>
                                        </div>
                                    @endif
                                @elseif($item->hot_deal && in_array($item->hot_deal->id,$promotions_hot_id))
                                    @if($item->hot_deal->price != $item->normal_price)
                                        <div class="product-discount">
                                            <span class="pe-1">{{ percentage_price($item->hot_deal->price, $item->normal_price) }}</span>
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
                                    @if($item->flash_deal && in_array($item->flash_deal->id,$promotions_flash_id))
                                        <div class="public-price">{{ format_money($item->flash_deal->price) }}</div>
                                        @if($item->flash_deal->price != $item->normal_price)
                                            <div class="origin-price">{{ format_money($item->normal_price) }}</div>
                                        @endif
                                    @elseif($item->hot_deal && in_array($item->hot_deal->id,$promotions_hot_id))
                                        <div class="public-price">{{ format_money($item->hot_deal->price) }}</div>
                                        @if($item->hot_deal->price != $item->normal_price)
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

                <div class="layout-main">
                    <div class="layout-main-detail layout-box layout-padding bg-white">
                        <h1 class="detail-title text-center fw-bold mb-4">
                            {{ $article->title }}
                        </h1>

                        <div class="detail-summary">
                            {{ $article->description }}
                        </div>
                        @if($products_choose)
                        <div class="list-product-article mb-4">
                            <div class="slide-template-slick">
                                @forelse($products_choose as $item)
                                    <a href="{{ route('detailProduct',['slug'=> !empty($item->slug)?trim($item->slug):$item->product->slug, 'sku' =>$item->sku]) }}" class="product-template">
                                        @if($item->flash_deal && in_array($item->flash_deal->id,$promotions_flash_id))
                                            @if($item->flash_deal->price != $item->normal_price)
                                                <div class="product-discount">
                                                    <span class="pe-1">{{ percentage_price($item->flash_deal->price, $item->normal_price) }}</span>
                                                </div>
                                            @endif
                                        @elseif($item->hot_deal && in_array($item->hot_deal->id,$promotions_hot_id))
                                            @if($item->hot_deal->price != $item->normal_price)
                                                <div class="product-discount">
                                                    <span class="pe-1">{{ percentage_price($item->hot_deal->price, $item->normal_price) }}</span>
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
                                            @if($item->flash_deal && in_array($item->flash_deal->id,$promotions_flash_id))
                                                <div class="public-price">{{ format_money($item->flash_deal->price) }}</div>
                                                @if($item->flash_deal->price != $item->normal_price)
                                                    <div class="origin-price">{{ format_money($item->normal_price) }}</div>
                                                @endif
                                            @elseif($item->hot_deal && in_array($item->hot_deal->id,$promotions_hot_id))
                                                <div class="public-price">{{ format_money($item->hot_deal->price) }}</div>
                                                @if($item->hot_deal->price != $item->normal_price)
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
                        <div class="toc-content @if(empty($article->has_toc)) d-none @endif" id="left1">
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
                    </div>
                </div>

                <div class="layout-relate">
                    <div class="layout-box bg-white">
                        <p class="mb-0 pe-2 ps-2 text-uppercase fw-bold layout-title">Tin tức liên quan</p>
                        @forelse($article_hot as $item)
                            <a href="{{ route('detailArticle',['slug'=>$item->slug,'id'=>$item->id]) }}" class="news-item p-2 mb-3">
                                <div class="news-img" title="{{ $item->title }}">
                                    <img src="{{ asset($item->image_change_url) }}" alt="{{ $item->title }}" class="img-fluid">
                                </div>
                                <div class="news-main">
                                    <p class="news-title fw-bold">{{ $item->title }}</p>
                                    <div class="news-time">
                                        <img src="{{ asset('images/ic-datetime.svg') }}" alt="datetime" class="img-fluid">
                                        {{ $item->format_date_created }}
                                    </div>
                                    <div class="news-summary">
                                        {{ $item->description }}
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
    <link href="{{ asset('js/web/slick/slick.css') }}" rel="stylesheet">
    <link href="{{ asset('js/web/slick/slick-theme.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/css/web/article-list.css') }}" data-cfasync="false">
    <link rel="stylesheet" href="{{ asset('/css/web/article-detail.css') }}" data-cfasync="false">
@endsection

@section('script')
    @parent
    <script src="{{ asset('/js/web/jquery-3.7.1.min.js') }}" data-cfasync="false"></script>
    <script src="{{ asset('/js/web/jquery.toc.js') }}" data-cfasync="false"></script>
    <script src="{{ asset('/js/web/slick/slick.js') }}" data-cfasync="false"></script>
    <script data-cfasync="false">
        $("#toc").toc({content: ".layout-main .detail-content", headings: "h1,h2,h3,h4"});
        $('.slide-template-slick').slick({
            slidesToShow: 4,
            slidesToScroll: 4,
            arrows: true,
            dots: false,
            infinite: true,
            autoplay: true,
            responsive: [
                {
                    breakpoint: 960,
                    settings: {
                        slidesToShow: 2.5,
                        slidesToScroll: 2
                    }
                }
            ]
        });
    </script>
@endsection
