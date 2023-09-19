<footer class="main-footer text-light">
    <div class="top-footer py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-7">
                            <img src="{{ asset($setting['logo_footer']) }}" alt="{{ $setting['title'] }}" class="img-fluid logo-fs mb-4">
                            <div class="list_infor_ft">
                                {!! $setting['footer_info'] !!}
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="info-ft-phone">
                                <p>Hotline</p>
                                <span>{!! $setting['hotline'] !!}</span>
                            </div>
                            <div class="info-ft-phone">
                                <p>Giờ mở cửa</p>
                                <span class="open-store">{!! $setting['time_work'] !!}</span>
                            </div>
                            <button class="btn btn-order" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">Đặt bàn ngay <i class="fas fa-chevron-right"></i></button>
                        </div>
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="text-center menu-bottom-ft">
                                <div class="title-menu-bt">Liên kết nhanh</div>
                                <ul class="list-unstyled list-item-menu-bt">
                                    <li><a href="">Liên hệ</a></li>
                                    <li><a href="">Thực đơn</a></li>
                                    <li><a href="">Khuyến mại</a></li>
                                    <li><a href="">Đặt bàn</a></li>
                                    <li><a href="">Câu hỏi thường gặp</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="fb-page" data-href="https://www.facebook.com/giakhanhhotpot" data-tabs="" data-width="" data-height="" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/giakhanhhotpot" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/giakhanhhotpot">Lẩu Nấm Gia Khánh</a></blockquote></div>
                            <div class="link-to-restaurant">
                                <a href="{{ route('store') }}" class="btn btn-store"><i class="fas fa-map-marker-alt"></i> Hệ thống nhà hàng</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
