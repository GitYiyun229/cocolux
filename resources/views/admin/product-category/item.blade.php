<li class="dd-item" data-id="{{ $item->id }}" data-name="{{ $item->name }}" >
    <div class="dd-handle">
        {{ $item->name }}
    </div>
    <input type="text" class="form-control update-name" id="update-name-{{ $item->id }}" value="{{ $item->name }}">
    @if (count($item->children) > 0)
        <ol class="dd-list">
            @foreach ($item->children as $val)
                @include('admin.article-category.item', ['item'=>$val])
            @endforeach
        </ol>
    @endif
</li>
