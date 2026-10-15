<footer class="site-footer">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4 footer-brand">
                <div class="logo {{ empty($S['logo_light']) ? 'logo-plate' : '' }}">
                    <img src="{{ !empty($S['logo_light']) ? asset('storage/'.$S['logo_light']) : asset('img/logo.png') }}" alt="{{ $S['site_name'] ?? 'Nubic' }}">
                </div>
                <p class="about">{{ $S['footer_text'] ?? '' }}</p>
                <div class="social">
                    @foreach (['facebook', 'instagram', 'linkedin', 'youtube'] as $net)
                        @if (!empty($S[$net]))<a href="{{ $S[$net] }}" target="_blank" rel="noopener"><i class="bi bi-{{ $net }}"></i></a>@endif
                    @endforeach
                </div>
            </div>
            <div class="col-6 col-lg-2">
                <h5>Quick Links</h5>
                <ul>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('page', 'about-us') }}">About Us</a></li>
                    <li><a href="{{ route('products') }}">Products</a></li>
                    <li><a href="{{ route('blog') }}">Blog</a></li>
                    <li><a href="{{ route('careers') }}">Careers</a></li>
                    <li><a href="{{ route('contact') }}">Contact</a></li>
                    @if (!empty($S['catalogue_url']))<li><a href="{{ $S['catalogue_url'] }}" target="_blank">Download Catalogue</a></li>@endif
                </ul>
            </div>
            <div class="col-6 col-lg-3">
                <h5>Products</h5>
                <ul>
                    @foreach ($footerCategories as $c)
                        <li><a href="{{ route('products.category', $c->slug) }}">{{ $c->name }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="col-lg-3">
                <h5>Contact</h5>
                <ul class="contact-list">
                    @if (!empty($S['address']))<li><i class="bi bi-geo-alt-fill"></i><span>{{ $S['address'] }}</span></li>@endif
                    @if (!empty($S['phone']))<li><i class="bi bi-telephone-fill"></i><a href="tel:{{ preg_replace('/\s+/', '', $S['phone']) }}">{{ $S['phone'] }}</a></li>@endif
                    @if (!empty($S['alt_phone']))<li><i class="bi bi-phone-fill"></i><a href="tel:{{ preg_replace('/\s+/', '', $S['alt_phone']) }}">{{ $S['alt_phone'] }}</a></li>@endif
                    @if (!empty($S['email']))<li><i class="bi bi-envelope-fill"></i><a href="mailto:{{ $S['email'] }}">{{ $S['email'] }}</a></li>@endif
                    @if (!empty($S['website']))<li><i class="bi bi-globe"></i><span>{{ $S['website'] }}</span></li>@endif
                </ul>
            </div>
        </div>
        <div class="copy d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
            <span>&copy; {{ date('Y') }} {{ $S['site_name'] ?? 'Nubic' }}. All rights reserved.</span>
            <span class="copy-links"><a href="{{ route('home') }}">Home</a><a href="{{ route('products') }}">Products</a><a href="{{ route('contact') }}">Contact</a></span>
        </div>
    </div>
</footer>

@if (!empty($S['whatsapp']))
    <a class="whatsapp-float" href="https://wa.me/{{ preg_replace('/\D+/', '', $S['whatsapp']) }}" target="_blank" rel="noopener" aria-label="WhatsApp"><i class="bi bi-whatsapp"></i></a>
@endif

<button type="button" class="back-to-top" aria-label="Back to top"><i class="bi bi-arrow-up"></i></button>
