@extends('layouts.app')

@section('title', 'Contact — ' . setting('brand_word', 'Isla'))
@section('meta_description', setting('contact_intro', 'Tell us about your business.'))

@section('content')
<main id="top">
  <section class="detail-hero">
    <div class="container">
      <nav class="breadcrumb" aria-label="Breadcrumb">
        <a href="{{ route('isla.index') }}">Home</a>
        <svg><use href="#i-arrow"/></svg>
        <span>Contact</span>
      </nav>
    </div>
  </section>

  <section class="section" id="contact" style="padding-top:16px;">
    <div class="container">
      <div class="block block-rose">
        <div class="contact-grid">
          <div class="reveal">
            <p class="t-eyebrow">{{ setting('contact_eyebrow', 'Get started') }}</p>
            <h2 class="t-headline">{{ setting('contact_heading', 'Tell us about your business') }}</h2>
            <p class="t-body" style="margin-top:10px; opacity:.82;">{{ setting('contact_intro', "Send a few details and we'll come back with next steps within one business day.") }}</p>
            <ul class="contact-list">
              <li><svg class="icon"><use href="#i-mail"/></svg><a href="mailto:{{ setting('contact_email', 'hello@isla.com.au') }}">{{ setting('contact_email', 'hello@isla.com.au') }}</a></li>
              <li><svg class="icon"><use href="#i-phone"/></svg><a href="tel:{{ preg_replace('/[^0-9+]/', '', setting('contact_phone', '+61 00 0000 0000')) }}">{{ setting('contact_phone', '+61 00 0000 0000') }}</a></li>
              <li><svg class="icon"><use href="#i-pin"/></svg><span>{{ setting('contact_location', 'Supporting clients across Australia') }}</span></li>
            </ul>
          </div>
          <form class="form reveal" method="POST" action="{{ route('isla.contact') }}" style="background:var(--white); border-radius:var(--r-lg); padding:var(--sp-lg);">
            @csrf
            <div class="form__row">
              <label for="full_name">Full name</label>
              <input type="text" id="full_name" name="full_name" value="{{ old('full_name') }}" required autocomplete="name">
              @error('full_name')<span style="color:var(--rose-deep); font-size:12px;">{{ $message }}</span>@enderror
            </div>
            <div class="form__row">
              <label for="business_name">Business name</label>
              <input type="text" id="business_name" name="business_name" value="{{ old('business_name') }}" autocomplete="organization">
            </div>
            <div class="form__row form__row--split">
              <div>
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="email">
                @error('email')<span style="color:var(--rose-deep); font-size:12px;">{{ $message }}</span>@enderror
              </div>
              <div>
                <label for="phone">Phone</label>
                <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" autocomplete="tel">
              </div>
            </div>
            <div class="form__row">
              <label for="sector">Sector</label>
              <select id="sector" name="sector" required>
                <option value="" disabled {{ old('sector') ? '' : 'selected' }}>Select the closest fit</option>
                <option @selected(old('sector')==='NDIS Provider')>NDIS Provider</option>
                <option @selected(old('sector')==='Healthcare & Allied Health')>Healthcare &amp; Allied Health</option>
                <option @selected(old('sector')==='Small–Medium Business')>Small–Medium Business</option>
                <option @selected(old('sector')==='Other')>Other</option>
              </select>
            </div>
            <div class="form__row">
              <label for="message">What do you need help with?</label>
              <textarea id="message" name="message" rows="4" required>{{ old('message') }}</textarea>
              @error('message')<span style="color:var(--rose-deep); font-size:12px;">{{ $message }}</span>@enderror
            </div>
            <button type="submit" class="btn btn-primary btn-block">Request a VA <svg class="icon"><use href="#i-arrow"/></svg></button>
            @if (session('success'))
              <p class="form__success is-visible" role="status">{{ session('success') }}</p>
            @endif
          </form>
        </div>
      </div>
    </div>
  </section>
</main>
@endsection
