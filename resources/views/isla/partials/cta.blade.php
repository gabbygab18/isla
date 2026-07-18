{{-- Shared closing CTA band used across section pages --}}
<section class="section">
  <div class="container">
    <div class="block block-ink reveal">
      <div class="cta-band__inner">
        <span class="icon-btn icon-btn-inverse"><svg class="icon icon-lg"><use href="#i-star"/></svg></span>
        <h2 class="t-headline">Ready to lift the admin off your team?</h2>
        <p class="t-body" style="margin-top:10px;">Book a 20-minute discovery call — no obligation, just a conversation about where the hours are going.</p>
        <a href="{{ route('isla.book-call') }}" class="btn btn-on-dark" style="margin-top:14px;">
          <svg class="icon"><use href="#i-calendar"/></svg>
          {{ setting('hero_cta_label', 'Book a Discovery Call') }}
        </a>
      </div>
    </div>
  </div>
</section>
