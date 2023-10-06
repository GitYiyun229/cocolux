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
                        Review mỹ phẩm
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Review 4 thỏi son Black Rouge đỏ đất được yêu thích nhất
                    </li>
                </ol>
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
                            <a href="" class="product-template">
                                <div class="product-discount">
                                    <span class="pe-1">5%</span>
                                </div>
                                <div class="product-thumbnail">
                                    <img src="{{ asset($item->image) }}" alt=" {{ $item->title }}" class="img-fluid">
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

                        <div class="detail-content">
                            {!! $article->content !!}
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
                                        <img src="./images/ic-datetime.svg" alt="datetime" class="img-fluid">
                                        21/09/2023 09:45:38
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
    <link rel="stylesheet" href="{{ asset('/css/web/article-list.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/web/article-detail.css') }}">
@endsection

@section('script')
    @parent
@endsection
