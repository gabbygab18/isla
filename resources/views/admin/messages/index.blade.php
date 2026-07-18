@extends('layouts.admin')
@section('title', 'Messages')
@section('heading', 'Contact enquiries')
@section('content')
  @if ($messages->isEmpty())
    <div class="card-box"><p class="muted" style="margin:0;">No enquiries yet.</p></div>
  @else
    <table class="table">
      <thead><tr><th>Name</th><th>Email</th><th>Sector</th><th>Received</th><th></th></tr></thead>
      <tbody>
        @foreach ($messages as $m)
          <tr>
            <td><strong>{{ $m->full_name }}</strong> @unless($m->is_read)<span class="pill pill-rose" style="margin-left:6px;">New</span>@endunless<br><span class="muted">{{ $m->business_name }}</span></td>
            <td class="muted">{{ $m->email }}</td>
            <td class="muted">{{ $m->sector ?: '—' }}</td>
            <td class="muted">{{ $m->created_at->format('d M Y, g:ia') }}</td>
            <td class="table__actions">
              <a href="{{ route('admin.messages.show', $m) }}" class="btn btn-outline btn-sm">Open</a>
              <form method="POST" action="{{ route('admin.messages.destroy', $m) }}" onsubmit="return confirm('Delete this message?')">
                @csrf @method('DELETE')
                <button class="btn btn-danger btn-sm">Delete</button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
    <div style="margin-top:18px;">{{ $messages->links() }}</div>
  @endif
@endsection
