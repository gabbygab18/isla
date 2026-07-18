@extends('layouts.app')

@section('title', $service->title . ' — Isla Virtual Staffing')
@section('meta_description', $service->summary)

@section('content')
<main id="top">
  <section class="detail-hero">
    <div class="container">
      <nav class="breadcrumb" aria-label="Breadcrumb">
        <a href="{{ route('isla.index') }}">Home</a>
        <svg><use href="#i-arrow"/></svg>
        <a href="{{ route('isla.index') }}#services">Services</a>
        <svg><use href="#i-arrow"/></svg>
        <span>{{ $service->title }}</span>
      </nav>
      <p class="t-eyebrow detail__eyebrow">Services</p>
      <h1 class="t-display-lg">{{ $service->title }}</h1>
      <p class="t-body-lg detail__lede">{{ $service->summary }}</p>
    </div>
  </section>

  <section class="section" style="padding-top:24px;">
    <div class="container">
      <div class="detail__layout">
        <div class="reveal">
          <div class="detail__icon"><svg class="icon icon-lg"><use href="#{{ $service->icon }}"/></svg></div>
          <div class="prose">
            @foreach (preg_split('/\n\n+/', $service->body) as $para)
              <p>{{ $para }}</p>
            @endforeach
          </div>

          @if (!empty($service->deliverables))
            <h3 class="t-card-title" style="margin:32px 0 16px;">What's included</h3>
            <ul class="detail__list">
              @foreach ($service->deliverables as $item)
                <li><span class="icon-wrap"><svg class="icon"><use href="#i-check"/></svg></span><span>{{ $item }}</span></li>
              @endforeach
            </ul>
          @endif
        </div>

        <aside class="detail__aside reveal">
          <h3>Hand this off</h3>
          <p>Tell us what's eating your hours and we'll match an assistant who can take it on.</p>
          <a href="{{ route('isla.index') }}#book-a-call" class="btn btn-primary btn-block" style="margin-bottom:12px;">
            <svg class="icon"><use href="#i-calendar"/></svg> Book a Discovery Call
          </a>
          <a href="{{ route('isla.index') }}#contact" class="btn btn-secondary btn-block" style="border:1px solid var(--hairline);">Request a VA</a>
        </aside>
      </div>
    </div>
  </section>

  @if (!empty($service->roles))
    <section class="section roles-section">
      <div class="container">
        <div class="section__head center reveal">
          <p class="t-eyebrow" style="color:var(--sage-deep)">Roles we support</p>
          <h2 class="t-display-lg">{{ $service->title }} roles you can outsource</h2>
          <p class="t-body-lg" style="max-width:720px; margin:16px auto 0; opacity:.8;">
            Every role below can be filled by a dedicated Isla assistant — matched to your business,
            working your hours, backed by our lifetime replacement guarantee.
          </p>
        </div>
        <div class="roles-grid">
          @foreach ($service->roles as $role)
            <div class="rw-card reveal">
              <span class="rw-card__check"><svg class="icon"><use href="#i-check"/></svg></span>
              <h3 class="rw-card__title">{{ $role }}</h3>
              <p class="rw-card__meta">Dedicated · Full-time or part-time · AU business hours</p>
            </div>
          @endforeach
        </div>
        <div class="roles-cta reveal">
          <p class="t-body" style="opacity:.75;">Don't see the exact role you need? We build custom roles all the time.</p>
          <a href="{{ route('isla.book-call') }}" class="btn btn-primary">
            <svg class="icon"><use href="#i-calendar"/></svg> Book a Discovery Call
          </a>
        </div>
      </div>
    </section>
  @endif

  @if ($related->isNotEmpty())
    <section class="section" style="padding-top:0;">
      <div class="container">
        <div class="section__head related-head reveal">
          <p class="t-eyebrow" style="color:var(--rose-deep)">More services</p>
          <h2 class="t-headline">Other things your assistant can take on</h2>
        </div>
        <div class="grid-3">
          @foreach ($related as $item)
            <a href="{{ route('isla.services.show', $item) }}" class="card reveal">
              <div class="card__icon"><svg class="icon"><use href="#{{ $item->icon }}"/></svg></div>
              <h3>{{ $item->title }}</h3>
              <p>{{ $item->summary }}</p>
              <span class="btn-text" style="margin-top:12px; padding-left:0;">Learn more <svg class="icon"><use href="#i-arrow"/></svg></span>
            </a>
          @endforeach
        </div>
      </div>
    </section>
  @endif
</main>
@endsection

@push('styles')
<style>
  /* Roles we support — service detail */
  .roles-section{ padding-top:0; }
  .roles-grid{
    display:grid; grid-template-columns:repeat(3,1fr); gap:20px; margin-top:40px;
  }
  .rw-card{
    position:relative;
    background:var(--ink);
    color:var(--cream);
    border-radius:var(--r-md);
    padding:28px 26px 24px;
    overflow:hidden;
    transition:transform .22s ease, box-shadow .22s ease;
  }
  .rw-card::before{
    content:""; position:absolute; inset:0 auto 0 0; width:4px;
    background:linear-gradient(180deg, var(--rose) 0%, var(--sage) 100%);
  }
  .rw-card:hover{ transform:translateY(-4px); box-shadow:0 18px 36px rgba(43,39,35,.22); }
  .rw-card__check{
    display:inline-flex; align-items:center; justify-content:center;
    width:34px; height:34px; border-radius:var(--r-full);
    background:var(--sage-deep); color:var(--cream); margin-bottom:14px;
  }
  .rw-card__check .icon{ width:16px; height:16px; }
  .rw-card__title{
    font-size:20px; font-weight:700; line-height:1.3; letter-spacing:-0.2px;
    margin:0 0 8px; color:var(--rose);
  }
  .rw-card__meta{
    font-family:var(--font-mono); font-size:11.5px; letter-spacing:.5px;
    text-transform:uppercase; color:rgba(253,247,239,.55); margin:0;
  }
  .roles-cta{
    display:flex; align-items:center; justify-content:space-between; gap:24px;
    flex-wrap:wrap; margin-top:36px; padding:24px 28px;
    background:var(--sage-soft); border-radius:var(--r-lg);
  }
  @media (max-width: 960px){ .roles-grid{ grid-template-columns:repeat(2,1fr); } }
  @media (max-width: 640px){
    .roles-grid{ grid-template-columns:1fr; }
    .roles-cta{ flex-direction:column; align-items:flex-start; }
  }
</style>
@endpush
