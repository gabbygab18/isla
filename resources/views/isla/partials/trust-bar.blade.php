{{-- Shared trust bar — four credibility markers used on lead-gen pages.
     Pass $onDark = true to render the inverse-canvas variant. --}}
@php $onDark = $onDark ?? false; @endphp
<div class="trust-bar reveal {{ $onDark ? 'trust-bar--on-dark' : '' }}">
  <div class="trust-bar__item">
    <span class="icon-wrap"><svg class="icon"><use href="#i-pin"/></svg></span>
    <span>{{ setting('trust_location', 'Location: Across Australia') }}</span>
  </div>
  <div class="trust-bar__item">
    <span class="icon-wrap"><svg class="icon"><use href="#i-clock"/></svg></span>
    <span>{{ setting('trust_response', 'Most clients get a response same business day') }}</span>
  </div>
  <div class="trust-bar__item">
    <span class="icon-wrap"><svg class="icon"><use href="#i-shield"/></svg></span>
    <span>{{ setting('trust_industries', 'Trusted by Australian businesses across multiple industries') }}</span>
  </div>
  <div class="trust-bar__item">
    <span class="icon-wrap"><svg class="icon"><use href="#i-globe"/></svg></span>
    <span>{{ setting('trust_managed', 'Australian-managed, Philippines-based') }}</span>
  </div>
</div>
