@extends('layouts.app')

@section('title', 'About — ' . setting('brand_word', 'Isla'))
@section('meta_description', setting('about_intro', "Isla is a managed virtual staffing partner for Australian businesses, run by a Philippines-based team."))

@section('content')
<main id="top">
  <section class="detail-hero">
    <div class="container">
      <nav class="breadcrumb" aria-label="Breadcrumb">
        <a href="{{ route('isla.index') }}">Home</a>
        <svg><use href="#i-arrow"/></svg>
        <span>About</span>
      </nav>
      <p class="t-eyebrow detail__eyebrow">{{ setting('about_eyebrow', 'About Isla') }}</p>
      <h1 class="t-display-lg">{{ setting('about_heading', "Built by people who understand the work behind business growth") }}</h1>
      <p class="t-body-lg detail__lede">{{ setting('about_intro', "Isla was built from hands-on experience supporting Australian businesses where administration, compliance, workforce coordination, documentation and client communication could not be treated as simple back-office tasks.") }}</p>
    </div>
  </section>

  {{-- TRUST BAR --}}
  <section class="section-tight" style="padding-top:24px;">
    <div class="container">
      @include('isla.partials.trust-bar')
    </div>
  </section>

  {{-- STORY --}}
  <section class="section" style="padding-top:8px;">
    <div class="container">
      <div class="grid-2" style="gap:56px; align-items:center;">
        <div class="reveal">
          <img src="{{ setting('about_image', 'https://images.unsplash.com/photo-1600880292203-757bb62b4baf?w=1000&q=80&auto=format&fit=crop') }}" alt="A virtual assistant working from a home office" style="border-radius:var(--r-md); width:100%; aspect-ratio:4/4.6; object-fit:cover;">
        </div>
        <div class="reveal">
          <p class="t-eyebrow" style="color:var(--rose-deep)">{{ setting('about_story_eyebrow', 'Our story') }}</p>
          <h2 class="t-headline">{{ setting('about_story_heading', "A managed staffing partner, not a freelancer marketplace") }}</h2>
          <div class="prose" style="margin-top:14px;">
            <p>{{ setting('about_story_body_1', "We saw capable business owners and leaders spending too much time managing recruitment, onboarding, payroll, systems, follow-ups and everyday operational work. Traditional outsourcing models often provided a candidate but left the client responsible for everything that came afterwards. Isla was created to provide a more accountable solution: capable offshore professionals supported by structured recruitment, onboarding, workforce management and ongoing operational oversight.") }}</p>
            <p>{{ setting('about_story_body_2', "With a freelancer marketplace, the service often ends after an introduction. With Isla, that is where the partnership begins. Your dedicated professional works an agreed schedule aligned with your Australian operating hours, while Isla provides the workforce infrastructure behind them — payroll administration, HR support, account management, IT assistance, productivity oversight and performance management.") }}</p>
          </div>
        </div>
      </div>
    </div>
  </section>


  {{-- VALUES — block-sage checklist, reuses Benefit content --}}
  <section class="section" style="padding-top:0;">
    <div class="container">
      <div class="block block-sage reveal">
        <div class="grid-2" style="align-items:center; gap:56px;">
          <div>
            <p class="t-eyebrow">{{ setting('about_values_eyebrow', 'What we hold ourselves to') }}</p>
            <h2 class="t-headline">{{ setting('about_values_heading', "Straightforward, on purpose") }}</h2>
            <p class="t-subhead" style="margin-top:10px; opacity:.8;">{{ setting('about_values_intro', "The same commitments show up in every engagement, regardless of sector or size.") }}</p>
          </div>
          <ul class="checklist">
            @foreach ($benefits as $benefit)
              <li>
                <span class="icon-wrap" style="background:var(--ink);"><svg class="icon"><use href="#i-check"/></svg></span>
                <div><strong>{{ $benefit->title }}</strong><span>{{ $benefit->summary }}</span></div>
              </li>
            @endforeach
          </ul>
        </div>
      </div>
    </div>
  </section>

  {{-- WHO WE WORK WITH — teaser linking to industries page --}}
  <section class="section" style="padding-top:0;">
    <div class="container">
      <div class="section__head reveal">
        <p class="t-eyebrow" style="color:var(--sage-deep)">{{ setting('audiences_eyebrow', 'Who we work with') }}</p>
        <h2 class="t-display-lg">{{ setting('about_industries_heading', 'The industries we build assistants around') }}</h2>
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
      <div style="text-align:center; margin-top:36px;">
        <a href="{{ route('isla.team.index') }}" class="btn btn-secondary" style="border:1px solid var(--hairline);">
          See the team we build for you
          <svg class="icon"><use href="#i-arrow"/></svg>
        </a>
      </div>
    </div>
  </section>

  @include('isla.partials.cta')
</main>
@endsection
