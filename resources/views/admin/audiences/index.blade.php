@extends('layouts.admin')
@section('title', 'Who we work with')
@section('heading', 'Who we work with')

@section('content')
  <div class="page-head">
    <h2>Audiences</h2>
    <a href="{{ route('admin.audiences.create') }}" class="btn btn-primary btn-sm">+ New audience</a>
  </div>

  @if ($audiences->isEmpty())
    <div class="card-box"><p class="muted" style="margin:0;">No audiences yet.</p></div>
  @else
    <table class="table">
      <thead><tr><th>#</th><th>Title</th><th>Slug</th><th>Status</th><th></th></tr></thead>
      <tbody>
        @foreach ($audiences as $a)
          <tr>
            <td class="muted">{{ $a->sort_order }}</td>
            <td><strong>{{ $a->title }}</strong><br><span class="muted">{{ Str::limit($a->summary, 60) }}</span></td>
            <td class="muted">{{ $a->slug }}</td>
            <td>@if($a->is_active)<span class="pill pill-on">Active</span>@else<span class="pill pill-off">Hidden</span>@endif</td>
            <td class="table__actions">
              <a href="{{ route('isla.audiences.show', $a) }}" target="_blank" class="btn btn-outline btn-sm">View</a>
              <a href="{{ route('admin.audiences.edit', $a) }}" class="btn btn-outline btn-sm">Edit</a>
              <form method="POST" action="{{ route('admin.audiences.destroy', $a) }}" onsubmit="return confirm('Delete this audience?')">
                @csrf @method('DELETE')
                <button class="btn btn-danger btn-sm">Delete</button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @endif
@endsection
