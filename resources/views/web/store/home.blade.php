@extends('web.layouts.web')

@section('content')
    <div class="top-content-media">
        <div class="container">
            <h1 class="title-page">hệ thống cửa hàng</h1>
        </div>
    </div>
    <div class="list-store-home">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div id="map">
                        <div id="gmap" style="width: 100%; height: 600px;"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="search mb-3">
                        <form action="#" method="post" name="search_agency" id="search_agency">
                            <div class="row g-2">
                                <div class="col-md-5">
                                    <select name="province" id="province" class="select_box form-control">
                                        <option value="">--Tỉnh Thành--</option>
                                        @forelse($cities as $city)
                                            <option value="{{ $city->id }}">{{ $city->name }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                                <div class="col-md-7">
                                    <div class="position-relative">
                                        <input type="text" name="keyword" id="keyword" class="form-control job-typeahead" placeholder="Tìm kiếm cửa hàng...">
                                        <button type="submit" class="btn btn-danger btn-search-all position-absolute top-50 end-0 translate-middle-y"><i class="fa fa-search" aria-hidden="true"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="list-stores">
                        @php
                            $json2 ='[';
                            $json_names_2 = array();
                        @endphp
                        @forelse($stores as $k => $store)
                            @if(!empty($store))
                                @php
                                    $json_names_2[] = "['" . $store->title . "'," . $store->latitude . "," . $store->longitude . ",13,'". $store->address ."']";
                                @endphp
                            @endif
                            <div class="item-store">
                                <div class="title-store">
                                    <a href="">
                                        {{ $store->title }}
                                    </a>
                                </div>
                                <ul class="address-phone list-unstyled">
                                    <li>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                                            <path d="M9 9.75C10.2426 9.75 11.25 8.74264 11.25 7.5C11.25 6.25736 10.2426 5.25 9 5.25C7.75736 5.25 6.75 6.25736 6.75 7.5C6.75 8.74264 7.75736 9.75 9 9.75Z" stroke="#938D8D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M9 16.5C12 13.5 15 10.8137 15 7.5C15 4.18629 12.3137 1.5 9 1.5C5.68629 1.5 3 4.18629 3 7.5C3 10.8137 6 13.5 9 16.5Z" stroke="#938D8D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>{{ $store->address }}
                                    </li>
                                    <li>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                                            <path d="M6.28521 6.63992C6.80721 7.72714 7.5188 8.74612 8.41998 9.6473C9.32116 10.5485 10.3401 11.2601 11.4274 11.7821C11.5209 11.827 11.5676 11.8494 11.6268 11.8667C11.8371 11.928 12.0953 11.8839 12.2733 11.7564C12.3234 11.7206 12.3663 11.6777 12.452 11.5919C12.7143 11.3297 12.8454 11.1986 12.9772 11.1129C13.4744 10.7897 14.1153 10.7897 14.6125 11.1129C14.7443 11.1986 14.8754 11.3297 15.1376 11.592L15.2838 11.7381C15.6823 12.1367 15.8816 12.336 15.9899 12.55C16.2052 12.9757 16.2052 13.4784 15.9899 13.9041C15.8816 14.1181 15.6823 14.3174 15.2838 14.716L15.1655 14.8342C14.7683 15.2314 14.5697 15.43 14.2997 15.5817C14 15.75 13.5347 15.871 13.191 15.87C12.8813 15.8691 12.6696 15.809 12.2463 15.6889C9.97125 15.0431 7.82448 13.8248 6.0335 12.0338C4.24251 10.2428 3.02415 8.09603 2.37843 5.82098C2.25827 5.39765 2.19819 5.18598 2.19727 4.87627C2.19625 4.53261 2.31727 4.06724 2.48559 3.76761C2.63727 3.49758 2.83588 3.29898 3.2331 2.90176L3.35132 2.78353C3.74991 2.38495 3.9492 2.18566 4.16323 2.0774C4.5889 1.8621 5.0916 1.8621 5.51727 2.0774C5.73131 2.18566 5.9306 2.38495 6.32918 2.78353L6.47533 2.92968C6.73754 3.19189 6.86864 3.32299 6.95436 3.45482C7.2776 3.95199 7.2776 4.59293 6.95435 5.0901C6.86864 5.22193 6.73754 5.35303 6.47533 5.61524C6.3896 5.70097 6.34673 5.74384 6.31085 5.79395C6.18334 5.97202 6.13932 6.23021 6.20061 6.44048C6.21786 6.49965 6.24031 6.54641 6.28521 6.63992Z" stroke="#938D8D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <b>{{ $store->phone }}</b>
                                    </li>
                                </ul>
                            </div>
                        @empty
                        @endforelse
                        @php
                            $json2 .= implode(',', $json_names_2);
                            $json2 .=']';
                        @endphp
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('link')
    @parent
    <link rel="stylesheet" href="{{ asset('/css/web/store-home.css') }}">
@endsection

@section('script')
    @parent
    <script type='text/javascript' src='https://www.bing.com/api/maps/mapcontrol?callback=GetMap&key=Apwotc2pglOqY_bLannByqBGVxp6nHjH6ZGhPsTBOyfdyHbaJZnV87ozNmjKBdlF&mkt=vi-VN' async defer></script>
    <script>
        function GetMap() {
            var locations = <?php echo $json2 ?>;
            var pinInfobox; //the pop up info box
            var infoboxLayer = new Microsoft.Maps.EntityCollection();
            var pinLayer = new Microsoft.Maps.EntityCollection();
            var apiKey = "Apwotc2pglOqY_bLannByqBGVxp6nHjH6ZGhPsTBOyfdyHbaJZnV87ozNmjKBdlF";
            var map = new Microsoft.Maps.Map(document.getElementById("gmap"), { credentials: apiKey });

            pinInfobox = new Microsoft.Maps.Infobox(new Microsoft.Maps.Location(0, 0), { visible: false });
            infoboxLayer.push(pinInfobox);

            for (var i = 0; i < locations.length; i++) {
                // Tạo vị trí và biểu tượng tùy chỉnh
                var latLon = new Microsoft.Maps.Location(locations[i][1], locations[i][2]);
                var customIcon = new Microsoft.Maps.Pushpin(latLon, {
                    icon: '{{ asset('images/point_map.svg') }}', // Đường dẫn tới hình ảnh biểu tượng
                    anchor: new Microsoft.Maps.Point(39, 56), // Điểm neo của biểu tượng (thường là giữa dưới)
                    width: 39, // Chiều rộng của biểu tượng
                    height: 56, // Chiều cao của biểu tượng
                });

                customIcon.Title = locations[i][0]; //usually title of the infobox
                customIcon.Description = locations[i][4]; //information you want to display in the infobox
                pinLayer.push(customIcon); //add pushpin to pinLayer
                Microsoft.Maps.Events.addHandler(customIcon, 'click', displayInfobox);
            }
            function displayInfobox(e) {
                // Tạo và hiển thị nội dung thông tin trong một Infobox
                var infobox = new Microsoft.Maps.Infobox(e.target.getLocation(), {
                    title: e.target.Title,
                    description: e.target.Description,
                    visible: true,
                });
                map.entities.push(infobox);
            }
            map.entities.push(pinLayer); // Thêm pinLayer thay vì customIcon
            map.entities.push(infoboxLayer);
            map.setView({ zoom: 7, center: new Microsoft.Maps.Location({{ isset($latitude)?$latitude:'20.90306' }}, {{ isset($longitude)?$longitude:'106.80669' }}) });
        }



        function displayInfobox(e)
        {
            pinInfobox.setOptions({title: e.target.Title, description: e.target.Description, visible:true, offset: new Microsoft.Maps.Point(0,25)});
            pinInfobox.setLocation(e.target.getLocation());
        }

        function hideInfobox(e)
        {
            pinInfobox.setOptions({ visible: false });
        }
    </script>
@endsection
