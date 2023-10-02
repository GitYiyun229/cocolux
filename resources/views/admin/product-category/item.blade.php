<li class="dd-item" data-id="{{ $item->id }}" data-name="{{ $item->title }}" >
    <div class="dd-handle">
        {{ $item->title }}
    </div>
{{--    <input type="text" class="form-control update-name" id="update-name-{{ $item->id }}" value="{{ $item->title }}">--}}
    @if (count($item->children) > 0)
        <ol class="dd-list">
            @foreach ($item->children as $val)
                @include('admin.product-category.item', ['item'=>$val])
            @endforeach
        </ol>
    @endif
</li>
