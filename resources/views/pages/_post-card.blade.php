<article class="post-card">
    <a href="{{ route('post', $post->slug) }}" class="thumb">
        @if ($post->image)<img src="{{ asset('storage/'.$post->image) }}" alt="{{ $post->title }}" loading="lazy">@else<i class="bi bi-newspaper"></i>@endif
    </a>
    <div class="body">
        <div class="date"><i class="bi bi-calendar3"></i> {{ ($post->published_at ?? $post->created_at)->format('d M Y') }}@if ($post->author) · {{ $post->author }}@endif</div>
        <h3><a href="{{ route('post', $post->slug) }}">{{ $post->title }}</a></h3>
        <p>{{ $post->summary }}</p>
        <a href="{{ route('post', $post->slug) }}" class="more">Read More <i class="bi bi-arrow-right"></i></a>
    </div>
</article>
