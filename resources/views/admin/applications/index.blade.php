@extends('layouts.admin')
@section('title', 'Career applications')
@section('heading', 'Career applications')
@section('content')
  @if ($applications->isEmpty())
    <div class="card-box"><p class="muted" style="margin:0;">No applications yet.</p></div>
  @else
    <table class="table">
      <thead><tr><th>Name</th><th>Role</th><th>Email</th><th>Received</th><th></th></tr></thead>
      <tbody>
        @foreach ($applications as $a)
          <tr>
            <td><strong>{{ $a->full_name }}</strong> @unless($a->is_read)<span class="pill pill-rose" style="margin-left:6px;">New</span>@endunless @if($a->resume_path)<span class="pill" style="background:var(--sage-soft); color:var(--sage-deep); margin-left:6px;">CV</span>@endif<br><span class="muted">{{ $a->phone }}</span></td>
            <td class="muted">{{ $a->role }}</td>
            <td class="muted">{{ $a->email }}</td>
            <td class="muted">{{ $a->created_at->format('d M Y, g:ia') }}</td>
            <td class="table__actions">
              <a href="{{ route('admin.applications.show', $a) }}" class="btn btn-outline btn-sm">Open</a>
              <form method="POST" action="{{ route('admin.applications.destroy', $a) }}" onsubmit="return confirm('Delete this application?')">
                @csrf @method('DELETE')
                <button class="btn btn-danger btn-sm">Delete</button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
    <div style="margin-top:18px;">{{ $applications->links() }}</div>
  @endif
@endsection
