@extends('layouts.app')

@section('title', $faq->question . ' — Isla FAQ')
@section('meta_description', \Illuminate\Support\Str::limit($faq->answer, 155))

@section('content')
<main id="top">
  <section class="detail-hero">
    <div class="container">
      <nav class="breadcrumb" aria-label="Breadcrumb">
        <a href="{{ route('isla.index') }}">Home</a>
        <svg><use href="#i-arrow"/></svg>
        <a href="{{ route('isla.index') }}#faq">FAQ</a>
        <svg><use href="#i-arrow"/></svg>
        <span>{{ \Illuminate\Support\Str::limit($faq->question, 40) }}</span>
      </nav>
      <p class="t-eyebrow detail__eyebrow">Frequently asked</p>
      <h1 class="t-display-lg">{{ $faq->question }}</h1>
    </div>
  </section>

  <section class="section" style="padding-top:24px;">
    <div class="container">
      <div class="detail__layout">
        <div class="reveal">
          <div class="prose">
            @foreach (preg_split('/\n\n+/', $faq->answer) as $para)
              <p>{{ $para }}</p>
            @endforeach
          </div>
        </div>

        <aside class="detail__aside reveal">
          <h3>Still have questions?</h3>
          <p>The quickest answer is usually a short call. We'll walk you through anything specific to your sector.</p>
          <a href="{{ route('isla.index') }}#book-a-call" class="btn btn-primary btn-block" style="margin-bottom:12px;">
            <svg class="icon"><use href="#i-calendar"/></svg> Book a Discovery Call
          </a>
          <a href="{{ route('isla.index') }}#contact" class="btn btn-secondary btn-block" style="border:1px solid var(--hairline);">Send an enquiry</a>
        </aside>
      </div>
    </div>
  </section>

  @if ($others->isNotEmpty())
    <section class="section" style="padding-top:0;">
      <div class="container">
        <div class="block block-rose">
          <p class="t-eyebrow" style="text-align:center;">More answers</p>
          <h2 class="t-headline" style="text-align:center;">Other common questions</h2>
          <div class="accordion">
            @foreach ($others as $item)
              <div class="accordion__item">
                <button class="accordion__trigger" aria-expanded="false"><span>{{ $item->question }}</span><svg class="icon"><use href="#i-chevron"/></svg></button>
                <div class="accordion__panel">
                  <p>
                    {{ $item->answer }}
                    <a href="{{ route('isla.faqs.show', $item) }}" style="display:inline-block; margin-top:10px; color:var(--rose-deep); font-weight:700; text-decoration:underline;">Read more</a>
                  </p>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </section>
  @endif
</main>
@endsection
