@extends('layouts.app')

@section('title', 'FAQ — ' . setting('brand_word', 'Isla'))
@section('meta_description', setting('faq_heading', 'Questions we get on almost every discovery call'))

@section('content')
<main id="top">
  <section class="detail-hero">
    <div class="container">
      <nav class="breadcrumb" aria-label="Breadcrumb">
        <a href="{{ route('isla.index') }}">Home</a>
        <svg><use href="#i-arrow"/></svg>
        <span>FAQ</span>
      </nav>
      <p class="t-eyebrow detail__eyebrow">{{ setting('faq_eyebrow', 'FAQ') }}</p>
      <h1 class="t-display-lg">{{ setting('faq_heading', 'Questions we get on almost every discovery call') }}</h1>
    </div>
  </section>

  <section class="section" style="padding-top:32px;">
    <div class="container">
      <div class="faq-search reveal">
        <svg class="icon"><use href="#i-target"/></svg>
        <input type="search" id="faqSearch" placeholder="Search a question — e.g. replacement, pricing, time zone..." aria-label="Search FAQs">
      </div>
      <div class="block block-rose">
        <div class="accordion" id="faqList">
          @foreach ($faqs as $faq)
            <div class="accordion__item" data-q="{{ Str::lower($faq->question . ' ' . $faq->answer) }}">
              <button class="accordion__trigger" aria-expanded="false"><span>{{ $faq->question }}</span><svg class="icon"><use href="#i-chevron"/></svg></button>
              <div class="accordion__panel">
                <p>
                  {{ $faq->answer }}
                  <a href="{{ route('isla.faqs.show', $faq) }}" style="display:inline-block; margin-top:10px; color:var(--rose-deep); font-weight:700; text-decoration:underline;">Read more</a>
                </p>
              </div>
            </div>
          @endforeach
        </div>
        <p id="faqNoResults" class="t-body" style="text-align:center; padding:24px 0 8px; opacity:.75;" hidden>
          No matches — try a different word, or <a href="{{ route('isla.book-call') }}" style="font-weight:700; text-decoration:underline;">ask us on a discovery call</a>.
        </p>
      </div>
    </div>
  </section>

  @include('isla.partials.cta')
</main>

@push('styles')
<style>
  .faq-search{
    display:flex; align-items:center; gap:12px;
    background:var(--white); border:1px solid var(--hairline);
    border-radius:var(--r-pill); padding:6px 8px 6px 22px;
    max-width:640px; margin:0 auto 28px;
  }
  .faq-search .icon{ width:18px; height:18px; color:var(--ink-soft); flex-shrink:0; }
  .faq-search input{
    flex:1; border:none; background:none; outline:none;
    font-family:var(--font-sans); font-size:16.5px; color:var(--ink);
    padding:11px 0;
  }
</style>
@endpush

@push('scripts')
<script>
(function(){
  var input = document.getElementById('faqSearch');
  var items = document.querySelectorAll('#faqList .accordion__item');
  var none  = document.getElementById('faqNoResults');
  if (!input) return;
  input.addEventListener('input', function(){
    var q = input.value.trim().toLowerCase();
    var shown = 0;
    items.forEach(function(it){
      var hit = q === '' || (it.dataset.q || '').indexOf(q) !== -1;
      it.style.display = hit ? '' : 'none';
      if (hit) shown++;
    });
    none.hidden = shown !== 0;
  });
})();
</script>
@endpush
@endsection
