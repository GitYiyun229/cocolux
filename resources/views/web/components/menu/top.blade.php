<li class="nav-item" data-id="{{ $item->id }}" data-name="{{ $item->name }}" >
    <a class="nav-link @if (request()->is('admin/role*')) active @endif" href="{{ $item->link }}">{{ $item->name }} {!! (count($item->children) > 0)?'<i class="fas fa-angle-down"></i>':'' !!}</a>
    @if (count($item->children) > 0)
        <ul class="sub-menu">
            @foreach ($item->children as $val)
                @include('web.components.menu.top', ['item'=>$val])
            @endforeach
        </ul>
    @endif
</li>
