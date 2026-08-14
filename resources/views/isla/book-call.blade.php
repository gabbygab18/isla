@extends('layouts.app')

@section('title', 'Book a Discovery Call — ' . setting('brand_word', 'Isla'))
@section('meta_description', setting('book_intro', "A free 15-minute call to work out what your assistant should own first — no obligation, no card."))

@section('content')
<main id="top">
  <section class="detail-hero">
    <div class="container">
      <nav class="breadcrumb" aria-label="Breadcrumb">
        <a href="{{ route('isla.index') }}">Home</a>
        <svg><use href="#i-arrow"/></svg>
        <span>Book a Discovery Call</span>
      </nav>
      <p class="t-eyebrow detail__eyebrow">{{ setting('book_eyebrow', 'Book a discovery call') }}</p>
      <h1 class="t-display-lg">{{ setting('book_heading', "A real conversation about where your hours are going") }}</h1>
      <p class="t-body-lg detail__lede">{{ setting('book_intro', "Tell us what's taking up your time. We'll tell you what an assistant can take off your plate, roughly what it costs, and whether it's the right fit — including if it isn't.") }}</p>
      <ul class="checklist" style="margin-top:28px; flex-direction:row; flex-wrap:wrap; gap:28px;">
        <li style="align-items:center;">
          <span class="icon-wrap" style="background:var(--sage-deep);"><svg class="icon"><use href="#i-clock"/></svg></span>
          <span style="font-size:14.5px; font-weight:600;">15 minutes, video or phone</span>
        </li>
        <li style="align-items:center;">
          <span class="icon-wrap" style="background:var(--sage-deep);"><svg class="icon"><use href="#i-check"/></svg></span>
          <span style="font-size:14.5px; font-weight:600;">No obligation, no card required</span>
        </li>
        <li style="align-items:center;">
          <span class="icon-wrap" style="background:var(--sage-deep);"><svg class="icon"><use href="#i-target"/></svg></span>
          <span style="font-size:14.5px; font-weight:600;">Walk away with a clear next step either way</span>
        </li>
      </ul>
    </div>
  </section>

  {{-- BOOKING CALENDAR — Calendly-style scheduler --}}
  <section class="section" id="schedule" style="padding-top:32px;">
    <div class="container">
      @if (setting('calendly_url'))
        {{-- Live Calendly inline embed (set calendly_url in Admin → Settings) --}}
        <div class="cal-embed reveal">
          <div class="calendly-inline-widget" data-url="{{ setting('calendly_url') }}" style="min-width:320px; height:700px;"></div>
          <script src="https://assets.calendly.com/assets/external/widget.js" async></script>
        </div>
      @else
        <div class="scheduler reveal" id="scheduler">
          {{-- LEFT — call details --}}
          <div class="scheduler__info">
            <div class="scheduler__brand">
              <img src="{{ asset('logo.png') }}" alt="{{ setting('brand_word', 'Isla') }}">
            </div>
            <p class="t-caption" style="color:var(--ink-soft);">{{ setting('brand_word', 'Isla') }} Virtual Staffing</p>
            <h2 class="scheduler__title">Discovery Call</h2>
            <ul class="scheduler__meta">
              <li><svg class="icon"><use href="#i-clock"/></svg><span>15 min</span></li>
              <li><svg class="icon"><use href="#i-headset"/></svg><span>Video or phone — your pick</span></li>
              <li><svg class="icon"><use href="#i-globe"/></svg><span id="schedTz">Australian Eastern Time</span></li>
            </ul>
            <p class="t-body-sm" style="opacity:.7; margin-top:20px;">
              Pick a day and time that suits you. We'll confirm by email within one business day.
            </p>
          </div>

          {{-- MIDDLE — calendar --}}
          <div class="scheduler__calendar">
            <p class="scheduler__step">Select a Day</p>
            <div class="cal">
              <div class="cal__head">
                <button type="button" class="cal__nav" id="calPrev" aria-label="Previous month"><svg class="icon"><use href="#i-chevron"/></svg></button>
                <span class="cal__month" id="calMonth"></span>
                <button type="button" class="cal__nav" id="calNext" aria-label="Next month"><svg class="icon"><use href="#i-chevron"/></svg></button>
              </div>
              <div class="cal__dow">
                <span>Mon</span><span>Tue</span><span>Wed</span><span>Thu</span><span>Fri</span><span>Sat</span><span>Sun</span>
              </div>
              <div class="cal__grid" id="calGrid"></div>
            </div>
          </div>

          {{-- RIGHT — time slots --}}
          <div class="scheduler__slots" id="slotPanel">
            <p class="scheduler__step" id="slotHeading">Select a Time</p>
            <p class="t-body-sm scheduler__slots-hint" id="slotHint">Choose a day on the calendar to see available times.</p>
            <div class="slot-list" id="slotList" role="listbox" aria-label="Available times"></div>
          </div>
        </div>

        {{-- Confirmation strip --}}
        <div class="scheduler__confirm" id="schedConfirm" hidden>
          <div>
            <p class="t-caption" style="color:var(--sage-deep); margin-bottom:6px;">Your preferred time</p>
            <p class="scheduler__confirm-text" id="schedConfirmText"></p>
          </div>
          <a href="#book" class="btn btn-primary" id="schedConfirmBtn">
            Confirm &amp; send details <svg class="icon"><use href="#i-arrow"/></svg>
          </a>
        </div>
      @endif
    </div>
  </section>

  {{-- FORM — rose block --}}
  <section class="section" id="book" style="padding-top:32px;">
    <div class="container">
      <div class="block block-rose">
        <div class="contact-grid">
          <div class="reveal">
            <p class="t-eyebrow">{{ setting('book_form_eyebrow', 'Get started') }}</p>
            <h2 class="t-headline">{{ setting('book_form_heading', 'Tell us about your business') }}</h2>
            <p class="t-body" style="margin-top:10px; opacity:.82;">{{ setting('book_form_intro', "Send a few details and we'll come back with a time to talk within one business day.") }}</p>
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
              <label for="sector">What type of business do you run?</label>
              <select id="sector" name="sector" required>
                <option value="" disabled {{ old('sector') ? '' : 'selected' }}>Select the closest fit</option>
                <option @selected(old('sector')==='NDIS Provider')>NDIS Provider</option>
                <option @selected(old('sector')==='Healthcare & Allied Health')>Healthcare &amp; Allied Health</option>
                <option @selected(old('sector')==='Small–Medium Business')>Small–Medium Business</option>
                <option @selected(old('sector')==='Construction & Trades')>Construction &amp; Trades</option>
                <option @selected(old('sector')==='Other')>Other</option>
              </select>
            </div>
            <div class="form__row" id="preferredTimeRow" hidden>
              <label for="preferred_time">Preferred call time</label>
              <input type="text" id="preferred_time" readonly style="background:var(--cream); cursor:default;">
            </div>
            <div class="form__row">
              <label for="message">What's eating your week right now?</label>
              <textarea id="message" name="message" rows="4" required placeholder="e.g. scheduling, invoicing, participant enquiries, quoting follow-ups...">{{ old('message') }}</textarea>
              @error('message')<span style="color:var(--rose-deep); font-size:12px;">{{ $message }}</span>@enderror
            </div>
            <button type="submit" class="btn btn-primary btn-block">Book my discovery call <svg class="icon"><use href="#i-arrow"/></svg></button>
            @if (session('success'))
              <p class="form__success is-visible" role="status">{{ session('success') }}</p>
            @endif
          </form>
        </div>
      </div>
    </div>
  </section>

  {{-- WHAT HAPPENS NEXT --}}
  <section class="section section-tight">
    <div class="container">
      <div class="section__head center reveal">
        <p class="t-eyebrow" style="color:var(--rose-deep)">{{ setting('book_next_eyebrow', 'What happens next') }}</p>
        <h2 class="t-display-lg">{{ setting('book_next_heading', 'No pitch deck, no lock-in on the call itself') }}</h2>
      </div>
      <div class="grid-3">
        <div class="card reveal">
          <div class="card__icon"><svg class="icon"><use href="#i-calendar"/></svg></div>
          <h3>01 — We confirm a time</h3>
          <p>You'll hear back within one business day to lock in a slot that suits you — video or phone, whichever's easier.</p>
        </div>
        <div class="card reveal">
          <div class="card__icon"><svg class="icon"><use href="#i-chat"/></svg></div>
          <h3>02 — A real conversation</h3>
          <p>We ask about your week, suggest what to hand off first, and explain how matching and onboarding actually works.</p>
        </div>
        <div class="card reveal">
          <div class="card__icon"><svg class="icon"><use href="#i-target"/></svg></div>
          <h3>03 — You decide, on your timeline</h3>
          <p>You'll get a short recap with next steps and an indicative cost. No follow-up calls unless you want one.</p>
        </div>
      </div>
    </div>
  </section>

  {{-- NOT READY FOR A CALL --}}
  <section class="section" style="padding-top:0;">
    <div class="container">
      <div class="block block-sage reveal">
        <div class="grid-2" style="align-items:center; gap:40px;">
          <div>
            <p class="t-eyebrow">{{ setting('book_lighter_eyebrow', 'Not ready for a call?') }}</p>
            <h2 class="t-headline">{{ setting('book_lighter_heading', 'Two lighter ways to start') }}</h2>
            <p class="t-body" style="margin-top:8px; opacity:.82;">{{ setting('book_lighter_intro', "No pressure to book. Get a feel for the numbers first, or read the FAQ.") }}</p>
          </div>
          <div style="display:flex; flex-direction:column; gap:14px;">
            <a href="{{ route('isla.cost-estimator') }}" class="btn btn-on-dark" style="justify-content:space-between;">
              Get an instant cost estimate <svg class="icon"><use href="#i-calculator"/></svg>
            </a>
            <a href="{{ route('isla.faq.index') }}" class="btn btn-secondary" style="justify-content:space-between; border:1px solid var(--hairline);">
              Read the FAQ first <svg class="icon"><use href="#i-arrow"/></svg>
            </a>
          </div>
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

  {{-- QUICK FAQ ABOUT THE CALL --}}
  <section class="section">
    <div class="container">
      <div class="block block-rose">
        <p class="t-eyebrow" style="text-align:center;">{{ setting('book_faq_eyebrow', 'Questions about the call') }}</p>
        <h2 class="t-headline" style="text-align:center;">{{ setting('book_faq_heading', 'What to expect before you book') }}</h2>
        <div class="accordion">
          <div class="accordion__item">
            <button class="accordion__trigger" aria-expanded="false"><span>Do I need to prepare anything?</span><svg class="icon"><use href="#i-chevron"/></svg></button>
            <div class="accordion__panel"><p>No prep needed. A rough sense of what's eating your week is plenty — we'll guide the conversation from there.</p></div>
          </div>
          <div class="accordion__item">
            <button class="accordion__trigger" aria-expanded="false"><span>Is the call actually free?</span><svg class="icon"><use href="#i-chevron"/></svg></button>
            <div class="accordion__panel"><p>Yes — no card, no deposit, no obligation. You only move forward if the fit makes sense on your side.</p></div>
          </div>
          <div class="accordion__item">
            <button class="accordion__trigger" aria-expanded="false"><span>What if I'm not based in a major city?</span><svg class="icon"><use href="#i-chevron"/></svg></button>
            <div class="accordion__panel"><p>It doesn't matter — we work with clients across Australia. The call is video or phone, and your assistant works your business hours in your time zone.</p></div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>
@endsection

@push('styles')
<style>
  /* ==========================================================
     SCHEDULER — Calendly-style booking widget (Isla palette)
     ========================================================== */
  .scheduler{
    display:grid;
    grid-template-columns: 280px 1fr 250px;
    background:var(--white);
    border:1px solid var(--hairline-soft);
    border-radius:var(--r-lg);
    overflow:hidden;
    box-shadow:0 24px 60px rgba(43,39,35,.08);
  }
  .scheduler__info{
    padding:36px 30px;
    border-right:1px solid var(--hairline-soft);
    background:var(--cream);
  }
  .scheduler__brand img{ width:44px; height:44px; border-radius:var(--r-sm); margin-bottom:16px; }
  .scheduler__title{
    font-size:28px; font-weight:700; letter-spacing:-0.5px; margin:6px 0 20px;
  }
  .scheduler__meta{ display:flex; flex-direction:column; gap:12px; }
  .scheduler__meta li{ display:flex; align-items:center; gap:10px; font-size:15px; color:var(--ink-soft); }
  .scheduler__meta .icon{ width:17px; height:17px; color:var(--sage-deep); flex-shrink:0; }

  .scheduler__calendar{ padding:36px 34px; }
  .scheduler__step{
    font-family:var(--font-mono); font-size:12px; letter-spacing:.6px;
    text-transform:uppercase; color:var(--ink-soft); margin:0 0 18px;
  }
  .cal__head{ display:flex; align-items:center; justify-content:space-between; margin-bottom:16px; }
  .cal__month{ font-size:17px; font-weight:600; letter-spacing:-0.2px; }
  .cal__nav{
    width:36px; height:36px; border-radius:var(--r-full);
    display:inline-flex; align-items:center; justify-content:center;
    color:var(--ink); transition:background .15s ease;
  }
  .cal__nav:hover{ background:var(--rose-soft); }
  .cal__nav .icon{ width:15px; height:15px; }
  #calPrev .icon{ transform:rotate(90deg); }
  #calNext .icon{ transform:rotate(-90deg); }
  .cal__nav[disabled]{ opacity:.25; pointer-events:none; }

  .cal__dow{
    display:grid; grid-template-columns:repeat(7,1fr); gap:4px;
    margin-bottom:6px; text-align:center;
  }
  .cal__dow span{
    font-family:var(--font-mono); font-size:10.5px; letter-spacing:.5px;
    text-transform:uppercase; color:var(--ink-soft); padding:6px 0;
  }
  .cal__grid{ display:grid; grid-template-columns:repeat(7,1fr); gap:4px; }
  .cal__day{
    aspect-ratio:1; border-radius:var(--r-full);
    display:flex; align-items:center; justify-content:center;
    font-size:14.5px; font-weight:500; color:var(--ink);
    transition:background .14s ease, color .14s ease, transform .14s ease;
  }
  .cal__day--open{ background:var(--sage-soft); color:var(--sage-deep); cursor:pointer; font-weight:600; }
  .cal__day--open:hover{ background:var(--sage); color:var(--white); transform:scale(1.07); }
  .cal__day--selected,
  .cal__day--selected:hover{ background:var(--ink); color:var(--cream); transform:scale(1.07); }
  .cal__day--off{ color:var(--ink); opacity:.28; pointer-events:none; }
  .cal__day--today{ box-shadow:inset 0 0 0 1.5px var(--rose-deep); }

  .scheduler__slots{
    padding:36px 26px;
    border-left:1px solid var(--hairline-soft);
    display:flex; flex-direction:column;
    max-height:520px;
  }
  .scheduler__slots-hint{ opacity:.6; }
  .slot-list{
    display:flex; flex-direction:column; gap:10px;
    overflow-y:auto; padding-right:4px; margin-top:4px;
  }
  .slot{
    display:flex; gap:8px;
  }
  .slot__time{
    flex:1;
    padding:12px 10px; text-align:center;
    border:1.5px solid var(--sage-deep); border-radius:var(--r-sm);
    color:var(--sage-deep); font-weight:600; font-size:15px;
    transition:background .14s ease, color .14s ease;
  }
  .slot__time:hover{ background:var(--sage-soft); }
  .slot--active .slot__time{
    flex:0 0 48%;
    background:var(--ink-soft); border-color:var(--ink-soft); color:var(--cream);
    pointer-events:none;
  }
  .slot__confirm{
    flex:1; display:none;
    padding:12px 10px; text-align:center;
    background:var(--rose-deep); border-radius:var(--r-sm);
    color:var(--white); font-weight:600; font-size:15px;
  }
  .slot--active .slot__confirm{ display:block; }
  .slot__confirm:hover{ background:var(--rose); }

  .scheduler__confirm{
    display:flex; align-items:center; justify-content:space-between; gap:24px; flex-wrap:wrap;
    margin-top:20px; padding:22px 28px;
    background:var(--sage-soft); border-radius:var(--r-lg);
  }
  .scheduler__confirm-text{ font-size:19px; font-weight:600; letter-spacing:-0.2px; margin:0; }

  .cal-embed{ background:var(--white); border-radius:var(--r-lg); overflow:hidden; border:1px solid var(--hairline-soft); }

  @media (max-width: 1024px){
    .scheduler{ grid-template-columns: 240px 1fr; }
    .scheduler__slots{ grid-column:1 / -1; border-left:none; border-top:1px solid var(--hairline-soft); max-height:none; }
    .slot-list{ flex-direction:row; flex-wrap:wrap; overflow:visible; }
    .slot{ flex:0 0 calc(33.33% - 8px); }
  }
  @media (max-width: 640px){
    .scheduler{ grid-template-columns:1fr; }
    .scheduler__info{ border-right:none; border-bottom:1px solid var(--hairline-soft); }
    .scheduler__calendar{ padding:28px 20px; }
    .slot{ flex:0 0 calc(50% - 8px); }
  }
</style>
@endpush

@push('scripts')
<script>
(function () {
  var grid = document.getElementById('calGrid');
  if (!grid) return; // live Calendly embed is active instead

  var monthLabel = document.getElementById('calMonth');
  var prevBtn = document.getElementById('calPrev');
  var nextBtn = document.getElementById('calNext');
  var slotList = document.getElementById('slotList');
  var slotHint = document.getElementById('slotHint');
  var confirmStrip = document.getElementById('schedConfirm');
  var confirmText = document.getElementById('schedConfirmText');
  var confirmBtn = document.getElementById('schedConfirmBtn');
  var preferredRow = document.getElementById('preferredTimeRow');
  var preferredInput = document.getElementById('preferred_time');

  var TIMES = ['9:00 am','9:30 am','10:00 am','10:30 am','11:00 am','11:30 am',
               '1:00 pm','1:30 pm','2:00 pm','2:30 pm','3:00 pm','3:30 pm','4:00 pm'];
  var MONTHS = ['January','February','March','April','May','June','July','August','September','October','November','December'];

  var today = new Date(); today.setHours(0,0,0,0);
  var view = new Date(today.getFullYear(), today.getMonth(), 1);
  var maxView = new Date(today.getFullYear(), today.getMonth() + 3, 1); // book up to 3 months out
  var selectedDate = null;

  function fmtDate(d) {
    return d.toLocaleDateString('en-AU', { weekday:'long', day:'numeric', month:'long', year:'numeric' });
  }

  function render() {
    monthLabel.textContent = MONTHS[view.getMonth()] + ' ' + view.getFullYear();
    prevBtn.disabled = view <= new Date(today.getFullYear(), today.getMonth(), 1);
    nextBtn.disabled = view >= maxView;

    grid.innerHTML = '';
    var firstDow = (new Date(view.getFullYear(), view.getMonth(), 1).getDay() + 6) % 7; // Mon = 0
    var daysInMonth = new Date(view.getFullYear(), view.getMonth() + 1, 0).getDate();

    for (var i = 0; i < firstDow; i++) grid.appendChild(document.createElement('span'));

    for (var d = 1; d <= daysInMonth; d++) {
      var date = new Date(view.getFullYear(), view.getMonth(), d);
      var el = document.createElement('button');
      el.type = 'button';
      el.className = 'cal__day';
      el.textContent = d;

      var isWeekend = date.getDay() === 0 || date.getDay() === 6;
      var isPast = date <= today;

      if (isWeekend || isPast) {
        el.classList.add('cal__day--off');
        el.disabled = true;
      } else {
        el.classList.add('cal__day--open');
        el.dataset.date = date.toISOString();
        el.addEventListener('click', onPickDay);
      }
      if (date.getTime() === today.getTime()) el.classList.add('cal__day--today');
      if (selectedDate && date.getTime() === selectedDate.getTime()) el.classList.add('cal__day--selected');

      grid.appendChild(el);
    }
  }

  function onPickDay(e) {
    selectedDate = new Date(e.currentTarget.dataset.date);
    selectedDate.setHours(0,0,0,0);
    confirmStrip.hidden = true;
    render();
    renderSlots();
  }

  function renderSlots() {
    slotHint.textContent = fmtDate(selectedDate);
    slotHint.style.opacity = '.85';
    slotList.innerHTML = '';

    TIMES.forEach(function (t) {
      var wrap = document.createElement('div');
      wrap.className = 'slot';

      var time = document.createElement('button');
      time.type = 'button';
      time.className = 'slot__time';
      time.textContent = t;

      var confirm = document.createElement('button');
      confirm.type = 'button';
      confirm.className = 'slot__confirm';
      confirm.textContent = 'Confirm';

      time.addEventListener('click', function () {
        slotList.querySelectorAll('.slot--active').forEach(function (s) { s.classList.remove('slot--active'); });
        wrap.classList.add('slot--active');
      });

      confirm.addEventListener('click', function () { onConfirm(t); });

      wrap.appendChild(time);
      wrap.appendChild(confirm);
      slotList.appendChild(wrap);
    });
  }

  function onConfirm(time) {
    var text = fmtDate(selectedDate) + ' at ' + time + ' (AET)';
    confirmText.textContent = text;
    confirmStrip.hidden = false;
    preferredRow.hidden = false;
    preferredInput.value = text;
    confirmStrip.scrollIntoView({ behavior:'smooth', block:'center' });
  }

  // Prepend the preferred time into the message on submit (no backend change needed)
  var form = document.querySelector('#book form');
  if (form) {
    form.addEventListener('submit', function () {
      var msg = form.querySelector('#message');
      if (preferredInput.value && msg && msg.value.indexOf('Preferred call time:') !== 0) {
        msg.value = 'Preferred call time: ' + preferredInput.value + '\n\n' + msg.value;
      }
    });
  }

  prevBtn.addEventListener('click', function () { view = new Date(view.getFullYear(), view.getMonth() - 1, 1); render(); });
  nextBtn.addEventListener('click', function () { view = new Date(view.getFullYear(), view.getMonth() + 1, 1); render(); });

  render();
})();
</script>
@endpush
