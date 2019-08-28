<!-- BREADCRUMB-->
@if (count($breadcrumbs))
<div class="au-breadcrumb-content">
    <div class="au-breadcrumb-left">
        <span class="au-breadcrumb-span">You are here:</span>
        <ul class="list-unstyled list-inline au-breadcrumb__list">
            @foreach ($breadcrumbs as $breadcrumb)

                @if ($breadcrumb->url && !$loop->last)
                <li class="list-inline-item"><a href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a></li>
                <li class="list-inline-item seprate"><span>/</span></li>
                @else
                <li class="list-inline-item">{{ $breadcrumb->title }}</li>
                @endif

            @endforeach
        </ul>
    </div>
</div>
@endif
<!-- END BREADCRUMB-->