<div class="product-card">
    <div class="thumb">
        @if ($product->image)
            <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}">
        @else
            <i class="bi bi-lightning-charge placeholder"></i>
        @endif
    </div>
    <div class="body">
        <span class="cat">{{ $product->category->name ?? '' }}</span>
        <h3><a href="{{ route('product', $product->slug) }}">{{ $product->name }}</a></h3>
                <a href="{{ route('product', $product->slug) }}" class="more">View Details <i class="bi bi-arrow-right"></i></a>
    </div>
</div>
