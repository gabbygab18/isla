@extends('layouts.admin')
@section('title', 'Application')
@section('heading', 'Career application')
@section('content')
  <div class="page-head">
    <h2>{{ $application->full_name }}</h2>
    <a href="{{ route('admin.applications') }}" class="btn btn-outline btn-sm">← Back</a>
  </div>
  <div class="card-box">
    <div class="form-grid" style="max-width:none;">
      <div class="form-split">
        <div><label class="muted" style="font-family:var(--mono); font-size:11px; text-transform:uppercase;">Role applied for</label><p style="margin:4px 0 0; font-weight:600;">{{ $application->role }}</p></div>
        <div><label class="muted" style="font-family:var(--mono); font-size:11px; text-transform:uppercase;">Availability</label><p style="margin:4px 0 0;">{{ $application->availability ?: '—' }}</p></div>
      </div>
      <div class="form-split">
        <div><label class="muted" style="font-family:var(--mono); font-size:11px; text-transform:uppercase;">Email</label><p style="margin:4px 0 0;"><a href="mailto:{{ $application->email }}" style="color:var(--rose-deep); font-weight:600;">{{ $application->email }}</a></p></div>
        <div><label class="muted" style="font-family:var(--mono); font-size:11px; text-transform:uppercase;">Phone</label><p style="margin:4px 0 0;">{{ $application->phone }}</p></div>
      </div>
      @if ($application->portfolio_url)
        <div><label class="muted" style="font-family:var(--mono); font-size:11px; text-transform:uppercase;">Portfolio / CV link</label><p style="margin:4px 0 0;"><a href="{{ $application->portfolio_url }}" target="_blank" rel="noopener" style="color:var(--rose-deep); font-weight:600;">{{ $application->portfolio_url }}</a></p></div>
      @endif
      <div>
        <label class="muted" style="font-family:var(--mono); font-size:11px; text-transform:uppercase;">About the applicant</label>
        <p style="margin:6px 0 0; line-height:1.6; white-space:pre-wrap;">{{ $application->message }}</p>
      </div>
      <p class="muted" style="margin:0;">Received {{ $application->created_at->format('d M Y, g:ia') }}</p>
    </div>
    <div class="form-actions" style="margin-top:18px;">
      <a href="mailto:{{ $application->email }}" class="btn btn-primary">Reply by email</a>
      <form method="POST" action="{{ route('admin.applications.destroy', $application) }}" onsubmit="return confirm('Delete this application?')">
        @csrf @method('DELETE')
        <button class="btn btn-danger">Delete</button>
      </form>
    </div>
  </div>
@endsection
