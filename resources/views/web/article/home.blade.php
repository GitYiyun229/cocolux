@extends('web.layouts.web')

@section('content')
    <div class="top-content-promotion">
        <div class="container">
            <h1 class="title-page">Tin tức</h1>
        </div>
    </div>
    <div class="list-article-home">
        <div class="container">
            <div class="row">
                @php
                    $articleFirst = isset($articles)?$articles[0]:[];
                @endphp
                <div class="col-md-6 position-relative big-article">
                    <div class="article-item">
                        <div class="article-item-content">
                            <a href="{{ route('detailArticle',['slug' => $articleFirst->slug,'id' => $articleFirst->id]) }}" class="image-other-article">
                                @include('web.components.image', ['src' => $articleFirst->image_resize['lager'], 'title' => $articleFirst->title])
                            </a>
                            <div class="box-content-article">
                                <a href="{{ route('detailArticle',['slug' => $articleFirst->slug,'id' => $articleFirst->id]) }}">
                                    <h4 class="title-article title-article-main">{{ $articleFirst->title }}</h4>
                                </a>
                                <p class="calendar-new calendar-new-normal d-flex align-items-center justify-content-between">
                                    <span><i class="far fa-clock"></i> {{ $articleFirst->created_at }}</span>
                                </p>
                                <p class="des-article-related des-article-related-nomal">{{ $articleFirst->description }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 small-article">
                    <div class="row article-list-other">
                        @foreach($articles as $k => $item)
                            @if($k > 0 && $k < 5)
                                <div class="col-md-6 position-relative">
                                    <div class="article-item">
                                        <div class="article-item-content">
                                            <a href="{{ route('detailArticle',['slug' => $item->slug,'id' => $item->id]) }}" class="image-other-article">
                                                @include('web.components.image', ['src' => $item->image_resize['small'], 'title' => $item->title])
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
                            @endif
                        @endforeach
                    </div>
                </div>
                <hr class="my-4 mx-3">
                @foreach($articles as $k => $item)
                    @if($k < 5)
                        <div class="col-md-12 position-relative">
                            <div class="article-item">
                                <div class="article-item-content">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <a href="{{ route('detailArticle',['slug' => $item->slug,'id' => $item->id]) }}" class="image-other-article">
                                                @include('web.components.image', ['src' => $item->image_resize['resize'], 'title' => $item->title])
                                            </a>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="box-content-article">
                                                <a href="{{ route('detailArticle',['slug' => $item->slug,'id' => $item->id]) }}">
                                                    <h4 class="title-article title-article-normal">{{ $item->title }}</h4>
                                                </a>
                                                <p class="calendar-new d-flex align-items-center justify-content-between">
                                                    <span><i class="far fa-clock"></i> {{ $item->created_at }}</span>
                                                </p>
                                                <p class="des-article-related des-article-related-nomal">{{ $item->description }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
            <div class="text-center">
                {{ $articles->links('web.components.pagination') }}
            </div>
        </div>
    </div>
@endsection

@section('link')
    @parent
    <link rel="stylesheet" href="{{ asset('/css/web/news-home.css') }}">
@endsection

@section('script')
    @parent
@endsection
