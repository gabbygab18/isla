@extends('layouts.admin')
@section('title', 'How it Works')
@section('heading', 'How it Works — process steps')
@section('content')
  <div class="page-head">
    <h2>Process steps</h2>
    <a href="{{ route('admin.process-steps.create') }}" class="btn btn-primary btn-sm">+ New step</a>
  </div>
  @if ($steps->isEmpty())
    <div class="card-box"><p class="muted" style="margin:0;">No steps yet.</p></div>
  @else
    <table class="table">
      <thead><tr><th>#</th><th>Number</th><th>Title</th><th>Status</th><th></th></tr></thead>
      <tbody>
        @foreach ($steps as $s)
          <tr>
            <td class="muted">{{ $s->sort_order }}</td>
            <td class="muted">{{ $s->number }}</td>
            <td><strong>{{ $s->title }}</strong><br><span class="muted">{{ Str::limit($s->summary, 70) }}</span></td>
            <td>@if($s->is_active)<span class="pill pill-on">Active</span>@else<span class="pill pill-off">Hidden</span>@endif</td>
            <td class="table__actions">
              <a href="{{ route('admin.process-steps.edit', $s) }}" class="btn btn-outline btn-sm">Edit</a>
              <form method="POST" action="{{ route('admin.process-steps.destroy', $s) }}" onsubmit="return confirm('Delete this step?')">
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
