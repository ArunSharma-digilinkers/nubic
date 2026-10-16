@php
    $showPrices = ($S['show_prices'] ?? '1') === '1';
    $ratings = $product->ratingList();
    $minMrp = $product->variants->whereNotNull('mrp')->min('mrp');
    $points = array_slice($product->featureList(), 0, 2);
@endphp
<article class="p-card">
    <a href="{{ route('product', $product->slug) }}" class="p-card-media" tabindex="-1" aria-hidden="true">
        <img src="{{ $product->imageUrl() }}" alt="" loading="lazy">
    </a>
    <div class="p-card-body">
        @if ($product->category)<span class="p-card-cat">{{ $product->category->name }}</span>@endif
        <h3><a href="{{ route('product', $product->slug) }}">{{ $product->name }}</a></h3>

        @if ($ratings)
            <div class="chips">
                @foreach (array_slice($ratings, 0, 4) as $r)<span>{{ $r }}</span>@endforeach
                @if (count($ratings) > 4)<span class="more">+{{ count($ratings) - 4 }}</span>@endif
            </div>
        @endif

        @if ($points)
            <ul class="dash-list">@foreach ($points as $pt)<li>{{ $pt }}</li>@endforeach</ul>
        @endif

        <div class="p-card-price">
            @if ($showPrices && $minMrp)
                MRP from ₹{{ number_format($minMrp) }}
            @else
                <span class="muted">Ask for dealer price</span>
            @endif
        </div>

        <div class="p-card-actions">
            <a href="{{ route('product', $product->slug) }}" class="btn btn-outline-primary btn-sm">View Details</a>
            <a href="{{ route('contact', ['product' => $product->id]) }}" class="btn btn-primary btn-sm">Enquire</a>
        </div>
    </div>
</article>
