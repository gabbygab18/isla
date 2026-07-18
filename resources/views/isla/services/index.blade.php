@extends('layouts.app')

@section('title', 'Services — ' . setting('brand_word', 'Isla'))
@section('meta_description', setting('services_heading', 'What your assistant can take off your plate'))

@section('content')
<main id="top">
  <section class="detail-hero">
    <div class="container">
      <nav class="breadcrumb" aria-label="Breadcrumb">
        <a href="{{ route('isla.index') }}">Home</a>
        <svg><use href="#i-arrow"/></svg>
        <span>Services</span>
      </nav>
      <p class="t-eyebrow detail__eyebrow">{{ setting('services_eyebrow', 'Services') }}</p>
      <h1 class="t-display-lg">{{ setting('services_heading', 'What your assistant can take off your plate') }}</h1>
      <p class="t-body-lg detail__lede">Pick any service to see exactly what your assistant handles and what's included.</p>
    </div>
  </section>

  <section class="section" style="padding-top:32px;">
    <div class="container">
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
                @if (count($service->roles) > 3)
                  <span class="svc-chip svc-chip--more">+{{ count($service->roles) - 3 }} more</span>
                @endif
              </div>
            @endif
            <span class="btn-text" style="margin-top:12px; padding-left:0;">Learn more <svg class="icon"><use href="#i-arrow"/></svg></span>
          </a>
        @endforeach
      </div>
    </div>
  </section>

  @include('isla.partials.cta')
</main>
@endsection
