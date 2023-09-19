@extends('web.layouts.web')

@section('content')
    <div class="top-content-promotion">
        <div class="container">
            <h1 class="title-page">Ưu đãi nổi bật</h1>
        </div>
    </div>
    <div class="list-news-home">
        <div class="container">
            <div class="row g-0">
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
