@php $tel = fn ($n) => 'tel:'.preg_replace('/\s+/', '', $n); @endphp
<footer class="site-footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-brand">
                <img src="{{ !empty($S['logo']) ? asset('storage/'.$S['logo']) : asset('img/logo.png') }}" alt="{{ $S['site_name'] ?? 'Nubic' }}">
                @if (!empty($S['address']))<p>{!! nl2br(e($S['address'])) !!}</p>@endif
                <div class="social">
                    @foreach (['facebook', 'instagram', 'linkedin', 'youtube'] as $net)
                        @if (!empty($S[$net]))<a href="{{ $S[$net] }}" target="_blank" rel="noopener" aria-label="{{ ucfirst($net) }}"><i class="bi bi-{{ $net }}"></i></a>@endif
                    @endforeach
                </div>
            </div>
            <div>
                <h2>Products</h2>
                <ul>
                    @foreach ($footerCategories as $c)
                        <li><a href="{{ route('products.category', $c->slug) }}">{{ $c->name }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div>
                <h2>Company</h2>
                <ul>
                    <li><a href="{{ route('page', 'about-us') }}">About Nubic</a></li>
                    <li><a href="{{ route('blog') }}">Blog</a></li>
                    <li><a href="{{ route('careers') }}">Careers</a></li>
                    <li><a href="{{ route('contact') }}">Become a Dealer</a></li>
                    @if (!empty($S['catalogue_url']))<li><a href="{{ $S['catalogue_url'] }}" target="_blank" rel="noopener">Download Catalogue</a></li>@endif
                </ul>
            </div>
            <div>
                <h2>Get in touch</h2>
                <ul>
                    @if (!empty($S['phone']))<li><a href="{{ $tel($S['phone']) }}">{{ $S['phone'] }}</a></li>@endif
                    @if (!empty($S['alt_phone']))<li><a href="{{ $tel($S['alt_phone']) }}">{{ $S['alt_phone'] }}</a></li>@endif
                    @if (!empty($S['email']))<li><a href="mailto:{{ $S['email'] }}">{{ $S['email'] }}</a></li>@endif
                    @if (!empty($S['whatsapp']))<li><a href="https://wa.me/{{ preg_replace('/\D+/', '', $S['whatsapp']) }}" target="_blank" rel="noopener">WhatsApp us</a></li>@endif
                    <li><a href="{{ route('contact') }}">Send an enquiry</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-copy">
            <span>&copy; {{ date('Y') }} {{ $S['site_name'] ?? 'Nubic' }}. All rights reserved.</span>
            <span>Made in India</span>
        </div>
    </div>
</footer>

@if (!empty($S['whatsapp']))
    <a class="whatsapp-float" href="https://wa.me/{{ preg_replace('/\D+/', '', $S['whatsapp']) }}" target="_blank" rel="noopener" aria-label="Chat on WhatsApp"><i class="bi bi-whatsapp"></i></a>
@endif

<button type="button" class="back-to-top" aria-label="Back to top"><i class="bi bi-arrow-up"></i></button>
