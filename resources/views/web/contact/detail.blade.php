@extends('web.layouts.web')

@section('content')
    <div class="content-detail">
        <div class="container">
            <h1 class="text-center title-contact">{{ $setting['site_name'] }}</h1>
            <div class="row list-contact">
                <div class="col-md-3">
                    <span>
                        <i class="fas fa-map-marker-alt"></i>
                    </span>
                    <p class="title-item-contact">{{ trans('web.main_local') }}</p>
                    <p class="content-contact">{{ $setting['main_local'] }}</p>
                </div>
                <div class="col-md-3">
                    <span><i class="fas fa-phone-alt"></i></span>
                    <p class="title-item-contact">{{ trans('web.phone') }}</p>
                    <p class="content-contact">{{ $setting['hotline'] }}</p>
                </div>
                <div class="col-md-3">
                    <span><i class="fas fa-envelope"></i></span>
                    <p class="title-item-contact">Email</p>
                    <p class="content-contact">{{ $setting['email'] }}</p>
                </div>
                <div class="col-md-3">
                    <span><i class="fas fa-globe"></i></span>
                    <p class="title-item-contact">Website</p>
                    <p class="content-contact">{{ $setting['website'] }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="content-detail-bottom py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6 pe-5">
                    {!! $setting['map_contact'] !!}
                </div>
                <div class="col-md-6 ps-5">
                    {!! $setting['info_contact'] !!}
                    <form action="{{ route('detailContactStore') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @include('web.contact.form')
                        <p class="text-end">
                            <button type="submit" class="btn btn-contact">Gửi liên hệ <i class="fas fa-angle-right"></i></button>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('link')
    @parent
    <link rel="stylesheet" href="{{ mix('css/web/contact.css') }}">
@endsection

@section('script')
    @parent
    <script src="{{ mix('js/app.js') }}"></script>
    @include('web.components.extend')
@endsection
