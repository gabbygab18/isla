@extends('layouts.admin')
@section('title', 'Services')
@section('heading', 'Services')
@section('content')
  <div class="page-head">
    <h2>Services</h2>
    <a href="{{ route('admin.services.create') }}" class="btn btn-primary btn-sm">+ New service</a>
  </div>
  @if ($services->isEmpty())
    <div class="card-box"><p class="muted" style="margin:0;">No services yet.</p></div>
  @else
    <table class="table">
      <thead><tr><th>#</th><th>Title</th><th>Slug</th><th>Status</th><th></th></tr></thead>
      <tbody>
        @foreach ($services as $s)
          <tr>
            <td class="muted">{{ $s->sort_order }}</td>
            <td><strong>{{ $s->title }}</strong><br><span class="muted">{{ Str::limit($s->summary, 60) }}</span></td>
            <td class="muted">{{ $s->slug }}</td>
            <td>@if($s->is_active)<span class="pill pill-on">Active</span>@else<span class="pill pill-off">Hidden</span>@endif</td>
            <td class="table__actions">
              <a href="{{ route('isla.services.show', $s) }}" target="_blank" class="btn btn-outline btn-sm">View</a>
              <a href="{{ route('admin.services.edit', $s) }}" class="btn btn-outline btn-sm">Edit</a>
              <form method="POST" action="{{ route('admin.services.destroy', $s) }}" onsubmit="return confirm('Delete this service?')">
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
