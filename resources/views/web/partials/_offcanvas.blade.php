<div class="order-now-right">
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-8">
                <div class="offcanvas-header">
                    <h5 id="offcanvasRightLabel">Đặt bàn trước</h5>
                    <button type="button" class="btn-close text-reset position-absolute top-50 start-0 translate-middle" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <p class="des-for-form">Quý khách vui lòng đặt bàn trước 1 giờ để được phục vụ tốt nhất, mọi chi tiết liên hệ: <b>1900 0056 – 0909 911 112</b></p>
                    <form action="{{ route('bookTable') }}" method="post">
                        @csrf
                        <input type="text" class="form-control" placeholder="Họ và tên" name="full_name">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="Số điện thoại" name="phone">
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="Địa chỉ Email" name="email">
                            </div>
                        </div>
                        <select name="store_id" class="form-control">
                            <option value="" selected disabled>Vui lòng chọn cơ sở</option>
                            @if($stores)
                                @forelse($stores as $store)
                                    <option value="{{ $store->id }}">{{ $store->title }}</option>
                                @empty
                                @endforelse
                            @endif
                        </select>
                        <div class="row">
                            <div class="col-md-6">
                                <input type="date" class="form-control" name="book_time">
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <select name="book_hour" id="" required class="form-control">
                                            <option value="Giờ đặt(*):">Giờ đặt(*):</option>
                                            <option value="9h">9h</option>
                                            <option value="9h30">9h30</option>
                                            <option value="10h">10h</option>
                                            <option value="10h30">10h30</option>
                                            <option value="11h">11h</option>
                                            <option value="11h30">11h30</option>
                                            <option value="12h">12h</option>
                                            <option value="12h30">12h30</option>
                                            <option value="13h">13h</option>
                                            <option value="13h30">13h30</option>
                                            <option value="14h">14h</option>
                                            <option value="17h">17h</option>
                                            <option value="17h30">17h30</option>
                                            <option value="18h">18h</option>
                                            <option value="18h30">18h30</option>
                                            <option value="19h">19h</option>
                                            <option value="19h30">19h30</option>
                                            <option value="20h">20h</option>
                                            <option value="20h30">20h30</option>
                                            <option value="21h">21h</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="number" class="form-control" min="1" placeholder="Số khách" name="number_customers">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <textarea name="note" id="" cols="30" rows="4" class="form-control" placeholder="Ghi chú khi đặt bàn"></textarea>
                        <button class="btn btn-order-now" type="submit" >Đặt bàn ngay <i class="fas fa-chevron-right"></i></button>
                    </form>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>

</div>
