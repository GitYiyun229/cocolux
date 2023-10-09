<nav aria-label="breadcrumb" class="pt-3 pb-3 mb-4">
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{ route('home') }}">
                <i class="fa-solid fa-house-chimney"></i>
                Trang chủ
            </a>
        </li>
        @if(count($links) > 0)
            @forelse($links as $k => $item)
                <li class="breadcrumb-item @if(count($links) == ($k+1)) active @endif" aria-current="page">
                    <a href="{{ $item->link }}">
                        {{ $item->name }}
                    </a>
                </li>
            @empty
            @endforelse
        @endif
    </ol>
</nav>
