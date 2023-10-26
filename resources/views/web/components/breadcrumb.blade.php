@if (count($breadcrumbs))

    <ol class="breadcrumb mb-0">
        @foreach ($breadcrumbs as $breadcrumb)
            @if ($breadcrumb->url && !$loop->last)
                <li class="breadcrumb-item"><a href="{{ $breadcrumb->url }}">@if(!empty($breadcrumb->icon)) <i class="{{ $breadcrumb->icon }}"></i> @endif{{ $breadcrumb->title }}</a></li>
            @else
                <li class="breadcrumb-item active">@if(!empty($breadcrumb->icon)) <i class="{{ $breadcrumb->icon }}"></i> @endif{{ $breadcrumb->title }}</li>
            @endif

        @endforeach
    </ol>

@endif
