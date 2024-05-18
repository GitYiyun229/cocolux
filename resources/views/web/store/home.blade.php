@extends('web.layouts.web')
@section('content')
    <div class="top-content-media">
        <div class="container">
            <h1 class="title-page mt-4">hệ thống cửa hàng</h1>
        </div>
    </div>
    <div class="list-store-home ">
        <div class="container">
            <div class="row py-5">
                <div class="col-md-3">
                    <div class="filter-showroom">
                        <select name="province" id="province" class="select_box form-control">
                            <option value="">--Tỉnh Thành--</option>
                            @forelse($cities as $city)
                                <option value="{{ $city->code }}">{{ $city->name }}</option>
                            @empty


                            @endforelse
                        </select>
                    </div>
                    <div class="list-stores custom-max-height">
                        <ul class="nav-tabs menuScroll" id="myTab-cat">
                            @forelse ($stores as $k => $item)
                                <li data-id="profile-cat-{{ $item->province }}"
                                    class="navScroll {{ $k == 0 ? 'active' : '' }}">
                                    <p class="name-showroom">
                                        {{ $item->title }}
                                    </p>
                                    <p class="address">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M9 9.75C10.2426 9.75 11.25 8.74264 11.25 7.5C11.25 6.25736 10.2426 5.25 9 5.25C7.75736 5.25 6.75 6.25736 6.75 7.5C6.75 8.74264 7.75736 9.75 9 9.75Z"
                                                stroke="black" stroke-opacity="0.38" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path
                                                d="M9 16.5C12 13.5 15 10.8137 15 7.5C15 4.18629 12.3137 1.5 9 1.5C5.68629 1.5 3 4.18629 3 7.5C3 10.8137 6 13.5 9 16.5Z"
                                                stroke="black" stroke-opacity="0.38" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                        <span>
                                            {{ $item->address }}
                                        </span>
                                    </p>
                                    <p class="hotline">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M6.28325 6.63992C6.80525 7.72714 7.51684 8.74612 8.41803 9.6473C9.31921 10.5485 10.3382 11.2601 11.4254 11.7821C11.5189 11.827 11.5657 11.8494 11.6249 11.8667C11.8351 11.928 12.0933 11.8839 12.2714 11.7564C12.3215 11.7206 12.3644 11.6777 12.4501 11.5919C12.7123 11.3297 12.8434 11.1986 12.9752 11.1129C13.4724 10.7897 14.1133 10.7897 14.6105 11.1129C14.7423 11.1986 14.8734 11.3297 15.1356 11.592L15.2818 11.7381C15.6804 12.1367 15.8797 12.336 15.9879 12.55C16.2032 12.9757 16.2032 13.4784 15.9879 13.9041C15.8797 14.1181 15.6804 14.3174 15.2818 14.716L15.1636 14.8342C14.7664 15.2314 14.5677 15.43 14.2977 15.5817C13.9981 15.75 13.5327 15.871 13.1891 15.87C12.8793 15.8691 12.6677 15.809 12.2443 15.6889C9.9693 15.0431 7.82253 13.8248 6.03154 12.0338C4.24056 10.2428 3.0222 8.09603 2.37647 5.82098C2.25632 5.39765 2.19624 5.18598 2.19532 4.87627C2.1943 4.53261 2.31532 4.06724 2.48363 3.76761C2.63532 3.49758 2.83393 3.29898 3.23114 2.90176L3.34937 2.78353C3.74795 2.38495 3.94724 2.18566 4.16128 2.0774C4.58695 1.8621 5.08965 1.8621 5.51532 2.0774C5.72936 2.18566 5.92865 2.38495 6.32723 2.78353L6.47338 2.92968C6.73559 3.19189 6.86669 3.32299 6.9524 3.45482C7.27565 3.95199 7.27565 4.59293 6.9524 5.0901C6.86669 5.22193 6.73559 5.35303 6.47338 5.61524C6.38765 5.70097 6.34478 5.74384 6.3089 5.79395C6.18139 5.97202 6.13736 6.23021 6.19866 6.44048C6.2159 6.49965 6.23835 6.54641 6.28325 6.63992Z"
                                                stroke="black" stroke-opacity="0.38" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                        <span>
                                            {{ $item->phone }}
                                        </span>
                                    </p>
                                </li>
                            @empty
                            @endforelse
                        </ul>

                    </div>
                </div>
                <div class="col-md-9">
                      <div class="showroom-title-under">

        </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('link')
    @parent
    <link rel="stylesheet" href="{{ mix('css/web/store-home.css') }}">
@endsection

@section('script')
    @parent
  <script src="{{ mix('js/web/show-room.js') }}"></script>
    <script>

    </script>
@endsection
