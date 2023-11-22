<div class="row">
{{--    đánh dấu loại tin tức--}}
    <input type="hidden" value="0" name="type" id="type">
    <div class="col-sm-7">
        <div class="row">
            <div class="col-sm-6">
                <!-- text input -->
                <div class="form-group">
                    <label>@lang('form.article.title')</label> <span class="text-danger">*</span>
                    <input type="text" class="form-control" name="title" value="{{ isset($article) ? $article->title : old('title') }}" required>
                    @if ($errors->has('title'))
                        <span class="help-block text-danger">
                    <strong>{{ $errors->first('title') }}</strong>
                </span>
                    @endif
                </div>
            </div>
            <div class="col-sm-6">
                <!-- text input -->
                <div class="form-group">
                    <label>@lang('form.article.slug')</label> <span class="text-danger">(@lang('form.auto_slug'))</span>
                    <input type="text" class="form-control" name="slug" value="{{ isset($article) ? $article->slug : old('slug') }}">
                    @if ($errors->has('slug'))
                        <span class="help-block text-danger">
                    <strong>{{ $errors->first('slug') }}</strong>
                </span>
                    @endif
                </div>
            </div>
            @if ($article)
            <div class="col-md-12 mb-3">
                <b>Link: </b> <a target="_blank" href="{{ route('detailArticle',['slug'=>$article->slug,'id'=>$article->id]) }}">{{ route('detailArticle',['slug'=>$article->slug,'id'=>$article->id]) }}</a>
            </div>
            @endif
            <div class="col-sm-6">
                <!-- text input -->
                <div class="form-group clearfix">
                    <label>@lang('form.article.active')</label> <span class="text-danger">*</span>
                    <div class="form-group">
                        <div class="icheck-success d-inline">
                            <input class="" type="radio" id="statusRadio1" name="active" value="{{ \App\Models\Article::STATUS_ACTIVE }}" {{ (isset($article->active) && $article->active == \App\Models\Article::STATUS_ACTIVE) ? 'checked' : (old('active') && (old('active') == \App\Models\Article::STATUS_ACTIVE)) ? 'checked' : '' }}  required>
                            <label for="statusRadio1" class="custom-control-label">@lang('form.status.active')&nbsp;&nbsp;&nbsp;&nbsp;</label>
                        </div>
                        <div class="icheck-danger d-inline">
                            <input class="" type="radio" id="statusRadio2" name="active" value="{{ \App\Models\Article::STATUS_INACTIVE }}" {{ (isset($article) && $article->active == \App\Models\Article::STATUS_INACTIVE) ? 'checked' : (old('active') && (old('active') == \App\Models\Article::STATUS_INACTIVE)) ? 'checked' : '' }}  required>
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
            <div class="col-sm-6">
                <!-- text input -->
                <div class="form-group clearfix">
                    <label>@lang('form.article.is_home')</label> <span class="text-danger">*</span>
                    <div class="form-group">
                        <div class="icheck-success d-inline">
                            <input class="" type="radio" id="homeRadio1" name="is_home" value="{{ \App\Models\Article::IS_HOME }}" {{ (isset($article->is_home) && $article->is_home == \App\Models\Article::IS_HOME) ? 'checked' : (old('is_home') && (old('is_home') == \App\Models\Article::IS_HOME)) ? 'checked' : '' }}  required>
                            <label for="homeRadio1" class="custom-control-label">@lang('form.status.is_home')&nbsp;&nbsp;&nbsp;&nbsp;</label>
                        </div>
                        <div class="icheck-danger d-inline">
                            <input class="" type="radio" id="homeRadio2" name="is_home" value="{{ \App\Models\Article::IS_NOT_HOME }}" {{ (isset($article) && $article->is_home == \App\Models\Article::IS_NOT_HOME) ? 'checked' : (old('is_home') && (old('is_home') == \App\Models\Article::IS_NOT_HOME)) ? 'checked' : '' }}  required>
                            <label for="homeRadio2" class="custom-control-label">@lang('form.status.is_not_home')</label>
                        </div>
                    </div>
                    @if ($errors->has('is_home'))
                        <span class="help-block text-danger">
                    <strong>{{ $errors->first('is_home') }}</strong>
                </span>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <!-- text input -->
                <div class="form-group clearfix">
                    <label>Mục lục</label> <span class="text-danger">*</span>
                    <div class="form-group">
                        <div class="icheck-success d-inline">
                            <input class="" type="radio" id="tocRadio1" name="has_toc" value="{{ \App\Models\Article::IS_HOME }}" {{ (isset($article->has_toc) && $article->has_toc == \App\Models\Article::HAS_TOC) ? 'checked' : (old('has_toc') && (old('has_toc') == \App\Models\Article::HAS_TOC)) ? 'checked' : '' }}  required>
                            <label for="tocRadio1" class="custom-control-label">Có&nbsp;&nbsp;&nbsp;&nbsp;</label>
                        </div>
                        <div class="icheck-danger d-inline">
                            <input class="" type="radio" id="tocRadio2" name="has_toc" value="{{ \App\Models\Article::IS_NOT_HOME }}" {{ (isset($article) && $article->has_toc == \App\Models\Article::NOT_HAS_TOC) ? 'checked' : (old('has_toc') && (old('has_toc') == \App\Models\Article::NOT_HAS_TOC)) ? 'checked' : '' }}  required>
                            <label for="tocRadio2" class="custom-control-label">Không</label>
                        </div>
                    </div>
                    @if ($errors->has('is_home'))
                        <span class="help-block text-danger">
                    <strong>{{ $errors->first('is_home') }}</strong>
                </span>
                    @endif
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>@lang('form.article.category')</label> <span class="text-danger">*</span>
                    <select name="category_id" id="category_id" class="form-control" required>
                        @forelse($categories as $key => $category)
                            <option value="{{ $category['id'] }}" {{ isset($article->category_id) && $article->category_id == $category['id'] ? 'selected' : old('category_id') == $category['id'] ? 'selected' : '' }}>{{ $category['title'] }}</option>
                        @empty
                        @endforelse
                    </select>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>@lang('form.article.image')</label> <span class="text-danger">*</span>
                    <div class="input-group">
                        @include('admin.components.buttons.image',['src' => isset($article->image) ? $article->image_change_url : old('image'),'name' => 'image'])
                        @if ($errors->has('image'))
                            <span class="help-block text-danger">
                                <strong>{{ $errors->first('image') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <!-- text input -->
                <div class="form-group">
                    <label>@lang('form.article.ordering')</label>
                    <input type="text" class="form-control" name="ordering" value="{{ isset($article) ? $article->ordering : old('ordering') }}" >
                    @if ($errors->has('ordering'))
                        <span class="help-block text-danger">
                    <strong>{{ $errors->first('ordering') }}</strong>
                </span>
                    @endif
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <label>@lang('form.description')</label> <span class="text-danger">*</span>
                    <textarea class="form-control" rows="3" name="description" required >{{ isset($article) ? $article->description : old('description') }}</textarea>
                    @if ($errors->has('description'))
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('description') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <label>@lang('form.content')</label> <span class="text-danger">*</span>
                    <textarea id="content" name="content" class="form-control" rows="10" >{{ isset($article->content) ? replace_image($article->content) : old('content') }}</textarea>
                    @if ($errors->has('content'))
                        <span class="help-block text-danger">
                    <strong>{{ $errors->first('content') }}</strong>
                </span>
                    @endif
                    <div class="editor"></div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <label>@lang('form.article.products')</label>
                    @if ($errors->has('products'))
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('products') }}</strong>
                        </span>
                    @endif
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="" name="search_product" autocomplete="off" id="search_product">
                    </div>
                </div>
                <div class="selection"></div>
                <table class="table table-bordered mt-2" id="list_products">
                    <thead class="thead-light">
                        <tr>
                            <th style="width: 100px;">Mã SP</th>
                            <th style="width: 280px;">Tên sản phẩm</th>
                            <th style="width: 100px;">Giá</th>
                            <th style="width: 100px;">Mã nhúng bài viết</th>
                            <th style="width: 50px;">#</th>
                        </tr>
                    </thead>
                    <tbody id="table-body">
                        @if(!empty($products))
                            @forelse($products as $k => $item)
                                <tr>
                                    <td>{{ $item->sku }}</td>
                                    <td>{{ $item->title }}</td>
                                    <td>{{ format_money($item->price) }}</td>
                                    <td>
                                        <div class="border border-warning rounded btn copy-btn" data-clipboard-text="product-option-{{ $item->id }}">
                                            product-option-{{ $item->id }}
                                        </div>
                                    </td>
                                    <td><button type="button" onclick="deleteCell('list_products',{{ $k+1 }},{{ $item->id }})" class="btn btn-danger">Xóa</button></td>
                                </tr>
                            @empty
                            @endforelse
                        @endif
                    </tbody>
                </table>
                <input type="hidden" name="products_add" id="products_add" value="@if(!empty($article) && $article->products){{ $article->products }}@endif">
            </div>
        </div>
    </div>
    <div class="col-sm-5">
        <div class="card card-warning">
            <div class="card-header" style="background-color: #ccc;">
                <h3 class="card-title">SEO</h3>
            </div>
            <div class="card-body p-3" style="background-color: #f1f1f1;">
                <div class="form-group">
                    <label>@lang('form.seo_title')</label>
                    <input type="text" class="form-control" name="seo_title" value="{{ isset($article) ? $article->seo_title : old('seo_title') }}" >
                    @if ($errors->has('seo_title'))
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('seo_title') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <label>@lang('form.seo_keyword')</label>
                    <input type="text" class="form-control" name="seo_keyword" value="{{ isset($article) ? $article->seo_keyword : old('seo_keyword') }}" >
                    @if ($errors->has('seo_keyword'))
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('seo_keyword') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <label>@lang('form.seo_description')</label>
                    <textarea class="form-control" rows="3" name="seo_description" >{{ isset($article) ? $article->seo_description : old('seo_description') }}</textarea>
                    @if ($errors->has('seo_description'))
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('seo_description') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@section('link')
    @parent
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@10.2.7/dist/css/autoComplete.min.css">
@endsection

@section('script')
    @parent
    <script src="https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@10.2.7/dist/autoComplete.min.js"></script>
    <script src="{{ asset('ckeditor/ckeditor.js') }}?v=1.0"></script>
    <script src="{{ asset('ckfinder/ckfinder.js') }}?v=1.0"></script>
    <script>
        CKEDITOR.replace( 'content' );
        const autoCompleteJS = new autoComplete({
            selector: "#search_product",
            placeHolder: "Tìm sản phẩm...",
            data: {
                src: async (query) => {
                    try {
                        // Fetch Data from external Source
                        const product_ids = $('#products_add').val();
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
                keys: ["title","sku",'slug']
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
        autoCompleteJS.input.addEventListener("selection", function (event) {
            const feedback = event.detail;
            const selectedData  = feedback.selection.value;

            const newRow = document.createElement('tr');

            // Create table data (td) elements for each column
            const skuCell = document.createElement('td');
            skuCell.textContent = selectedData['sku'];

            const titleCell = document.createElement('td');
            titleCell.textContent = selectedData['title'];

            const priceCell = document.createElement('td');
            priceCell.textContent = formatMoney(selectedData['price']);

            const codeAddCell = document.createElement('td');
            const codeButton = document.createElement('div');
            codeButton.textContent = 'product-option-'+selectedData['id'];
            codeButton.classList.add('border', 'border-warning','rounded','btn','copy-btn');
            codeButton.setAttribute("data-clipboard-text", 'product-option-'+selectedData['id']);
            codeAddCell.appendChild(codeButton);

            const deleteButtonCell = document.createElement('td');
            const deleteButton = document.createElement('button');
            deleteButton.textContent = 'Xóa';
            deleteButton.classList.add('btn', 'btn-danger');
            deleteButton.setAttribute("data-id",selectedData['id']);
            // Add a click event listener to the delete button
            deleteButton.addEventListener('click', function (q) {
                var id_product = $(this).data('id');
                var product_ids = document.getElementById('products_add').value;
                var myArray = product_ids.split(',');

                var newArray = myArray.filter(function(item) {
                    return item != id_product;
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
            newRow.appendChild(priceCell);
            newRow.appendChild(codeAddCell);
            newRow.appendChild(deleteButtonCell);

            // Get the table body where you want to add the row
            const tableBody = document.getElementById('table-body');

            // Append the new row to the table
            tableBody.appendChild(newRow);

            var productsAddInput = document.getElementById('products_add');
            var currentProductIds = productsAddInput.value;
            if(currentProductIds){
                var currentProductIdsArray = currentProductIds.split(',');
                currentProductIdsArray.push(selectedData['id']);
            }else{
                var currentProductIdsArray = [selectedData['id']];
            }

            productsAddInput.value = currentProductIdsArray.join(',');
        });

        $('#table-body').on("click",".copy-btn", function(){
            value = $(this).data('clipboard-text');
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val(value).select();
            document.execCommand("copy");
            $temp.remove();
            toastr["success"]('Copy thành công');
        })

        function formatMoney(price, current = 'đ', text = 'Liên hệ') {
            if (!price) {
                return text;
            }
            return price.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
        }

        function deleteCell(tableId, rowIndex, id_product) {
            var table = document.getElementById(tableId);

            if (table) {
                table.deleteRow(rowIndex);
            }
            var product_ids = document.getElementById('products_add').value;
            var myArray = product_ids.split(',');

            var newArray = myArray.filter(function(item) {
                return item != id_product;
            });
            document.getElementById('products_add').value = newArray;
        }
    </script>
@endsection
