@extends('web.layouts.web')

@section('content')
    <div class="content-detail">
        <div class="container">
            <div class="box-content-top">
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <p class="title-category text-center">{{ $article->category->title }}</p>
                        <h1 class="title-article">{{ $article->title }}</h1>
                        <div class="time-article d-flex justify-content-between align-items-center">
                            <span><i class="far fa-clock"></i> {{ $article->created_at }}</span>
                            <span class="share-social"></span>
                        </div>
                        <div class="show-content ck-content">
                            {!! $article->content !!}
                        </div>
                    </div>
                    <div class="col-md-2"></div>
                </div>
            </div>
        </div>
        <div class="content-news-related mt-4">
            <div class="container">
                @if($article->category->type === 1)
                    <div class="title-article-other">Ưu đãi hấp dẫn khác</div>
                    <div class="row g-0 mg-for-article">
                        @foreach($articles as $k => $item)
                            <div class="col-md-4 position-relative">
                                <div class="article-item">
                                    <div class="article-item-content">
                                        <a class="d-block overflow-hidden" href="{{ route('detailArticle',['slug' => $item->slug,'id' => $item->id]) }}">
                                            @include('web.components.image', ['src' => $item->image_resize['resize'], 'title' => $item->title])
                                        </a>
                                        <div class="box-content-article">
                                            <a href="{{ route('detailArticle',['slug' => $item->slug,'id' => $item->id]) }}">
                                                <h4 class="title-article">{{ $item->title }}</h4>
                                            </a>
                                            <p class="calendar-new d-flex align-items-center justify-content-between">
                                                <span><i class="fas fa-calendar-alt"></i> {{ $item->created_at }}</span>
                                                <a href="{{ route('detailArticle',['slug' => $item->slug,'id' => $item->id]) }}" class="btn btn-detail-article">
                                                    Chi tiết <i class="fas fa-angle-right"></i>
                                                </a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="title-article-other">có thể bạn quan tâm</div>
                    <div class="row article-list-other">
                        @foreach($articles as $k => $item)
                            <div class="col-md-3 position-relative">
                                <div class="article-item">
                                    <div class="article-item-content">
                                        <a href="{{ route('detailArticle',['slug' => $item->slug,'id' => $item->id]) }}" class="image-other-article">
                                            @include('web.components.image', ['src' => $item->image_resize['resize'], 'title' => $item->title])
                                        </a>
                                        <div class="box-content-article">
                                            <a href="{{ route('detailArticle',['slug' => $item->slug,'id' => $item->id]) }}">
                                                <h4 class="title-article">{{ $item->title }}</h4>
                                            </a>
                                            <p class="calendar-new d-flex align-items-center justify-content-between">
                                                <span><i class="far fa-clock"></i> {{ $item->created_at }}</span>
                                            </p>
                                            <p class="des-article-related">{{ $item->description }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('link')
    @parent
    <link rel="stylesheet" href="{{ asset('/css/web/news-detail.css') }}">
@endsection

@section('script')
    @parent
@endsection
