@extends('layouts.app')

@section('title', $audience->title . ' — Isla Virtual Staffing')
@section('meta_description', $audience->summary)

@section('content')
<main id="top">
  <section class="detail-hero">
    <div class="container">
      <nav class="breadcrumb" aria-label="Breadcrumb">
        <a href="{{ route('isla.index') }}">Home</a>
        <svg><use href="#i-arrow"/></svg>
        <a href="{{ route('isla.index') }}#who-its-for">Who we work with</a>
        <svg><use href="#i-arrow"/></svg>
        <span>{{ $audience->title }}</span>
      </nav>
      <p class="t-eyebrow detail__eyebrow">Who we work with</p>
      <h1 class="t-display-lg">{{ $audience->title }}</h1>
      <p class="t-body-lg detail__lede">{{ $audience->summary }}</p>
    </div>
  </section>

  <section class="section" style="padding-top:24px;">
    <div class="container">
      <div class="detail__layout">
        <div class="reveal">
          <div class="detail__icon"><svg class="icon icon-lg"><use href="#{{ $audience->icon }}"/></svg></div>
          <div class="prose">
            @foreach (preg_split('/\n\n+/', $audience->body) as $para)
              <p>{{ $para }}</p>
            @endforeach
          </div>

          @if (!empty($audience->points))
            <ul class="detail__list">
              @foreach ($audience->points as $point)
                <li><span class="icon-wrap"><svg class="icon"><use href="#i-check"/></svg></span><span>{{ $point }}</span></li>
              @endforeach
            </ul>
          @endif
        </div>

        <aside class="detail__aside reveal">
          <h3>Work with Isla</h3>
          <p>Book a 20-minute discovery call and we'll scope an assistant around your sector and hours.</p>
          <a href="{{ route('isla.index') }}#book-a-call" class="btn btn-primary btn-block" style="margin-bottom:12px;">
            <svg class="icon"><use href="#i-calendar"/></svg> Book a Discovery Call
          </a>
          <a href="{{ route('isla.index') }}#contact" class="btn btn-secondary btn-block" style="border:1px solid var(--hairline);">Send an enquiry</a>
        </aside>
      </div>
    </div>
  </section>

  @if ($related->isNotEmpty())
    <section class="section" style="padding-top:0;">
      <div class="container">
        <div class="section__head related-head reveal">
          <p class="t-eyebrow" style="color:var(--sage-deep)">Also a fit for</p>
          <h2 class="t-headline">Other groups we work with</h2>
        </div>
        <div class="grid-3">
          @foreach ($related as $item)
            <a href="{{ route('isla.audiences.show', $item) }}" class="card card--audience reveal">
              <div class="card__icon"><svg class="icon icon-lg"><use href="#{{ $item->icon }}"/></svg></div>
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
