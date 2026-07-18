@extends('layouts.app')

@section('title', 'Who we work with — ' . setting('brand_word', 'Isla'))
@section('meta_description', setting('audiences_intro', 'Built around groups whose paperwork carries risk.'))

@section('content')
<main id="top">
  <section class="detail-hero">
    <div class="container">
      <nav class="breadcrumb" aria-label="Breadcrumb">
        <a href="{{ route('isla.index') }}">Home</a>
        <svg><use href="#i-arrow"/></svg>
        <span>Who we work with</span>
      </nav>
      <p class="t-eyebrow detail__eyebrow" style="color:var(--sage-deep)">{{ setting('audiences_eyebrow', 'Who we work with') }}</p>
      <h1 class="t-display-lg">{{ setting('audiences_heading', "Built for the work that can't be generic") }}</h1>
      <p class="t-body-lg detail__lede">{{ setting('audiences_intro', 'Most virtual staffing agencies are horizontal generalists. Isla is built around three groups whose paperwork actually carries risk.') }}</p>
    </div>
  </section>

  <section class="section" style="padding-top:32px;">
    <div class="container">
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

  @include('isla.partials.cta')
</main>
@endsection
