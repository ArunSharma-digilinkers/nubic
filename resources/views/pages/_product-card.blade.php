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
        <div class="p-card-price">
            @if ($showPrices && $minMrp)
                From ₹{{ number_format($minMrp) }}
            @else
                Dealer price on request
            @endif
        </div>
    </div>
    <div class="p-card-actions">
        <a href="{{ route('product', $product->slug) }}" class="btn-view">Details</a>
        <a href="{{ route('contact', ['product' => $product->id]) }}" class="btn-enq">Enquire <span aria-hidden="true">→</span></a>
    </div>
</article>
