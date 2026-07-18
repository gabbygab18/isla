@extends('layouts.admin')
@section('title', 'Message')
@section('heading', 'Enquiry')
@section('content')
  <div class="page-head">
    <h2>{{ $message->full_name }}</h2>
    <a href="{{ route('admin.messages') }}" class="btn btn-outline btn-sm">← Back</a>
  </div>
  <div class="card-box">
    <div class="form-grid" style="max-width:none;">
      <div class="form-split">
        <div><label class="muted" style="font-family:var(--mono); font-size:11px; text-transform:uppercase;">Email</label><p style="margin:4px 0 0;"><a href="mailto:{{ $message->email }}" style="color:var(--rose-deep); font-weight:600;">{{ $message->email }}</a></p></div>
        <div><label class="muted" style="font-family:var(--mono); font-size:11px; text-transform:uppercase;">Phone</label><p style="margin:4px 0 0;">{{ $message->phone ?: '—' }}</p></div>
      </div>
      <div class="form-split">
        <div><label class="muted" style="font-family:var(--mono); font-size:11px; text-transform:uppercase;">Business</label><p style="margin:4px 0 0;">{{ $message->business_name ?: '—' }}</p></div>
        <div><label class="muted" style="font-family:var(--mono); font-size:11px; text-transform:uppercase;">Sector</label><p style="margin:4px 0 0;">{{ $message->sector ?: '—' }}</p></div>
      </div>
      <div>
        <label class="muted" style="font-family:var(--mono); font-size:11px; text-transform:uppercase;">Message</label>
        <p style="margin:6px 0 0; line-height:1.6; white-space:pre-wrap;">{{ $message->message }}</p>
      </div>
      <p class="muted" style="margin:0;">Received {{ $message->created_at->format('d M Y, g:ia') }}</p>
    </div>
    <div class="form-actions" style="margin-top:18px;">
      <a href="mailto:{{ $message->email }}" class="btn btn-primary">Reply by email</a>
      <form method="POST" action="{{ route('admin.messages.destroy', $message) }}" onsubmit="return confirm('Delete this message?')">
        @csrf @method('DELETE')
        <button class="btn btn-danger">Delete</button>
      </form>
    </div>
  </div>
@endsection
