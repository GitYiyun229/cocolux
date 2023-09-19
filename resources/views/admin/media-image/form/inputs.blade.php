<div class="row">
    <div class="col-md-6">
        <div class="row">
            <div class="col-sm-6">
                <!-- text input -->
                <div class="form-group">
                    <label>@lang('form.media-image.title')</label> <span class="text-danger">*</span>
                    <input type="text" class="form-control" name="title" value="{{ isset($image) ? $image->title : old('title') }}" required>
                    @if ($errors->has('title'))
                        <span class="help-block text-danger">
                    <strong>{{ $errors->first('title') }}</strong>
                </span>
                    @endif
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group clearfix">
                    <label>@lang('form.media-image.active')</label> <span class="text-danger">*</span>
                    <div class="form-group">
                        <div class="icheck-success d-inline">
                            <input class="" type="radio" id="statusRadio1" name="active" value="{{ \App\Models\Media::STATUS_ACTIVE }}" {{ isset($image->active) && $image->active == \App\Models\Media::STATUS_ACTIVE ? 'checked' : 'checked' }} required>
                            <label for="statusRadio1" class="custom-control-label">@lang('form.status.active')&nbsp;&nbsp;&nbsp;&nbsp;</label>
                        </div>
                        <div class="icheck-danger d-inline">
                            <input class="" type="radio" id="statusRadio2" name="active" value="{{ \App\Models\Media::STATUS_INACTIVE }}" {{ isset($image->active) && $image->active == \App\Models\Media::STATUS_INACTIVE ? 'checked' : '' }} required>
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
                <div class="form-group">
                    <label>@lang('form.media-image.image')</label> <span class="text-danger">*</span>
                    <div class="input-group">
                        @include('admin.components.buttons.image',['src' => isset($image->image) ? $image->image : old('image'),'name' => 'image'])
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
                <div class="form-group clearfix">
                    <label>@lang('form.media-image.is_home')</label> <span class="text-danger">*</span>
                    <div class="form-group">
                        <div class="icheck-success d-inline">
                            <input class="" type="radio" id="homeRadio1" name="is_home" value="{{ \App\Models\Media::IS_HOME }}" {{ (isset($image->is_home) && $image->is_home == \App\Models\Media::IS_HOME) ? 'checked' : (old('is_home') && (old('is_home') == \App\Models\Media::IS_HOME)) ? 'checked' : '' }}  required>
                            <label for="homeRadio1" class="custom-control-label">@lang('form.status.is_home')&nbsp;&nbsp;&nbsp;&nbsp;</label>
                        </div>
                        <div class="icheck-danger d-inline">
                            <input class="" type="radio" id="homeRadio2" name="is_home" value="{{ \App\Models\Media::IS_NOT_HOME }}" {{ (isset($image) && $image->is_home == \App\Models\Media::IS_NOT_HOME) ? 'checked' : (old('is_home') && (old('is_home') == \App\Models\Media::IS_NOT_HOME)) ? 'checked' : '' }}  required>
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
            <div class="col-sm-6">
                <!-- text input -->
                <div class="form-group">
                    <label>@lang('form.media-image.ordering')</label>
                    <input type="text" class="form-control" name="ordering" value="{{ isset($image) ? $image->ordering : old('ordering') }}" >
                    @if ($errors->has('ordering'))
                        <span class="help-block text-danger">
                    <strong>{{ $errors->first('ordering') }}</strong>
                </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <button id="ckfinder-modal" type="button" class="button-a button-a-background" style="float: left">Open Modal</button>
        <div id="sortable-container">
            @php
                $listImages = [];
            @endphp
            @if(!empty($image->mediaImages))
                @forelse($image->mediaImages as $item)
                    @php
                        $listImages[] = $item->image;
                    @endphp
                <span class="mr-2 mb-3" style="width: 200px;">
                    <img src="{{ asset($item->image) }}" class="img-responsive mr-2" style="width: 200px;">
                    <span>{{ basename($item->image) }}</span>
                    <button class="delete-btn" type="button">Xóa</button>
                </span>
                @empty
                @endforelse
            @endif
        </div>
        <input type="hidden" name="sortedIds" id="sortedIdsInput" value="{{ $listImages?implode(',',$listImages):'' }}">
    </div>
</div>
@section('link')
    @parent
    <style>
        #sortable-container{
            display: flex;
            flex-wrap: wrap;
        }
    </style>
@endsection
@section('script')
    @parent
    <script src="{{ asset('ckfinder/ckfinder.js') }}"></script>
    <script src="{{ asset('js/admin/Sortable.js') }}"></script>
    <script>
        const buttonModal = document.getElementById( 'ckfinder-modal' );
        const sortableContainer = document.getElementById('sortable-container');
        const sortedIdsInput = document.getElementById('sortedIdsInput');
        const deleteButtons = document.querySelectorAll('.delete-btn');
        buttonModal.onclick = function() {
            CKFinder.modal( {
                chooseFiles: true,
                width: 800,
                height: 600,
                onInit: function( finder ) {
                    finder.on( 'files:choose', function( evt ) {
                        const files = evt.data.files;
                        files.forEach( function( file, i ) {
                            const name = file.get( 'name' );
                            const fileroot = file.getUrl();
                            const divElement = document.createElement('span');
                            divElement.classList.add('mr-2');
                            divElement.classList.add('mb-3');
                            divElement.style.width = '200px';
                            divElement.innerHTML = `
                                <img src="${fileroot}" class="img-responsive mr-2" style="width: 200px;">
                                <span>${name}</span>
                                <button class="delete-btn" type="button">Xóa</button>
                            `;

                            sortableContainer.appendChild(divElement);
                            const imageElements = sortableContainer.querySelectorAll('img');
                            const imageLinks = Array.from(imageElements).map((image) => image.src.replace(/^.*\/\/[^/]+/, ''));
                            sortedIdsInput.value = imageLinks.join(',');
                        });
                    } );

                    finder.on( 'file:choose:resizedImage', function( evt ) {
                        const file = evt.data.resizedUrl;
                        const name = file.get( 'name' );
                        const divElement = document.createElement('span');
                        divElement.classList.add('mr-2');
                        divElement.classList.add('mb-3');
                        divElement.style.width = '200px';
                        divElement.innerHTML = `
                            <img src="${file}" class="img-responsive mr-2" style="width: 200px;">
                            <span>${name}</span>
                            <button class="delete-btn" type="button">Xóa</button>
                        `;
                        sortableContainer.appendChild(divElement);
                        const imageElements = sortableContainer.querySelectorAll('img');
                        const imageLinks = Array.from(imageElements).map((image) => image.src.replace(/^.*\/\/[^/]+/, ''));
                        sortedIdsInput.value = imageLinks.join(',');
                    } );
                }
            } );
        };

        Sortable.create(sortableContainer, {
            animation: 150,
            handle: 'img',
            onEnd: () => {
                const imageElements = sortableContainer.querySelectorAll('img');
                const imageLinks = Array.from(imageElements).map((image) => image.src.replace(/^.*\/\/[^/]+/, ''));
                sortedIdsInput.value = imageLinks.join(',');
            }
        });

        deleteButtons.forEach((button) => {
            button.addEventListener('click', () => {
                // Hiển thị hộp thoại xác nhận
                const confirmed = confirm('Bạn có chắc chắn muốn xóa?');

                // Nếu người dùng đồng ý xóa, thực hiện xóa thẻ cha
                if (confirmed) {
                    button.parentNode.remove();
                    const imageElements = sortableContainer.querySelectorAll('img');
                    const imageLinks = Array.from(imageElements).map((image) => image.src.replace(/^.*\/\/[^/]+/, ''));
                    sortedIdsInput.value = imageLinks.join(',');
                }
            });
        });
    </script>
@endsection
