<div class="row">
    <div class="col-sm-7">
        <div class="row">
            <div class="col-sm-6">
                <!-- text input -->
                <div class="form-group">
                    <label>@lang('form.voucher.name')</label> <span class="text-danger">*</span>
                    <input type="text" class="form-control" name="name" value="{{ isset($voucher) ? $voucher->name : old('name') }}" required>
                    @if ($errors->has('name'))
                        <span class="help-block text-danger">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
                    @endif
                </div>
            </div>
            <div class="col-sm-6">
                <!-- text input -->
                <div class="form-group clearfix">
                    <label>@lang('form.status.active')</label> <span class="text-danger">*</span>
                    <div class="form-group">
                        <div class="icheck-success d-inline">
                            <input class="" type="radio" id="statusRadio1" name="active" value="{{ \App\Models\Voucher::STATUS_ACTIVE }}" {{ (isset($voucher->active) && $voucher->active == \App\Models\Voucher::STATUS_ACTIVE) ? 'checked' : (old('active') && (old('active') == \App\Models\Voucher::STATUS_ACTIVE)) ? 'checked' : '' }}  required>
                            <label for="statusRadio1" class="custom-control-label">@lang('form.status.active')&nbsp;&nbsp;&nbsp;&nbsp;</label>
                        </div>
                        <div class="icheck-danger d-inline">
                            <input class="" type="radio" id="statusRadio2" name="active" value="{{ \App\Models\Voucher::STATUS_INACTIVE }}" {{ (isset($voucher) && $voucher->active == \App\Models\Voucher::STATUS_INACTIVE) ? 'checked' : (old('active') && (old('active') == \App\Models\Voucher::STATUS_INACTIVE)) ? 'checked' : '' }} required>
                            <label for="statusRadio2" class="custom-control-label">@lang('form.status.inactive')</label>
                        </div>
                    </div>
                    @if ($errors->has('active'))
                        <span class="help-block text-danger">
                    <strong>{{ $errors->first('active') }}</strong>
                </span>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <!-- text input -->
                <div class="form-group">
                    <label>@lang('form.voucher.start_date')</label> <span class="text-danger">*</span>
                    <input type="date" class="form-control" name="start_date" value="{{ isset($voucher) ? $voucher->start_date : old('start_date') }}" readonly>
                    @if ($errors->has('start_date'))
                        <span class="help-block text-danger">
                    <strong>{{ $errors->first('start_date') }}</strong>
                </span>
                    @endif
                </div>
            </div>
            <div class="col-sm-6">
                <!-- text input -->
                <div class="form-group">
                    <label>@lang('form.voucher.end_date')</label> <span class="text-danger">*</span>
                    <input type="date" class="form-control" name="end_date" value="{{ isset($voucher) ? $voucher->end_date : old('end_date') }}" readonly>
                    @if ($errors->has('end_date'))
                        <span class="help-block text-danger">
                    <strong>{{ $errors->first('end_date') }}</strong>
                </span>
                    @endif
                </div>
            </div>
            <div class="col-sm-6">
                <!-- text input -->
                <div class="form-group">
                    <label>@lang('form.voucher.from_value')</label> <span class="text-danger">*</span>
                    <input type="text" class="form-control" name="from_value" value="{{ isset($voucher) ? $voucher->from_value : old('from_value') }}" readonly>
                    @if ($errors->has('from_value'))
                        <span class="help-block text-danger">
                    <strong>{{ $errors->first('from_value') }}</strong>
                </span>
                    @endif
                </div>
            </div>
            <div class="col-sm-6">
                <!-- text input -->
                <div class="form-group">
                    <label>@lang('form.voucher.number_of_codes')</label> <span class="text-danger">*</span>
                    <input type="text" class="form-control" name="number_of_codes" value="{{ isset($voucher) ? $voucher->number_of_codes : old('number_of_codes') }}" readonly>
                    @if ($errors->has('number_of_codes'))
                        <span class="help-block text-danger">
                    <strong>{{ $errors->first('number_of_codes') }}</strong>
                </span>
                    @endif
                </div>
            </div>
            <div class="col-sm-6">
                <!-- text input -->
                <div class="form-group">
                    <label>@lang('form.voucher.total_used_time')</label> <span class="text-danger">*</span>
                    <input type="text" class="form-control" name="total_used_time" value="{{ isset($voucher) ? $voucher->total_used_time : old('total_used_time') }}" readonly>
                    @if ($errors->has('total_used_time'))
                        <span class="help-block text-danger">
                    <strong>{{ $errors->first('total_used_time') }}</strong>
                </span>
                    @endif
                </div>
            </div>
            <div class="col-sm-6">
                <!-- text input -->
                <div class="form-group clearfix">
                    <label>@lang('form.status.value_type')</label> <span class="text-danger">*</span>
                    <div class="form-group">
                        <div class="icheck-success d-inline">
                            <input class="" type="radio" id="value_typeRadio1" name="value_type" value="{{ \App\Models\Voucher::VOUCHER_TYPE }}" {{ (isset($voucher->value_type) && $voucher->value_type == \App\Models\Voucher::STATUS_ACTIVE) ? 'checked' : (old('value_type') && (old('value_type') == \App\Models\Voucher::VOUCHER_TYPE)) ? 'checked' : '' }}  required>
                            <label for="value_typeRadio1" class="custom-control-label">Tiền mặt&nbsp;&nbsp;&nbsp;&nbsp;</label>
                        </div>
                        <div class="icheck-danger d-inline">
                            <input class="" type="radio" id="value_typeRadio2" name="value_type" value="{{ \App\Models\Voucher::VOUCHER_TYPE_P }}" {{ (isset($voucher) && $voucher->value_type == \App\Models\Voucher::VOUCHER_TYPE_P) ? 'checked' : (old('value_type') && (old('value_type') == \App\Models\Voucher::VOUCHER_TYPE_P)) ? 'checked' : '' }} required>
                            <label for="value_typeRadio2" class="custom-control-label">Phần trăm</label>
                        </div>
                    </div>
                    @if ($errors->has('value_type'))
                        <span class="help-block text-danger">
                    <strong>{{ $errors->first('value_type') }}</strong>
                </span>
                    @endif
                </div>
            </div>
            <div class="col-sm-6">
                <!-- text input -->
                <div class="form-group">
                    <label>@lang('form.voucher.value')</label>
                    <input type="text" class="form-control" name="value" value="{{ isset($voucher) ? $voucher->value : old('value') }}" readonly>
                    @if ($errors->has('value'))
                        <span class="help-block text-danger">
                    <strong>{{ $errors->first('value') }}</strong>
                </span>
                    @endif
                </div>
            </div>
            <div class="col-sm-6">
                <!-- text input -->
                <div class="form-group">
                    <label>@lang('form.voucher.value_max')</label>
                    <input type="text" class="form-control" name="value_max" value="{{ isset($voucher) ? $voucher->value_max : old('value_max') }}" readonly>
                    @if ($errors->has('value_max'))
                        <span class="help-block text-danger">
                    <strong>{{ $errors->first('value_max') }}</strong>
                </span>
                    @endif
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>@lang('form.voucher.description')</label>
                    <textarea class="form-control" rows="3" name="description" >{{ isset($voucher) ? $voucher->description : old('description') }}</textarea>
                    @if ($errors->has('description'))
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('description') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-5 d-none">
        <div class="form-group">
            <label>Sản phẩm áp dụng</label>
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="" name="search_product" autocomplete="off" id="search_product">
            </div>
        </div>
        <table class="table table-bordered mt-2" id="list_news">
            <thead class="thead-light">
            <tr>
                <th >Mã SP</th>
                <th style="width: 280px;">Tên sản phẩm</th>
                <th style="width: 50px;">#</th>
            </tr>
            </thead>
            <tbody id="table-body-new">
            @if(!empty($products_add))
                @forelse($products_add as $k => $item)
                    <tr>
                        <td>{{ $item->sku }}</td>
                        <td>{{ $item->title }}</td>
                        <td><button type="button" onclick="deleteCellNew('list_product',{{ $k+1 }},{{ $item->id }})" class="btn btn-danger">Xóa</button></td>
                    </tr>
                @empty
                @endforelse
            @endif
            </tbody>
        </table>
        <input type="hidden" name="products_add" id="products_add" value="@if(!empty($voucher) && $voucher->products_add){{ $voucher->products_add }}@endif">
    </div>
</div>
@section('link')
    @parent
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@10.2.7/dist/css/autoComplete.min.css">
@endsection
@section('script')
    @parent
    <script src="https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@10.2.7/dist/autoComplete.min.js"></script>
    <script src="{{ asset('ckfinder/ckfinder.js') }}"></script>
    <script>
        const product_ids = $('#products_add').val();
        const autoCompleteArticle = new autoComplete({
            selector: "#search_product",
            placeHolder: "Tìm sản phẩm...",
            data: {
                src: async (query) => {
                    try {
                        // Fetch Data from external Source
                        const articles_ids = $('#news_add').val();
                        const response = await fetch(`{{ route('admin.article.search') }}`,{
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                            },
                            body: JSON.stringify({
                                keyword: query,
                                product_ids: product_ids,
                                _token: $('meta[name="csrf-token"]').attr("content")
                            })
                        });
                        // Data should be an array of `Objects` or `Strings`
                        const data = await response.json();
                        return data.data;
                    } catch (error) {
                        return error;
                    }
                },
                keys: ["title",'slug']
            },
            resultsList: {
                element: (list, data) => {
                    const info = document.createElement("p");
                    if (data.results.length > 0) {
                        // info.innerHTML = `Displaying <strong>${data.results.length}</strong> out of <strong>${data.matches.length}</strong> results`;
                    } else {
                        info.innerHTML = `Found <strong>${data.matches.length}</strong> matching results for <strong>"${data.query}"</strong>`;
                    }
                    list.prepend(info);
                },
                noResults: true,
                maxResults: 30,
                tabSelect: true
            },
            resultItem: {
                element: (item, data) => {
                    // Modify Results Item Style
                    item.style = "display: flex; justify-content: space-between;";
                    // Modify Results Item Content
                    item.innerHTML = `
                      <span style="">
                        ${data.value.title}
                      </span>
                      <span style="display: flex; align-items: center; font-size: 13px; font-weight: 100; text-transform: uppercase; color: rgba(0,0,0,.2);">
                        ${data.key}
                      </span>`;
                },
                highlight: true,
            },
            diacritics: true,
            events: {
                input: {
                    click: () => {
                        if (autoCompleteJS.input.value.length) autoCompleteJS.start();
                    },
                }
            }
        });
        autoCompleteArticle.input.addEventListener("selection", function (event) {
            const feedback = event.detail;
            const selectedData  = feedback.selection.value;

            const newRow = document.createElement('tr');

            const skuCell = document.createElement('td');
            skuCell.textContent = selectedData['sku'];

            const titleCell = document.createElement('td');
            titleCell.textContent = selectedData['title'];

            const deleteButtonCell = document.createElement('td');
            const deleteButton = document.createElement('button');
            deleteButton.textContent = 'Xóa';
            deleteButton.classList.add('btn', 'btn-danger');
            deleteButton.setAttribute("data-id",selectedData['id']);
            deleteButton.setAttribute("type",'button');
            // Add a click event listener to the delete button
            deleteButton.addEventListener('click', function (q) {
                var id_new = $(this).data('id');
                var new_ids = document.getElementById('products_add').value;
                var myArray = new_ids.split(',');

                var newArray = myArray.filter(function(item) {
                    return item != id_new;
                });
                document.getElementById('products_add').value = newArray;
                // Remove the entire row when the delete button is clicked
                newRow.remove();
            });

            // Append the delete button to the deleteButtonCell
            deleteButtonCell.appendChild(deleteButton);

            // Append the cells to the row
            newRow.appendChild(skuCell);
            newRow.appendChild(titleCell);
            newRow.appendChild(deleteButtonCell);

            // Get the table body where you want to add the row
            const tableBody = document.getElementById('table-body-new');

            // Append the new row to the table
            tableBody.appendChild(newRow);

            var newsAddInput = document.getElementById('products_add');
            var currentNewIds = newsAddInput.value;
            if(currentNewIds){
                var currentNewIdsArray = currentNewIds.split(',');
                currentNewIdsArray.push(selectedData['id']);
            }else{
                var currentNewIdsArray = [selectedData['id']];
            }
            newsAddInput.value = currentNewIdsArray.join(',');
        });

        function deleteCellNew(tableId, rowIndex, id_new) {
            var table = document.getElementById(tableId);

            if (table) {
                table.deleteRow(rowIndex);
            }
            var new_ids = document.getElementById('products_add').value;
            var myArray = new_ids.split(',');

            var newArray = myArray.filter(function(item) {
                return item != id_new;
            });
            document.getElementById('products_add').value = newArray;
        }
    </script>
@endsection
