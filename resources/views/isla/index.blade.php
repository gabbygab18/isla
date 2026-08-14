@extends('layouts.app')

@section('content')
<main id="top">

  {{-- HERO --}}
  <section class="hero">
    <div class="container hero__grid">
      <div class="reveal">
        <p class="t-eyebrow hero__eyebrow">{{ setting('hero_eyebrow', 'Managed virtual staffing for Australian businesses') }}</p>
        <h1 class="t-display-xl">{!! nl2br(e(setting('hero_title', "Delegate the admin.\nProtect the care."))) !!}</h1>
        <p class="t-body-lg hero__sub">{{ setting('hero_subtitle', 'Isla places dedicated virtual assistants for NDIS providers, healthcare and allied health practices, and growing Australian businesses — supported by structured, sector-aware onboarding and ongoing workforce management.') }}</p>
        <div class="hero__ctas">
          <a href="{{ route('isla.book-call') }}" class="btn btn-primary">
            <svg class="icon"><use href="#i-calendar"/></svg>
            {{ setting('hero_cta_label', 'Book a Discovery Call') }}
          </a>
          <a href="{{ route('isla.how-it-works') }}" class="btn btn-secondary">
            See how it works
            <svg class="icon"><use href="#i-arrow"/></svg>
          </a>
        </div>
      </div>
      <div class="hero__visual reveal">
        <div class="hero__frame">
          <img src="{{ setting('hero_image', 'https://images.unsplash.com/photo-1766066014237-00645c74e9c6?w=1200&q=80&auto=format&fit=crop') }}" alt="A virtual assistant working at her desk">
        </div>
        <div class="hero__badge">
          <svg class="icon icon-lg" style="color:var(--rose-deep)"><use href="#i-clock"/></svg>
          <div>
            <strong>{{ setting('hero_badge_strong', 'Dedicated') }}</strong>
            <span>{{ setting('hero_badge_text', 'to your business during agreed working hours') }}</span>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- TRUST BAR --}}
  <section class="section-tight" style="padding-top:0;">
    <div class="container">
      @include('isla.partials.trust-bar')
    </div>
  </section>

  {{-- AUDIENCE / WHO WE WORK WITH --}}
  <section class="section" id="who-its-for">
    <div class="container">
      <div class="section__head reveal">
        <p class="t-eyebrow" style="color:var(--sage-deep)">{{ setting('audiences_eyebrow', 'Who we work with') }}</p>
        <h2 class="t-display-lg">{{ setting('audiences_heading', "Built for the work that can't be generic") }}</h2>
        <p class="t-body-lg" style="color:var(--ink-soft); margin-top:16px;">{{ setting('audiences_intro', 'Most virtual staffing agencies are horizontal generalists. Isla is built around three groups whose paperwork actually carries risk.') }}</p>
      </div>
      <div class="grid-3">
        @foreach ($audiences as $audience)
          <a href="{{ route('isla.audiences.show', $audience) }}" class="card card--audience reveal">
            <div class="card__icon"><svg class="icon icon-lg"><use href="#{{ $audience->icon }}"/></svg></div>
            <h3>{{ $audience->title }}</h3>
            <p>{{ $audience->summary }}</p>
            <span class="btn-text" style="margin-top:12px; padding-left:0;">Learn more <svg class="icon"><use href="#i-arrow"/></svg></span>
          </a>
        @endforeach
      </div>
    </div>
  </section>

  {{-- SERVICES --}}
  <section class="section section-tight" id="services">
    <div class="container">
      <div class="section__head reveal">
        <p class="t-eyebrow" style="color:var(--rose-deep)">{{ setting('services_eyebrow', 'Services') }}</p>
        <h2 class="t-display-lg">{{ setting('services_heading', 'What your assistant can take off your plate') }}</h2>
      </div>
      <div class="grid-3">
        @foreach ($services as $service)
          <a href="{{ route('isla.services.show', $service) }}" class="card reveal">
            <div class="card__icon"><svg class="icon"><use href="#{{ $service->icon }}"/></svg></div>
            <h3>{{ $service->title }}</h3>
            <p>{{ $service->summary }}</p>
            @if (!empty($service->roles))
              <div class="svc-chips">
                @foreach (collect($service->roles)->take(3) as $role)
                  <span class="svc-chip">{{ $role }}</span>
                @endforeach
              </div>
            @endif
            <span class="btn-text" style="margin-top:12px; padding-left:0;">Learn more <svg class="icon"><use href="#i-arrow"/></svg></span>
          </a>
        @endforeach
      </div>
    </div>
  </section>

  {{-- HOW IT WORKS — sage color-block --}}
  <section class="section" id="how-it-works">
    <div class="container">
      <div class="block block-sage reveal">
        <p class="t-eyebrow">{{ setting('process_eyebrow', 'How it works') }}</p>
        <h2 class="t-headline">{{ setting('process_heading', 'How the partnership works') }}</h2>
        <p class="t-subhead" style="margin-top:10px; max-width:560px;">{{ setting('process_intro', 'A short, structured path — no lengthy procurement process, no ambiguity about what happens next.') }}</p>
        <div class="process">
          @foreach ($processSteps as $step)
            <div class="process__step">
              <span class="t-caption">{{ $step->number }} — {{ $step->title }}</span>
              <h3>{{ $step->title }}</h3>
              <p>{{ $step->summary }}</p>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </section>

  {{-- WHY ISLA — rose color-block --}}
  <section class="section" id="why-isla">
    <div class="container">
      <div class="block block-rose">
        <div class="grid-2" style="align-items:center; gap:56px;">
          <div class="reveal">
            <img src="{{ setting('why_image', 'https://images.unsplash.com/photo-1762955911431-4c44c7c3f408?w=1000&q=80&auto=format&fit=crop') }}" alt="A caregiver assisting an elderly couple" style="border-radius:var(--r-md); width:100%; aspect-ratio:4/4.6; object-fit:cover;">
          </div>
          <div class="reveal">
            <p class="t-eyebrow">{{ setting('why_eyebrow', 'Why Isla') }}</p>
            <h2 class="t-headline">{{ setting('why_heading', 'Straightforward, on purpose') }}</h2>
            <p class="t-body" style="margin-top:10px; opacity:.82;">{{ setting('why_intro', 'The staffing industry is full of hidden markups and vague replacement policies. We built Isla around the opposite.') }}</p>
            <ul class="checklist">
              @foreach ($benefits as $benefit)
                <li>
                  <span class="icon-wrap"><svg class="icon"><use href="#i-check"/></svg></span>
                  <div><strong>{{ $benefit->title }}</strong><span>{{ $benefit->summary }}</span></div>
                </li>
              @endforeach
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- PRICING --}}
  <section class="section" id="pricing">
    <div class="container">
      <div class="section__head center reveal" style="margin-left:auto; margin-right:auto;">
        <p class="t-eyebrow" style="color:var(--rose-deep)">{{ setting('pricing_eyebrow', 'Pricing') }}</p>
        <h2 class="t-display-lg">{{ setting('pricing_heading', 'Pay for hours, not for guesswork') }}</h2>
        <p class="t-body-lg" style="color:var(--ink-soft); margin-top:16px;">{{ setting('pricing_intro', 'Every engagement is scoped around your hours and sector — your discovery call gets you an exact quote.') }}</p>
      </div>
      <div class="pricing-grid">
        @foreach ($pricingPlans as $plan)
          <div class="price-card reveal {{ $plan->is_featured ? 'price-card--featured' : '' }}">
            @if ($plan->ribbon)
              <span class="price-card__ribbon">{{ $plan->ribbon }}</span>
            @endif
            <h3 class="t-card-title">{{ $plan->name }}</h3>
            <p class="price-card__tag">{{ $plan->tag }}</p>
            <p class="price-card__detail">{{ $plan->detail }}</p>
            <p>{{ $plan->summary }}</p>
            <a href="{{ route('isla.pricing.show', $plan) }}"
               class="btn {{ $plan->is_featured ? 'btn-on-dark' : 'btn-secondary' }} btn-block"
               @unless($plan->is_featured) style="border:1px solid var(--hairline);" @endunless>
              View plan details
            </a>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  {{-- FAQ — rose color-block --}}
  <section class="section" id="faq">
    <div class="container">
      <div class="block block-rose">
        <p class="t-eyebrow" style="text-align:center;">{{ setting('faq_eyebrow', 'FAQ') }}</p>
        <h2 class="t-headline" style="text-align:center;">{{ setting('faq_heading', 'Questions we get on almost every discovery call') }}</h2>
        <div class="accordion">
          @foreach ($faqs as $faq)
            <div class="accordion__item">
              <button class="accordion__trigger" aria-expanded="false"><span>{{ $faq->question }}</span><svg class="icon"><use href="#i-chevron"/></svg></button>
              <div class="accordion__panel">
                <p>
                  {{ $faq->answer }}
                  <a href="{{ route('isla.faqs.show', $faq) }}" style="display:inline-block; margin-top:10px; color:var(--rose-deep); font-weight:700; text-decoration:underline;">Read more</a>
                </p>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </section>

  {{-- CTA BAND — ink block --}}
  <section class="section" id="book-a-call">
    <div class="container">
      <div class="block block-ink reveal">
        <div class="cta-band__inner">
          <span class="icon-btn icon-btn-inverse"><svg class="icon icon-lg"><use href="#i-star"/></svg></span>
          <h2 class="t-headline">Ready to lift the admin off your team?</h2>
          <p class="t-body" style="margin-top:10px;">Book a 15-minute discovery call — no obligation, just a conversation about where the hours are going.</p>
          <a href="{{ route('isla.book-call') }}" class="btn btn-on-dark" style="margin-top:14px;">
            <svg class="icon"><use href="#i-calendar"/></svg>
            Book a Discovery Call
          </a>
          <p class="cta-band__note">Prefer to send details first? <a href="#contact">Fill out the enquiry form</a> instead.</p>
        </div>
      </div>
    </div>
  </section>

  {{-- CONTACT — rose block --}}
  <section class="section" id="contact">
    <div class="container">
      <div class="block block-rose">
        <div class="contact-grid">
          <div class="reveal">
            <p class="t-eyebrow">{{ setting('contact_eyebrow', 'Get started') }}</p>
            <h2 class="t-headline">{{ setting('contact_heading', 'Tell us about your business') }}</h2>
            <p class="t-body" style="margin-top:10px; opacity:.82;">{{ setting('contact_intro', "Send a few details and we'll come back with next steps within one business day.") }}</p>
            <ul class="contact-list">
              <li><svg class="icon"><use href="#i-mail"/></svg><a href="mailto:{{ setting('contact_email', 'hello@isla.com.au') }}">{{ setting('contact_email', 'hello@isla.com.au') }}</a></li>
              <li><svg class="icon"><use href="#i-phone"/></svg><a href="tel:{{ preg_replace('/[^0-9+]/', '', setting('contact_phone', '+61 00 0000 0000')) }}">{{ setting('contact_phone', '+61 00 0000 0000') }}</a></li>
              <li><svg class="icon"><use href="#i-pin"/></svg><span>{{ setting('contact_location', 'Supporting clients across Australia') }}</span></li>
            </ul>
          </div>
          <form class="form reveal" method="POST" action="{{ route('isla.contact') }}" style="background:var(--white); border-radius:var(--r-lg); padding:var(--sp-lg);">
            @csrf
            <div class="form__row">
              <label for="full_name">Full name</label>
              <input type="text" id="full_name" name="full_name" value="{{ old('full_name') }}" required autocomplete="name">
              @error('full_name')<span style="color:var(--rose-deep); font-size:12px;">{{ $message }}</span>@enderror
            </div>
            <div class="form__row">
              <label for="business_name">Business name</label>
              <input type="text" id="business_name" name="business_name" value="{{ old('business_name') }}" autocomplete="organization">
            </div>
            <div class="form__row form__row--split">
              <div>
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="email">
                @error('email')<span style="color:var(--rose-deep); font-size:12px;">{{ $message }}</span>@enderror
              </div>
              <div>
                <label for="phone">Phone</label>
                <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" autocomplete="tel">
              </div>
            </div>
            <div class="form__row">
              <label for="sector">Sector</label>
              <select id="sector" name="sector" required>
                <option value="" disabled {{ old('sector') ? '' : 'selected' }}>Select the closest fit</option>
                <option @selected(old('sector')==='NDIS Provider')>NDIS Provider</option>
                <option @selected(old('sector')==='Healthcare & Allied Health')>Healthcare &amp; Allied Health</option>
                <option @selected(old('sector')==='Small–Medium Business')>Small–Medium Business</option>
                <option @selected(old('sector')==='Other')>Other</option>
              </select>
            </div>
            <div class="form__row">
              <label for="message">What do you need help with?</label>
              <textarea id="message" name="message" rows="4" required>{{ old('message') }}</textarea>
              @error('message')<span style="color:var(--rose-deep); font-size:12px;">{{ $message }}</span>@enderror
            </div>
            <button type="submit" class="btn btn-primary btn-block">Request a VA <svg class="icon"><use href="#i-arrow"/></svg></button>
            @if (session('success'))
              <p class="form__success is-visible" role="status">{{ session('success') }}</p>
            @endif
          </form>
        </div>
      </div>
    </div>
  </section>

</main>
@endsection
