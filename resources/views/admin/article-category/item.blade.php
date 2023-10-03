<li class="dd-item" data-id="{{ $item->id }}" data-name="{{ $item->title }}" >
    <div class="dd-handle">
        {{ $item->title }}
    </div>
    @if (count($item->children) > 0)
        <ol class="dd-list">
            @foreach ($item->children as $val)
                @include('admin.article-category.item', ['item'=>$val])
            @endforeach
        </ol>
    @endif
</li>
