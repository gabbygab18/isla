@extends('layouts.app')

@section('title', 'Cost Estimator — ' . setting('brand_word', 'Isla'))
@section('meta_description', setting('calc_intro', 'See your potential savings with a dedicated Isla assistant — by role, experience level, and work setup.'))

@section('content')
<main id="top">
  <section class="detail-hero">
    <div class="container">
      <nav class="breadcrumb" aria-label="Breadcrumb">
        <a href="{{ route('isla.index') }}">Home</a>
        <svg><use href="#i-arrow"/></svg>
        <span>Cost Estimator</span>
      </nav>
      <p class="t-eyebrow detail__eyebrow">{{ setting('calc_eyebrow', 'Cost estimator') }}</p>
      <h1 class="t-display-lg">{{ setting('calc_heading', "What would a dedicated assistant cost you?") }}</h1>
      <p class="t-body-lg detail__lede">{{ setting('calc_intro', "Pick a role, experience level, and work setup for an indicative figure — no email required. Your discovery call gets you an exact, written quote.") }}</p>
    </div>
  </section>

  {{-- CALCULATOR --}}
  <section class="section" style="padding-top:24px;">
    <div class="container">

      {{-- Mode tabs --}}
      <div class="est-tabs reveal" role="tablist" aria-label="Calculator mode">
        <button type="button" class="est-tab is-active" id="tabSingle" role="tab" aria-selected="true">Single Role</button>
        <button type="button" class="est-tab" id="tabTeam" role="tab" aria-selected="false"><svg class="icon" style="width:16px;height:16px;"><use href="#i-users"/></svg> Build Your Team</button>
      </div>

      {{-- =============== SINGLE ROLE =============== --}}
      <div class="est-panel reveal" id="panelSingle">
        <div class="est-controls">
          <div class="est-field">
            <label for="sCurrency">Currency</label>
            <select id="sCurrency">
              <option value="AUD" selected>Australian Dollar (AUD)</option>
              <option value="USD">US Dollar (USD)</option>
              <option value="NZD">New Zealand Dollar (NZD)</option>
              <option value="GBP">British Pound (GBP)</option>
            </select>
          </div>
          <div class="est-field">
            <label for="sCategory">Role Category</label>
            <select id="sCategory">
              <option value="" selected disabled>Select category</option>
            </select>
          </div>
          <div class="est-field">
            <label for="sRole">Role</label>
            <select id="sRole" disabled>
              <option value="" selected disabled>Select role</option>
            </select>
          </div>
          <div class="est-field">
            <label for="sExperience">Experience Level</label>
            <select id="sExperience">
              <option value="junior">Junior</option>
              <option value="intermediate" selected>Intermediate</option>
              <option value="senior">Senior</option>
            </select>
          </div>
          <div class="est-field">
            <label for="sSetup">Work Setup</label>
            <select id="sSetup">
              <option value="home" selected>Home-based</option>
              <option value="hybrid">Hybrid</option>
              <option value="office">Office-based</option>
            </select>
          </div>
          <div class="est-field">
            <label>View By</label>
            <div class="est-viewby" id="sViewBy">
              <button type="button" data-view="hourly">Hourly</button>
              <button type="button" data-view="monthly" class="is-active">Monthly</button>
              <button type="button" data-view="annual">Annual</button>
            </div>
          </div>
        </div>

        {{-- Empty state --}}
        <div class="est-empty" id="sEmpty">
          <svg class="icon" style="width:56px;height:56px; opacity:.35;"><use href="#i-calculator"/></svg>
          <p class="t-body-lg" style="opacity:.7;">Select a role category and role to see your potential savings</p>
          <p class="t-body-sm" style="opacity:.55; margin-top:20px;">Have questions? Let's talk!</p>
          <a href="{{ route('isla.book-call') }}" class="btn btn-primary">Book a Free Consultation <svg class="icon"><use href="#i-arrow"/></svg></a>
        </div>

        {{-- Result --}}
        <div class="est-result" id="sResult" hidden>
          <div class="est-compare">
            <div class="est-compare__card">
              <p class="t-caption" style="opacity:.6;">Typical local hire</p>
              <p class="est-figure est-figure--strike" id="sLocal">A$0</p>
              <p class="est-per" id="sLocalPer">per month</p>
            </div>
            <div class="est-compare__vs" aria-hidden="true">vs</div>
            <div class="est-compare__card est-compare__card--isla">
              <p class="t-caption">With {{ setting('brand_word', 'Isla') }}</p>
              <p class="est-figure" id="sIsla">A$0</p>
              <p class="est-per" id="sIslaPer">per month, all-inclusive</p>
            </div>
          </div>
          <div class="est-savings" id="sSavings">
            <svg class="icon"><use href="#i-check"/></svg>
            <span>You could save <strong id="sSaveAmt">A$0</strong> (<span id="sSavePct">0%</span>) <span id="sSavePer">per month</span></span>
          </div>
          <ul class="est-breakdown">
            <li><span>Role</span><strong id="sBdRole">—</strong></li>
            <li><span>Assistant rate</span><strong id="sBdRate">—</strong></li>
            <li><span>Flat management fee</span><strong id="sBdFee">—</strong></li>
            <li><span>Basis</span><strong>38 hrs / week, AU business hours</strong></li>
          </ul>
          <p class="est-disclaimer">{{ setting('calc_disclaimer', "Indicative only, based on typical Isla rates, a flat monthly management fee per assistant, and illustrative exchange rates and local salary benchmarks. Your discovery call confirms an exact, written quote for your role and sector.") }}</p>
          <a href="{{ route('isla.book-call') }}" class="btn btn-primary btn-block" style="margin-top:18px;">Book a Free Consultation <svg class="icon"><use href="#i-arrow"/></svg></a>
        </div>
      </div>

      {{-- =============== BUILD YOUR TEAM =============== --}}
      <div class="est-panel reveal" id="panelTeam" hidden>
        <div class="est-team-head">
          <h2 class="t-headline" style="display:flex; align-items:center; gap:10px;"><svg class="icon icon-lg"><use href="#i-users"/></svg> Build Your Team</h2>
          <p class="t-body" style="opacity:.7; margin-top:6px;">Add multiple roles to see your total team cost savings</p>
        </div>
        <div class="est-field" style="max-width:420px; margin-bottom:20px;">
          <label for="tCurrency">Currency</label>
          <select id="tCurrency">
            <option value="AUD" selected>Australian Dollar (AUD)</option>
            <option value="USD">US Dollar (USD)</option>
            <option value="NZD">New Zealand Dollar (NZD)</option>
            <option value="GBP">British Pound (GBP)</option>
          </select>
        </div>

        <div id="teamRows"></div>

        <button type="button" class="btn btn-secondary" id="addTeammate" style="border:1px solid var(--hairline); margin-top:4px;">
          + Add Another Teammate
        </button>

        <div class="est-result" id="tResult" hidden style="margin-top:28px;">
          <div class="est-compare">
            <div class="est-compare__card">
              <p class="t-caption" style="opacity:.6;">Typical local team</p>
              <p class="est-figure est-figure--strike" id="tLocal">A$0</p>
              <p class="est-per">per month</p>
            </div>
            <div class="est-compare__vs" aria-hidden="true">vs</div>
            <div class="est-compare__card est-compare__card--isla">
              <p class="t-caption">With {{ setting('brand_word', 'Isla') }}</p>
              <p class="est-figure" id="tIsla">A$0</p>
              <p class="est-per">per month, all-inclusive</p>
            </div>
          </div>
          <div class="est-savings">
            <svg class="icon"><use href="#i-check"/></svg>
            <span>Your team could save <strong id="tSaveAmt">A$0</strong> (<span id="tSavePct">0%</span>) per month</span>
          </div>
          <p class="est-disclaimer">{{ setting('calc_disclaimer', "Indicative only, based on typical Isla rates, a flat monthly management fee per assistant, and illustrative exchange rates and local salary benchmarks. Your discovery call confirms an exact, written quote for your roles and sector.") }}</p>
          <a href="{{ route('isla.book-call') }}" class="btn btn-primary btn-block" style="margin-top:18px;">Book a Free Consultation <svg class="icon"><use href="#i-arrow"/></svg></a>
        </div>
      </div>
    </div>
  </section>

  {{-- OR START FROM A PLAN --}}
  <section class="section section-tight">
    <div class="container">
      <div class="section__head center reveal">
        <p class="t-eyebrow" style="color:var(--rose-deep)">{{ setting('pricing_eyebrow', 'Pricing') }}</p>
        <h2 class="t-display-lg">Or start from a set plan</h2>
        <p class="t-body-lg" style="color:var(--ink-soft); margin-top:16px;">Every plan runs on the same flat-fee model as the estimate above.</p>
      </div>
      <div class="pricing-grid">
        @foreach ($pricingPlans as $plan)
          <div class="price-card reveal {{ $plan->is_featured ? 'price-card--featured' : '' }}">
            @if ($plan->ribbon)
              <span class="price-card__ribbon">{{ $plan->ribbon }}</span>
            @endif
            <h3 class="t-card-title">{{ $plan->name }}</h3>
            <p class="price-card__tag">{{ $plan->tag }}</p>
            <p class="price-card__detail">{{ $plan->detail }}</p>
            <p>{{ $plan->summary }}</p>
            <a href="{{ route('isla.pricing.show', $plan) }}"
               class="btn {{ $plan->is_featured ? 'btn-on-dark' : 'btn-secondary' }} btn-block"
               @unless($plan->is_featured) style="border:1px solid var(--hairline);" @endunless>
              View plan details
            </a>
          </div>
        @endforeach
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

@push('styles')
<style>
  /* ==========================================================
     COST ESTIMATOR — role-based calculator
     ========================================================== */
  .est-tabs{
    display:inline-flex; gap:4px; padding:5px;
    background:var(--white); border:1px solid var(--hairline-soft);
    border-radius:var(--r-pill); margin:0 auto 24px;
    position:relative; left:50%; transform:translateX(-50%);
  }
  .est-tab{
    display:inline-flex; align-items:center; gap:8px;
    padding:11px 26px; border-radius:var(--r-pill);
    font-size:16px; font-weight:540; color:var(--ink-soft);
    transition:background .15s ease, color .15s ease;
  }
  .est-tab.is-active{ background:var(--ink); color:var(--cream); }

  .est-panel{
    background:var(--white); border:1px solid var(--hairline-soft);
    border-radius:var(--r-lg); padding:36px;
    box-shadow:0 24px 60px rgba(43,39,35,.07);
  }
  .est-controls{
    display:grid; grid-template-columns:repeat(3,1fr); gap:22px 28px; margin-bottom:8px;
  }
  .est-field label{
    display:block; font-family:var(--font-mono); font-size:11px; font-weight:500;
    letter-spacing:.05em; text-transform:uppercase; margin-bottom:9px; opacity:.7;
  }
  .est-field select{
    width:100%; padding:13px 14px; font-family:var(--font-sans); font-size:16px;
    color:var(--ink); background:var(--cream);
    border:1px solid var(--hairline); border-radius:var(--r-sm);
  }
  .est-field select:disabled{ opacity:.45; }
  .est-viewby{ display:flex; gap:8px; }
  .est-viewby button{
    flex:1; padding:12px 8px; text-align:center;
    border:1.5px solid var(--hairline); border-radius:var(--r-sm);
    font-size:15px; font-weight:600; color:var(--ink);
    transition:background .14s ease, color .14s ease, border-color .14s ease;
  }
  .est-viewby button.is-active{
    background:var(--rose-deep); border-color:var(--rose-deep); color:var(--white);
  }

  .est-empty{
    text-align:center; padding:64px 20px 40px;
    display:flex; flex-direction:column; align-items:center; gap:14px;
  }
  .est-result{ padding-top:24px; }

  .est-compare{
    display:grid; grid-template-columns:1fr auto 1fr; gap:20px; align-items:stretch;
  }
  .est-compare__card{
    padding:26px 28px; border-radius:var(--r-md);
    background:var(--cream); border:1px solid var(--hairline-soft);
  }
  .est-compare__card--isla{
    background:var(--ink); color:var(--cream); border-color:var(--ink);
  }
  .est-compare__card--isla .t-caption{ color:var(--rose); }
  .est-compare__vs{
    align-self:center;
    font-family:var(--font-mono); font-size:12px; letter-spacing:.5px;
    text-transform:uppercase; color:var(--ink-soft);
  }
  .est-figure{ font-size:clamp(1.9rem, 3.4vw, 2.8rem); font-weight:700; letter-spacing:-1px; margin:8px 0 2px; }
  .est-figure--strike{ text-decoration:line-through; text-decoration-color:var(--rose-deep); text-decoration-thickness:3px; opacity:.55; }
  .est-per{ font-size:14px; opacity:.6; margin:0; }

  .est-savings{
    display:flex; align-items:center; justify-content:center; gap:10px;
    margin:22px 0; padding:16px 22px;
    background:var(--sage-soft); color:var(--sage-deep);
    border-radius:var(--r-md); font-size:18px;
  }
  .est-savings .icon{ width:20px; height:20px; flex-shrink:0; }
  .est-savings strong{ font-weight:700; }

  .est-breakdown{ border-top:1px solid var(--hairline-soft); }
  .est-breakdown li{
    display:flex; justify-content:space-between; gap:16px;
    padding:12px 2px; border-bottom:1px solid var(--hairline-soft);
    font-size:15.5px;
  }
  .est-breakdown li span{ opacity:.65; }
  .est-disclaimer{ font-size:12.5px; opacity:.55; margin-top:16px; line-height:1.5; }

  /* Build your team */
  .est-team-head{ margin-bottom:24px; }
  .team-row{
    display:grid; grid-template-columns:1.2fr 1.2fr 1fr 1fr 90px 44px;
    gap:14px; align-items:end;
    padding:18px 0; border-bottom:1px solid var(--hairline-soft);
  }
  .team-row .est-field label{ margin-bottom:7px; }
  .team-row__remove{
    height:47px; border-radius:var(--r-sm);
    display:flex; align-items:center; justify-content:center;
    color:var(--rose-deep); border:1.5px solid var(--rose-soft);
    transition:background .14s ease;
  }
  .team-row__remove:hover{ background:var(--rose-soft); }
  .team-row__remove .icon{ width:16px; height:16px; }

  @media (max-width: 1024px){
    .est-controls{ grid-template-columns:repeat(2,1fr); }
    .team-row{ grid-template-columns:repeat(2,1fr); }
    .team-row__remove{ width:100%; }
  }
  @media (max-width: 640px){
    .est-panel{ padding:24px 18px; }
    .est-controls{ grid-template-columns:1fr; }
    .est-compare{ grid-template-columns:1fr; }
    .est-compare__vs{ justify-self:center; }
    .team-row{ grid-template-columns:1fr; }
    .est-tabs{ width:100%; }
    .est-tab{ flex:1; justify-content:center; padding:11px 10px; }
  }
</style>
@endpush

@push('scripts')
<script>
(function () {
  /* ---------- data ---------- */
  var CATEGORIES = @json($services->map(fn ($s) => ['title' => $s->title, 'roles' => $s->roles ?? []])->values());

  // Indicative AUD hourly rates per role category (order matches CATEGORIES)
  // Override per service in Admin → Settings with key: calc_rate_{service_slug_with_underscores}
  var BASE_RATES = {!! json_encode(array_map(
    function ($slug) {
      $defaults = [
        'admin-scheduling'           => 11,
        'client-participant-support' => 12,
        'bookkeeping-invoicing'      => 14,
        'compliance-documentation'   => 15,
        'marketing-social'           => 13,
        'customer-service'           => 11,
      ];
      return (float) setting('calc_rate_' . str_replace('-', '_', $slug), $defaults[$slug] ?? 13);
    },
    $services->pluck('slug')->all()
  )) !!};

  var EXP_MULT   = { junior: 0.85, intermediate: 1.0, senior: 1.3 };
  var SETUP_MULT = { home: 1.0, hybrid: 1.08, office: 1.18 };
  var CURRENCY   = {
    AUD: { sym: 'A$',  fx: 1.0  },
    USD: { sym: 'US$', fx: 0.66 },
    NZD: { sym: 'NZ$', fx: 1.08 },
    GBP: { sym: '£',   fx: 0.52 }
  };
  var MGMT_FEE      = {{ (float) setting('calc_management_fee', 650) }};   // AUD / month / assistant
  var LOCAL_RATE    = {{ (float) setting('calc_local_rate', 42) }};        // AUD / hr local-hire benchmark
  var HOURS_WEEK    = 38;
  var WEEKS_MONTH   = 4.33;

  function money(sym, n){ return sym + Math.round(n).toLocaleString('en-AU'); }

  function islaHourly(catIdx, exp, setup){
    return (BASE_RATES[catIdx] || 13) * EXP_MULT[exp] * SETUP_MULT[setup];
  }
  function localHourly(exp){ return LOCAL_RATE * EXP_MULT[exp]; }

  // returns { isla, local } in AUD for the given view
  function costsFor(catIdx, exp, setup, view, qty){
    qty = qty || 1;
    var hIsla  = islaHourly(catIdx, exp, setup);
    var hLocal = localHourly(exp);
    var mIsla  = hIsla  * HOURS_WEEK * WEEKS_MONTH + MGMT_FEE;
    var mLocal = hLocal * HOURS_WEEK * WEEKS_MONTH * 1.25; // + super/leave/overheads
    if (view === 'hourly')  return { isla: (mIsla / (HOURS_WEEK * WEEKS_MONTH)) * qty, local: hLocal * 1.25 * qty };
    if (view === 'annual')  return { isla: mIsla * 12 * qty, local: mLocal * 12 * qty };
    return { isla: mIsla * qty, local: mLocal * qty };
  }

  function fillCategories(sel){
    CATEGORIES.forEach(function (c, i) {
      var o = document.createElement('option');
      o.value = i; o.textContent = c.title;
      sel.appendChild(o);
    });
  }
  function fillRoles(sel, catIdx){
    sel.innerHTML = '<option value="" selected disabled>Select role</option>';
    (CATEGORIES[catIdx] ? CATEGORIES[catIdx].roles : []).forEach(function (r) {
      var o = document.createElement('option');
      o.value = r; o.textContent = r;
      sel.appendChild(o);
    });
    sel.disabled = false;
  }

  /* ---------- tabs ---------- */
  var tabSingle = document.getElementById('tabSingle');
  var tabTeam   = document.getElementById('tabTeam');
  var panelSingle = document.getElementById('panelSingle');
  var panelTeam   = document.getElementById('panelTeam');

  function setTab(single){
    tabSingle.classList.toggle('is-active', single);
    tabTeam.classList.toggle('is-active', !single);
    tabSingle.setAttribute('aria-selected', single);
    tabTeam.setAttribute('aria-selected', !single);
    panelSingle.hidden = !single;
    panelTeam.hidden = single;
  }
  tabSingle.addEventListener('click', function(){ setTab(true); });
  tabTeam.addEventListener('click', function(){ setTab(false); recalcTeam(); });

  /* ---------- single role ---------- */
  var sCategory = document.getElementById('sCategory');
  var sRole = document.getElementById('sRole');
  var sExp = document.getElementById('sExperience');
  var sSetup = document.getElementById('sSetup');
  var sCurrency = document.getElementById('sCurrency');
  var sView = 'monthly';

  fillCategories(sCategory);

  sCategory.addEventListener('change', function(){
    fillRoles(sRole, parseInt(sCategory.value, 10));
    recalcSingle();
  });
  [sRole, sExp, sSetup, sCurrency].forEach(function(el){ el.addEventListener('change', recalcSingle); });

  document.querySelectorAll('#sViewBy button').forEach(function(b){
    b.addEventListener('click', function(){
      document.querySelectorAll('#sViewBy button').forEach(function(x){ x.classList.remove('is-active'); });
      b.classList.add('is-active');
      sView = b.dataset.view;
      recalcSingle();
    });
  });

  function recalcSingle(){
    var ready = sCategory.value !== '' && sRole.value !== '';
    document.getElementById('sEmpty').hidden = ready;
    document.getElementById('sResult').hidden = !ready;
    if (!ready) return;

    var cur = CURRENCY[sCurrency.value];
    var c = costsFor(parseInt(sCategory.value,10), sExp.value, sSetup.value, sView, 1);
    var per = sView === 'hourly' ? 'per hour' : (sView === 'annual' ? 'per year' : 'per month');

    document.getElementById('sLocal').textContent = money(cur.sym, c.local * cur.fx);
    document.getElementById('sLocalPer').textContent = per;
    document.getElementById('sIsla').textContent = money(cur.sym, c.isla * cur.fx);
    document.getElementById('sIslaPer').textContent = per + ', all-inclusive';

    var save = c.local - c.isla;
    var pct = c.local > 0 ? Math.max(0, Math.round((save / c.local) * 100)) : 0;
    document.getElementById('sSaveAmt').textContent = money(cur.sym, save * cur.fx);
    document.getElementById('sSavePct').textContent = pct + '%';
    document.getElementById('sSavePer').textContent = per;

    document.getElementById('sBdRole').textContent = sRole.value + ' · ' + sExp.options[sExp.selectedIndex].text + ' · ' + sSetup.options[sSetup.selectedIndex].text;
    var h = islaHourly(parseInt(sCategory.value,10), sExp.value, sSetup.value);
    document.getElementById('sBdRate').textContent = money(cur.sym, h * cur.fx) + ' / hr';
    document.getElementById('sBdFee').textContent = money(cur.sym, MGMT_FEE * cur.fx) + ' / month';
  }

  /* ---------- build your team ---------- */
  var teamRows = document.getElementById('teamRows');
  var tCurrency = document.getElementById('tCurrency');
  tCurrency.addEventListener('change', recalcTeam);

  function addRow(){
    var row = document.createElement('div');
    row.className = 'team-row';
    row.innerHTML =
      '<div class="est-field"><label>Role Category</label><select data-f="cat"><option value="" selected disabled>Select category</option></select></div>' +
      '<div class="est-field"><label>Role</label><select data-f="role" disabled><option value="" selected disabled>Select role</option></select></div>' +
      '<div class="est-field"><label>Experience</label><select data-f="exp"><option value="junior">Junior</option><option value="intermediate" selected>Intermediate</option><option value="senior">Senior</option></select></div>' +
      '<div class="est-field"><label>Work Setup</label><select data-f="setup"><option value="home" selected>Home-based</option><option value="hybrid">Hybrid</option><option value="office">Office-based</option></select></div>' +
      '<div class="est-field"><label>Quantity</label><select data-f="qty"><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select></div>' +
      '<button type="button" class="team-row__remove" aria-label="Remove teammate"><svg class="icon"><use href="#i-x"/></svg></button>';

    var cat = row.querySelector('[data-f="cat"]');
    fillCategories(cat);
    cat.addEventListener('change', function(){
      fillRoles(row.querySelector('[data-f="role"]'), parseInt(cat.value, 10));
      recalcTeam();
    });
    row.querySelectorAll('select').forEach(function(s){ s.addEventListener('change', recalcTeam); });
    row.querySelector('.team-row__remove').addEventListener('click', function(){
      if (teamRows.children.length > 1) { row.remove(); recalcTeam(); }
    });
    teamRows.appendChild(row);
  }

  document.getElementById('addTeammate').addEventListener('click', function(){ addRow(); });
  addRow();

  function recalcTeam(){
    var cur = CURRENCY[tCurrency.value];
    var isla = 0, local = 0, any = false;

    teamRows.querySelectorAll('.team-row').forEach(function(row){
      var cat = row.querySelector('[data-f="cat"]').value;
      var role = row.querySelector('[data-f="role"]').value;
      if (cat === '' || role === '') return;
      any = true;
      var c = costsFor(
        parseInt(cat, 10),
        row.querySelector('[data-f="exp"]').value,
        row.querySelector('[data-f="setup"]').value,
        'monthly',
        parseInt(row.querySelector('[data-f="qty"]').value, 10)
      );
      isla += c.isla; local += c.local;
    });

    document.getElementById('tResult').hidden = !any;
    if (!any) return;

    document.getElementById('tLocal').textContent = money(cur.sym, local * cur.fx);
    document.getElementById('tIsla').textContent = money(cur.sym, isla * cur.fx);
    var save = local - isla;
    document.getElementById('tSaveAmt').textContent = money(cur.sym, save * cur.fx);
    document.getElementById('tSavePct').textContent = (local > 0 ? Math.max(0, Math.round((save / local) * 100)) : 0) + '%';
  }
})();
</script>
@endpush
@endsection
