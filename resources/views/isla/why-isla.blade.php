@extends('layouts.app')

@section('title', 'Why Isla — ' . setting('brand_word', 'Isla'))
@section('meta_description', setting('why_intro', 'Straightforward, on purpose.'))

@section('content')
<main id="top">
  <section class="detail-hero">
    <div class="container">
      <nav class="breadcrumb" aria-label="Breadcrumb">
        <a href="{{ route('isla.index') }}">Home</a>
        <svg><use href="#i-arrow"/></svg>
        <span>Why Isla</span>
      </nav>
      <p class="t-eyebrow detail__eyebrow">{{ setting('why_eyebrow', 'Why Isla') }}</p>
      <h1 class="t-display-lg">{{ setting('why_heading', 'Straightforward, on purpose') }}</h1>
      <p class="t-body-lg detail__lede">{{ setting('why_intro', 'The staffing industry is full of hidden markups and vague replacement policies. We built Isla around the opposite.') }}</p>
    </div>
  </section>

  <section class="section" style="padding-top:32px;">
    <div class="container">
      <div class="block block-rose">
        <div class="grid-2" style="align-items:center; gap:56px;">
          <div class="reveal">
            <img src="{{ setting('why_image', 'https://images.unsplash.com/photo-1762955911431-4c44c7c3f408?w=1000&q=80&auto=format&fit=crop') }}" alt="A caregiver assisting an elderly couple" style="border-radius:var(--r-md); width:100%; aspect-ratio:4/4.6; object-fit:cover;">
          </div>
          <div class="reveal">
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

  {{-- COMPARISON TABLE --}}
  <section class="section section-tight">
    <div class="container">
      <div class="section__head center reveal">
        <p class="t-eyebrow" style="color:var(--sage-deep)">Side by side</p>
        <h2 class="t-display-lg">How {{ setting('brand_word', 'Isla') }} compares</h2>
      </div>
      <div class="cmp-wrap reveal">
        <table class="cmp">
          <thead>
            <tr>
              <th></th>
              <th class="cmp__isla">{{ setting('brand_word', 'Isla') }}</th>
              <th>Typical agency</th>
              <th>Local hire</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Pricing model</td>
              <td class="cmp__isla">One flat management fee</td>
              <td>Hidden % markup</td>
              <td>Salary + super + overheads</td>
            </tr>
            <tr>
              <td>Replacement if it's not working</td>
              <td class="cmp__isla"><svg class="icon"><use href="#i-check"/></svg> Lifetime guarantee</td>
              <td>30–90 days, if at all</td>
              <td>Restart recruitment</td>
            </tr>
            <tr>
              <td>Time to start</td>
              <td class="cmp__isla">~2 weeks</td>
              <td>4–6 weeks</td>
              <td>2–3 months</td>
            </tr>
            <tr>
              <td>Sector-aware onboarding (NDIS / health)</td>
              <td class="cmp__isla"><svg class="icon"><use href="#i-check"/></svg> Built in</td>
              <td>Rarely</td>
              <td>You train from scratch</td>
            </tr>
            <tr>
              <td>Named point of contact</td>
              <td class="cmp__isla"><svg class="icon"><use href="#i-check"/></svg> Always</td>
              <td>Ticket queue</td>
              <td>—</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </section>

  @include('isla.partials.cta')
</main>

@push('styles')
<style>
  .cmp-wrap{
    background:var(--white); border:1px solid var(--hairline-soft);
    border-radius:var(--r-lg); overflow-x:auto;
    box-shadow:0 24px 60px rgba(43,39,35,.07);
  }
  .cmp{ width:100%; border-collapse:collapse; min-width:640px; }
  .cmp th, .cmp td{ padding:18px 22px; text-align:left; font-size:15.5px; }
  .cmp thead th{
    font-family:var(--font-mono); font-size:12px; letter-spacing:.5px;
    text-transform:uppercase; color:var(--ink-soft);
    border-bottom:1px solid var(--hairline);
  }
  .cmp tbody td{ border-bottom:1px solid var(--hairline-soft); color:var(--ink-soft); }
  .cmp tbody tr:last-child td{ border-bottom:none; }
  .cmp tbody td:first-child{ font-weight:600; color:var(--ink); }
  .cmp .cmp__isla{
    background:var(--sage-soft); color:var(--sage-deep); font-weight:600;
  }
  .cmp thead .cmp__isla{ color:var(--sage-deep); }
  .cmp .cmp__isla .icon{ width:15px; height:15px; vertical-align:-2px; margin-right:6px; }
</style>
@endpush
@endsection
