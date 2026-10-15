<section class="cta-wrap">
    <div class="container">
        <div class="cta-card reveal">
            <div class="cta-text">
                <span class="eyebrow">Get In Touch</span>
                <h2>Looking for a dealer or bulk pricing?</h2>
                <p>Tell us what you need and our team will get back to you with the best offer.</p>
            </div>
            <div class="cta-actions">
                <a href="{{ route('contact') }}" class="btn btn-primary btn-lg">Send Enquiry <i class="bi bi-arrow-right ms-1"></i></a>
                @if (!empty($S['phone']))
                    <a href="tel:{{ preg_replace('/\s+/', '', $S['phone']) }}" class="cta-phone"><i class="bi bi-telephone-fill"></i><span><small>Or call us</small>{{ $S['phone'] }}</span></a>
                @endif
            </div>
        </div>
    </div>
</section>
