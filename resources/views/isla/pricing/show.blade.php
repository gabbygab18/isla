@extends('layouts.app')

@section('title', $plan->name . ' plan — Isla Virtual Staffing')
@section('meta_description', $plan->summary)

@section('content')
<main id="top">
  <section class="detail-hero">
    <div class="container">
      <nav class="breadcrumb" aria-label="Breadcrumb">
        <a href="{{ route('isla.index') }}">Home</a>
        <svg><use href="#i-arrow"/></svg>
        <a href="{{ route('isla.index') }}#pricing">Pricing</a>
        <svg><use href="#i-arrow"/></svg>
        <span>{{ $plan->name }}</span>
      </nav>
      <p class="t-eyebrow detail__eyebrow">{{ $plan->tag }}</p>
      <h1 class="t-display-lg">{{ $plan->name }} @if($plan->ribbon)<span class="price-card__ribbon" style="position:static; display:inline-block; vertical-align:middle; margin-left:10px;">{{ $plan->ribbon }}</span>@endif</h1>
      <p class="plan-detail__price">{{ $plan->detail }}</p>
      <p class="t-body-lg detail__lede">{{ $plan->summary }}</p>
    </div>
  </section>

  <section class="section" style="padding-top:24px;">
    <div class="container">
      <div class="detail__layout">
        <div class="reveal">
          <div class="prose">
            @foreach (preg_split('/\n\n+/', $plan->body) as $para)
              <p>{{ $para }}</p>
            @endforeach
          </div>

          @if (!empty($plan->features))
            <h3 class="t-card-title" style="margin:32px 0 16px;">What's included</h3>
            <ul class="detail__list">
              @foreach ($plan->features as $feature)
                <li><span class="icon-wrap"><svg class="icon"><use href="#i-check"/></svg></span><span>{{ $feature }}</span></li>
              @endforeach
            </ul>
          @endif
        </div>

        <aside class="detail__aside reveal">
          <h3>Request a quote</h3>
          <p>Every engagement is scoped to your hours and sector. Your discovery call gets you an exact quote.</p>
          <a href="{{ route('isla.index') }}#contact" class="btn btn-primary btn-block" style="margin-bottom:12px;">Request a quote</a>
          <a href="{{ route('isla.index') }}#book-a-call" class="btn btn-secondary btn-block" style="border:1px solid var(--hairline);">
            <svg class="icon"><use href="#i-calendar"/></svg> Book a call
          </a>
        </aside>
      </div>
    </div>
  </section>

  @if ($others->isNotEmpty())
    <section class="section" style="padding-top:0;">
      <div class="container">
        <div class="section__head related-head reveal">
          <p class="t-eyebrow" style="color:var(--rose-deep)">Compare plans</p>
          <h2 class="t-headline">Other ways to work with Isla</h2>
        </div>
        <div class="pricing-grid">
          @foreach ($others as $item)
            <div class="price-card reveal {{ $item->is_featured ? 'price-card--featured' : '' }}">
              @if ($item->ribbon)
                <span class="price-card__ribbon">{{ $item->ribbon }}</span>
              @endif
              <h3 class="t-card-title">{{ $item->name }}</h3>
              <p class="price-card__tag">{{ $item->tag }}</p>
              <p class="price-card__detail">{{ $item->detail }}</p>
              <p>{{ $item->summary }}</p>
              <a href="{{ route('isla.pricing.show', $item) }}"
                 class="btn {{ $item->is_featured ? 'btn-on-dark' : 'btn-secondary' }} btn-block"
                 @unless($item->is_featured) style="border:1px solid var(--hairline);" @endunless>
                View plan details
              </a>
            </div>
          @endforeach
        </div>
      </div>
    </section>
  @endif
</main>
@endsection
