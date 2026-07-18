@extends('layouts.app')

@section('title', 'Pricing — ' . setting('brand_word', 'Isla'))
@section('meta_description', setting('pricing_intro', 'Pay for hours, not for guesswork.'))

@section('content')
<main id="top">
  <section class="detail-hero">
    <div class="container">
      <nav class="breadcrumb" aria-label="Breadcrumb">
        <a href="{{ route('isla.index') }}">Home</a>
        <svg><use href="#i-arrow"/></svg>
        <span>Pricing</span>
      </nav>
      <p class="t-eyebrow detail__eyebrow">{{ setting('pricing_eyebrow', 'Pricing') }}</p>
      <h1 class="t-display-lg">{{ setting('pricing_heading', 'Pay for hours, not for guesswork') }}</h1>
      <p class="t-body-lg detail__lede">{{ setting('pricing_intro', 'Every engagement is scoped around your hours and sector — your discovery call gets you an exact quote.') }}</p>
    </div>
  </section>

  <section class="section" style="padding-top:32px;">
    <div class="container">
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

      {{-- Always included --}}
      <div class="inc-strip reveal">
        <p class="t-caption" style="color:var(--sage-deep);">Included in every plan</p>
        <ul class="inc-strip__list">
          <li><svg class="icon"><use href="#i-check"/></svg> One flat management fee</li>
          <li><svg class="icon"><use href="#i-check"/></svg> Lifetime replacement guarantee</li>
          <li><svg class="icon"><use href="#i-check"/></svg> Named point of contact</li>
          <li><svg class="icon"><use href="#i-check"/></svg> AU business-hours overlap</li>
        </ul>
      </div>

      {{-- Estimator link --}}
      <div class="est-link reveal">
        <div>
          <h3 class="t-headline">Want a number, not a plan name?</h3>
          <p class="t-body" style="opacity:.75; margin-top:6px;">Build your exact role — or a whole team — in the cost estimator.</p>
        </div>
        <a href="{{ route('isla.cost-estimator') }}" class="btn btn-primary">
          <svg class="icon"><use href="#i-calculator"/></svg> Open the Cost Estimator
        </a>
      </div>
    </div>
  </section>

  @include('isla.partials.cta')
</main>

@push('styles')
<style>
  .inc-strip{
    margin-top:28px; padding:22px 28px; text-align:center;
    background:var(--white); border:1px solid var(--hairline-soft); border-radius:var(--r-lg);
  }
  .inc-strip__list{
    display:flex; flex-wrap:wrap; justify-content:center; gap:14px 32px; margin-top:12px;
  }
  .inc-strip__list li{
    display:flex; align-items:center; gap:8px;
    font-size:15.5px; font-weight:600; color:var(--ink);
  }
  .inc-strip__list .icon{ width:16px; height:16px; color:var(--sage-deep); }
  .est-link{
    margin-top:20px; padding:26px 30px;
    display:flex; align-items:center; justify-content:space-between; gap:24px; flex-wrap:wrap;
    background:var(--sage-soft); border-radius:var(--r-lg);
  }
  @media (max-width:640px){ .est-link{ flex-direction:column; align-items:flex-start; } }
</style>
@endpush
@endsection
