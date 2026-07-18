@extends('layouts.app')

@section('title', 'How it Works — ' . setting('brand_word', 'Isla'))
@section('meta_description', setting('process_heading', 'From discovery call to onboarded, in about two weeks'))

@section('content')
<main id="top">
  <section class="detail-hero">
    <div class="container">
      <nav class="breadcrumb" aria-label="Breadcrumb">
        <a href="{{ route('isla.index') }}">Home</a>
        <svg><use href="#i-arrow"/></svg>
        <span>How it Works</span>
      </nav>
      <p class="t-eyebrow detail__eyebrow" style="color:var(--sage-deep)">{{ setting('process_eyebrow', 'How it works') }}</p>
      <h1 class="t-display-lg">{{ setting('process_heading', 'From discovery call to onboarded, in about two weeks') }}</h1>
      <p class="t-body-lg detail__lede">{{ setting('process_intro', 'A short, structured path — no lengthy procurement process, no ambiguity about what happens next.') }}</p>
    </div>
  </section>

  <section class="section" style="padding-top:32px;">
    <div class="container">
      <div class="hiw-timeline">
        @foreach ($processSteps as $step)
          <div class="hiw-step reveal">
            <div class="hiw-step__node">
              <span class="hiw-step__num">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div class="hiw-step__card">
              <p class="t-caption" style="color:var(--sage-deep); margin-bottom:8px;">Step {{ $loop->iteration }} of {{ $processSteps->count() }}</p>
              <h3 class="t-card-title">{{ $step->title }}</h3>
              <p style="margin-top:8px; color:var(--ink-soft);">{{ $step->summary }}</p>
            </div>
          </div>
        @endforeach
        <div class="hiw-step reveal">
          <div class="hiw-step__node hiw-step__node--end">
            <svg class="icon"><use href="#i-check"/></svg>
          </div>
          <div class="hiw-step__card hiw-step__card--end">
            <h3 class="t-card-title" style="color:var(--cream);">You're onboarded</h3>
            <p style="margin-top:8px; color:rgba(253,247,239,.75);">Your assistant is working your hours, in your systems, with a named point of contact behind them.</p>
            <a href="{{ route('isla.book-call') }}" class="btn btn-on-dark" style="margin-top:18px;">Start with a Discovery Call <svg class="icon"><use href="#i-arrow"/></svg></a>
          </div>
        </div>
      </div>
    </div>
  </section>

  @include('isla.partials.cta')
</main>

@push('styles')
<style>
  .hiw-timeline{ position:relative; max-width:840px; margin:0 auto; }
  .hiw-timeline::before{
    content:""; position:absolute; top:28px; bottom:56px; left:27px; width:2px;
    background:linear-gradient(180deg, var(--sage) 0%, var(--rose) 100%);
    opacity:.5;
  }
  .hiw-step{ display:flex; gap:28px; padding-bottom:28px; position:relative; }
  .hiw-step__node{
    flex:0 0 56px; height:56px; border-radius:var(--r-full);
    background:var(--white); border:2px solid var(--sage-deep);
    display:flex; align-items:center; justify-content:center;
    position:relative; z-index:1;
  }
  .hiw-step__num{
    font-family:var(--font-mono); font-size:16px; font-weight:700;
    color:var(--sage-deep); letter-spacing:.5px;
  }
  .hiw-step__node--end{ background:var(--ink); border-color:var(--ink); color:var(--cream); }
  .hiw-step__node--end .icon{ width:20px; height:20px; }
  .hiw-step__card{
    flex:1; background:var(--white); border:1px solid var(--hairline-soft);
    border-radius:var(--r-md); padding:26px 28px;
    transition:transform .22s ease, box-shadow .22s ease;
  }
  .hiw-step__card:hover{ transform:translateX(4px); box-shadow:0 14px 32px rgba(43,39,35,.09); }
  .hiw-step__card--end{ background:var(--ink); border-color:var(--ink); }
  @media (max-width: 640px){
    .hiw-timeline::before{ left:21px; }
    .hiw-step{ gap:16px; }
    .hiw-step__node{ flex-basis:44px; height:44px; }
    .hiw-step__card{ padding:20px; }
  }
</style>
@endpush
@endsection
