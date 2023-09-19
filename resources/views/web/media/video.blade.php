@extends('web.layouts.web')

@section('content')
    <div class="top-content-media">
        <div class="container">
            <h1 class="title-page">Thư viện</h1>
            <ul class="list-menu-page list-unstyled">
                <li>
                    <a href="{{ route('album') }}" >Hình ảnh</a>
                </li>
                <li>
                    <a href="{{ route('video') }}" class="active">Video</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="list-news-home">
        <div class="container">
            <div class="row g-0 mg-for-article">
                @foreach($videos as $k => $item)
                    <div class="col-md-4 position-relative" id="video-gallery-{{ $item->id }}">
                        <div class="article-item video" data-poster="{{ asset($item->image) }}" data-src="{{ $item->link_video }}"
                             data-sub-html="{{$item->title}}" >
                            <a href="">
                                <div class="article-item-content">
                                    <div class="image-video">
                                        @include('web.components.image', ['src' => $item->image_resize['resize'], 'title' => $item->title])
                                        <img src="{{ asset('images/Youtube.png') }}" alt="" class="play-youtube-video  top-50 start-50 translate-middle">
                                    </div>
                                    <div class="box-content-article">
                                        <h4 class="title-article">{{ $item->title }}</h4>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            {{ $videos->links('web.components.pagination') }}
        </div>
    </div>
@endsection

@section('link')
    @parent
    <link rel="stylesheet" href="{{ asset('/css/lightgallery/lightgallery.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/web/album-home.css') }}">
@endsection

@section('script')
    @parent
    <script src="{{ asset('js/web/lightgallery/lightgallery.js') }}"></script>
    <script src="{{ asset('js/web/lightgallery/lg-thumbnail.js') }}"></script>
    <script src="{{ asset('js/web/lightgallery/lg-fullscreen.js') }}"></script>
    <script src="{{ asset('js/web/lightgallery/lg-autoplay.js') }}"></script>
    <script src="{{ asset('js/web/lightgallery/lg-video.js') }}"></script>
    <script>
        // $('#category-list .article-item-content').click(function() {
        //     var category = $(this).data('category');
        //     $('#image-gallery-'+category+' a:first-child').click();
        // });
        @foreach($videos as $k => $item)
            $('#video-gallery-{{ $item->id }}').lightGallery();
        @endforeach
    </script>
@endsection
