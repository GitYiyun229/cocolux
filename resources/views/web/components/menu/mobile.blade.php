<li >
    <a href="{{ $item->link }}">{{ $item->name }}</a>
    @if (count($item->children) > 0)
        <ul >
            @foreach ($item->children as $val)
                @include('web.components.menu.mobile', ['item'=>$val])
            @endforeach
        </ul>
    @endif
</li>
