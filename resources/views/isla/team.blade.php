@extends('layouts.app')

@section('title', 'Team We Build — ' . setting('brand_word', 'Isla'))
@section('meta_description', setting('team_intro', 'The roles Isla places, and how they come together into a team around your business.'))

@section('content')
<main id="top">
  <section class="detail-hero">
    <div class="container">
      <nav class="breadcrumb" aria-label="Breadcrumb">
        <a href="{{ route('isla.index') }}">Home</a>
        <svg><use href="#i-arrow"/></svg>
        <span>Team We Build</span>
      </nav>
      <p class="t-eyebrow detail__eyebrow">{{ setting('team_eyebrow', 'Team we build') }}</p>
      <h1 class="t-display-lg">{{ setting('team_heading', 'The team we build around your business') }}</h1>
      <p class="t-body-lg detail__lede">{{ setting('team_intro', "Start with one dedicated assistant covering the roles below, or scope a small rostered team on the Dedicated plan — either way, every role is matched, briefed, and managed by Isla.") }}</p>
    </div>
  </section>

  {{-- ROLE GRID --}}
  <section class="section" style="padding-top:24px;">
    <div class="container">
      <div class="grid-2" style="gap:20px;">
        @foreach ($services as $service)
          <div class="role-card reveal">
            <div class="card__icon"><svg class="icon"><use href="#{{ $service->icon }}"/></svg></div>
            <div>
              <h3>{{ $service->title }}</h3>
              <p>{{ $service->summary }}</p>
              @if (!empty($service->roles))
                <div class="svc-chips" style="margin-top:10px;">
                  @foreach (collect($service->roles)->take(3) as $role)
                    <span class="svc-chip">{{ $role }}</span>
                  @endforeach
                </div>
              @endif
              <a href="{{ route('isla.services.show', $service) }}" class="btn-text" style="margin-top:10px; padding-left:0;">What's included <svg class="icon"><use href="#i-arrow"/></svg></a>
            </div>
          </div>
        @endforeach
        <div class="role-card reveal" style="background:var(--rose-soft); border-color:transparent;">
          <div class="card__icon" style="background:var(--white);"><svg class="icon"><use href="#i-hardhat"/></svg></div>
          <div>
            <h3>{{ setting('team_construction_title', 'Construction & Trades Admin') }}</h3>
            <p>{{ setting('team_construction_summary', 'Quoting follow-ups, subcontractor scheduling, procurement paperwork, and compliance documentation kept moving between site and office.') }}</p>
            <a href="{{ route('isla.audiences.show', ['audience' => 'construction-trades']) }}" class="btn-text" style="margin-top:10px; padding-left:0;">See how it works for your sector <svg class="icon"><use href="#i-arrow"/></svg></a>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- HOW WE BUILD IT — sage block, reuses process steps --}}
  <section class="section">
    <div class="container">
      <div class="block block-sage reveal">
        <p class="t-eyebrow">{{ setting('team_process_eyebrow', 'How we build your team') }}</p>
        <h2 class="t-headline">{{ setting('team_process_heading', 'Matched to your sector, not assigned from a queue') }}</h2>
        <p class="t-subhead" style="margin-top:10px; max-width:560px;">{{ setting('team_process_intro', 'The same discovery-to-onboarded path applies whether you need one assistant or a small rostered team.') }}</p>
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

  {{-- TRUST BAR --}}
  <section class="section-tight" style="padding-top:0;">
    <div class="container">
      @include('isla.partials.trust-bar')
    </div>
  </section>

  @include('isla.partials.cta')
</main>
@endsection
