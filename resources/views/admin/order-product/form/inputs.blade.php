<div class="row">
    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-6">
                <!-- text input -->
                <div class="form-group">
                    <label>@lang('form.order-product.name')</label>
                    <input type="text" class="form-control" name="name" value="{{ isset($order) ? $order->name : old('name') }}" required readonly>
                    @if ($errors->has('name'))
                        <span class="help-block text-danger">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
                    @endif
                </div>
            </div>
            <div class="col-sm-6">
                <!-- text input -->
                <div class="form-group">
                    <label>@lang('form.order-product.tel')</label>
                    <input type="text" class="form-control" name="tel" value="{{ isset($order) ? $order->tel : old('tel') }}" readonly required>
                    @if ($errors->has('tel'))
                        <span class="help-block text-danger">
                    <strong>{{ $errors->first('tel') }}</strong>
                </span>
                    @endif
                </div>
            </div>
            <div class="col-sm-6">
                <!-- text input -->
                <div class="form-group">
                    <label>@lang('form.order-product.city_name')</label>
                    <input type="text" class="form-control" name="city_name" value="{{ isset($order) ? $order->city_name : old('city_name') }}" readonly required>
                    @if ($errors->has('city_name'))
                        <span class="help-block text-danger">
                    <strong>{{ $errors->first('city_name') }}</strong>
                </span>
                    @endif
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>@lang('form.order-product.district_name')</label>
                    <input type="text" class="form-control" name="district_name" value="{{ isset($order) ? $order->district_name : old('district_name') }}" readonly required>
                    @if ($errors->has('district_name'))
                        <span class="help-block text-danger">
                    <strong>{{ $errors->first('district_name') }}</strong>
                </span>
                    @endif
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>@lang('form.order-product.ward_name')</label>
                    <input type="text" class="form-control" name="ward_name" value="{{ isset($order) ? $order->ward_name : old('ward_name') }}" readonly required>
                    @if ($errors->has('ward_name'))
                        <span class="help-block text-danger">
                    <strong>{{ $errors->first('ward_name') }}</strong>
                </span>
                    @endif
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>@lang('form.order-product.address')</label>
                    <input type="text" class="form-control" name="address" value="{{ isset($order) ? $order->address : old('address') }}" readonly required>
                    @if ($errors->has('address'))
                        <span class="help-block text-danger">
                    <strong>{{ $errors->first('address') }}</strong>
                </span>
                    @endif
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group clearfix">
                    <label>Hình thức thanh toán</label>
                    <div class="form-group">
                        <div class="icheck-success d-inline">
                            <input class="" type="radio" id="statusRadio1" name="payment" readonly value="{{ \App\Models\Article::STATUS_ACTIVE }}" {{ (isset($order->payment) && $order->payment == \App\Models\Article::STATUS_ACTIVE) ? 'checked' : (old('payment') && (old('payment') == \App\Models\Article::STATUS_ACTIVE)) ? 'checked' : '' }} disabled required>
                            <label for="statusRadio1" class="custom-control-label">Thanh toán khi nhận hàng&nbsp;&nbsp;&nbsp;&nbsp;</label>
                        </div>
                        <div class="icheck-success d-inline">
                            <input class="" type="radio" id="statusRadio2" name="payment" readonly value="{{ \App\Models\Article::STATUS_INACTIVE }}" {{ (isset($order) && $order->payment == \App\Models\Article::STATUS_INACTIVE) ? 'checked' : (old('payment') && (old('payment') == \App\Models\Article::STATUS_INACTIVE)) ? 'checked' : '' }} disabled required>
                            <label for="statusRadio2" class="custom-control-label">Thanh toán chuyển khoản</label>
                        </div>
                    </div>
                    @if ($errors->has('payment'))
                        <span class="help-block text-danger">
                    <strong>{{ $errors->first('payment') }}</strong>
                </span>
                    @endif
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group clearfix">
                    <label>Trạng thái đơn hàng</label>
                    <select name="status" id="status" class="form-control" required>
                        @forelse( \App\Models\Order::STATUS as $key => $name)
                            <option value="{{ $key }}" {{ isset($order->status) && $order->status == $key ? 'selected' : old('status') == $key ? 'selected' : '' }}>{{ $name }}</option>
                        @empty
                        @endforelse
                    </select>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>@lang('form.order-product.note')</label>
                    <textarea name="note" id="note" rows="3" class="form-control" readonly>
                        {{ isset($order) ? $order->note : old('note') }}
                    </textarea>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>@lang('form.order-product.coco_note')</label>
                    <textarea name="coco_note" id="coco_note" rows="3" class="form-control">{{ isset($order) ? $order->coco_note : old('coco_note') }}</textarea>
                </div>
            </div>
        </div>
    </div>
</div>
<hr>
<table class="table table-bordered mt-2" id="list_products">
    <thead class="thead-light">
    <tr>
        <th style="width: 100px;">SKU</th>
        <th style="width: 280px;">Tên sản phẩm</th>
        <th style="width: 100px;">Giá</th>
        <th style="width: 100px;">Số lượng</th>
    </tr>
    </thead>
    <tbody id="table-body">
    @if(!empty($products))
        @forelse($products as $k => $item)
            <tr>
                <td>{{ $item->productOption->sku }}</td>
                <td><a href="{{ (!empty($item->productOption->slug) && !empty($item->productOption->sku))?route('detailProduct',['slug' => $item->productOption->slug,'sku'=>$item->productOption->sku]):'' }}" target="_blank">{{ $item->product_title }}</a></td>
                <td>{{ format_money($item->product_price) }}</td>
                <td>{{ $item->product_number }}</td>
            </tr>
        @empty
        @endforelse
    @endif
    </tbody>
</table>
<div class="row">
    <div class="col-md-8 text-right text-bold">Tổng tạm tính: </div>
    <div class="col-md-4">{{ format_money($total_money) }}</div>
    <div class="col-md-8 text-right text-bold">Phí ship: </div>
    <div class="col-md-4">{{ $order->price_ship_coco?format_money($order->price_ship_coco):0 }}</div>
    @if($order->coupon && $order->price_coupon_now)
    <div class="col-md-8 text-right text-bold">Mã giảm giá (nếu có): </div>
    <div class="col-md-4">
        <p style="margin-bottom: 0">(Mã áp dụng: {{ $order->coupon }})</p>
        -{{ $order->price_coupon_now?format_money($order->price_coupon_now):0 }}
    </div>
    @endif
    <div class="col-md-8 text-right text-bold">Tổng tiền: </div>
    <div class="col-md-4">{{ format_money($total_money + $order->price_ship_coco - $order->price_coupon_now) }}</div>
</div>
@section('link')
    @parent
@endsection

@section('script')
    @parent
@endsection
