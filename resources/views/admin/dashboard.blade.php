@extends('layouts.admin')

@section('title', 'Dashboard')
@section('heading', 'Dashboard')

@section('content')
  <div class="stat-grid">
    <div class="stat"><div class="stat__num">{{ $stats['audiences'] }}</div><div class="stat__label">Audiences</div><a href="{{ route('admin.audiences') }}">Manage →</a></div>
    <div class="stat"><div class="stat__num">{{ $stats['services'] }}</div><div class="stat__label">Services</div><a href="{{ route('admin.services') }}">Manage →</a></div>
    <div class="stat"><div class="stat__num">{{ $stats['processSteps'] }}</div><div class="stat__label">Process steps</div><a href="{{ route('admin.process-steps') }}">Manage →</a></div>
    <div class="stat"><div class="stat__num">{{ $stats['benefits'] }}</div><div class="stat__label">Benefits</div><a href="{{ route('admin.benefits') }}">Manage →</a></div>
    <div class="stat"><div class="stat__num">{{ $stats['pricingPlans'] }}</div><div class="stat__label">Pricing plans</div><a href="{{ route('admin.pricing-plans') }}">Manage →</a></div>
    <div class="stat"><div class="stat__num">{{ $stats['faqs'] }}</div><div class="stat__label">FAQs</div><a href="{{ route('admin.faqs') }}">Manage →</a></div>
    <div class="stat"><div class="stat__num">{{ $stats['testimonials'] }}</div><div class="stat__label">Testimonials</div><a href="{{ route('admin.testimonials') }}">Manage →</a></div>
    <div class="stat"><div class="stat__num">{{ $stats['blogs'] }}</div><div class="stat__label">Blog posts</div><a href="{{ route('admin.blogs') }}">Manage →</a></div>
    <div class="stat"><div class="stat__num">{{ $stats['navItems'] }}</div><div class="stat__label">Menu items</div><a href="{{ route('admin.nav-items') }}">Manage →</a></div>
    <div class="stat"><div class="stat__num">{{ $stats['messages'] }}</div><div class="stat__label">Messages ({{ $stats['unread'] }} unread)</div><a href="{{ route('admin.messages') }}">View →</a></div>
  </div>

  <div class="page-head">
    <h2>Recent enquiries</h2>
    <a href="{{ route('admin.messages') }}" class="btn btn-outline btn-sm">All messages</a>
  </div>

  @if ($recentMessages->isEmpty())
    <div class="card-box"><p class="muted" style="margin:0;">No enquiries yet. Submissions from the site's contact form will appear here.</p></div>
  @else
    <table class="table">
      <thead><tr><th>Name</th><th>Email</th><th>Sector</th><th>Received</th><th></th></tr></thead>
      <tbody>
        @foreach ($recentMessages as $m)
          <tr>
            <td>{{ $m->full_name }} @unless($m->is_read)<span class="pill pill-rose" style="margin-left:6px;">New</span>@endunless</td>
            <td class="muted">{{ $m->email }}</td>
            <td class="muted">{{ $m->sector ?: '—' }}</td>
            <td class="muted">{{ $m->created_at->diffForHumans() }}</td>
            <td class="table__actions"><a href="{{ route('admin.messages.show', $m) }}" class="btn btn-outline btn-sm">Open</a></td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @endif
@endsection
