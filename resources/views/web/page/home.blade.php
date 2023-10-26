@extends('web.layouts.web')

@section('content')
<main>
    <div class="container">
        <nav aria-label="breadcrumb" class="pt-3 pb-3 mb-4">
            {{ Breadcrumbs::render('detailPage', $page) }}
        </nav>

        <div class="layout-page-content mb-5">
            <div class="layout-menu">
                @forelse($list_page as $item)
                <div class="group-menu mb-5">
                    <p class="title text-uppercase mb-0">{{ $item->name }}</p>
                    @if($item->pages)
                        @forelse($item->pages as $value)
                            <a href="{{ ($item->slug == 'thong-tin')? route('detailPage',['slug' => $value->slug]):($item->slug == 'hoi-dap')? route('detailPageQa',['slug' => $value->slug]):'' }}" class="">{{ $value->title }}</a>
                        @empty
                        @endforelse
                    @endif
                </div>
                @empty
                @endforelse
            </div>
            <div class="layout-main">
                {!! $page->content !!}
            </div>
        </div>
    </div>

</main>
@endsection

@section('link')
@parent
<link rel="stylesheet" href="{{ asset('/css/web/content.css') }}">
@endsection

@section('script')
@parent
@endsection
