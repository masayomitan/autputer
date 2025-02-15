

@if (count($breadcrumbs))

    <ol class="breadcrumb">

        <a href="{{ route('home') }}"><i class="fas fa-home"></i></a>

        @foreach ($breadcrumbs as $breadcrumb)
            @if ($breadcrumb->url && !$loop->last)
                <li class="breadcrumb-item"><a href="{{ $breadcrumb->url }}"> > {{ $breadcrumb->title }}</a></li>
            @else
                <li class="breadcrumb-item active"> > {{ $breadcrumb->title }}</li>
            @endif

        @endforeach
    </ol>

@endif
