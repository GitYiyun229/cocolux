<li class="dd-item" data-id="{{ $item->id }}" data-name="{{ $item->name }}" data-link="{{ $item->link }}" >
    <div class="dd-handle">
        {{ $item->name }}
    </div>
    <div class="dd-remove" data-url="{{ route('admin.menu.destroy', $item->id) }}">
        Xóa
    </div>
    <input type="text" class="form-control update-name" id="update-name-{{ $item->id }}" value="{{ $item->name }}">
    <input type="text" class="form-control update-link" id="update-link-{{ $item->id }}" value="{{ $item->link }}">
    @if (count($item->children) > 0)
        <ol class="dd-list">
            @foreach ($item->children as $val)
                @include('admin.menu.item', ['item'=>$val])
            @endforeach
        </ol>
    @endif
</li>
