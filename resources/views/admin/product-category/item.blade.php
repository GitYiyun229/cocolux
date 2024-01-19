<li class="dd-item" data-id="{{ $item->id }}" data-name="{{ $item->title }}" >
    <a href="{{ route('admin.product-category.edit', $item->id) }}" class="position-absolute dd-remove">Sửa</a>
    <div class="dd-handle d-flex justify-content-between">
        {{ $item->title }}
    </div>

    @if (count($item->children) > 0)
        <ol class="dd-list">
            @foreach ($item->children as $val)
                @include('admin.product-category.item', ['item'=>$val])
            @endforeach
        </ol>
    @endif
</li>
