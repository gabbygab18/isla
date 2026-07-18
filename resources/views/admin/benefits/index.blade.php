@extends('layouts.admin')
@section('title', 'Why Isla')
@section('heading', 'Why Isla — benefits')
@section('content')
  <div class="page-head">
    <h2>Benefits</h2>
    <a href="{{ route('admin.benefits.create') }}" class="btn btn-primary btn-sm">+ New benefit</a>
  </div>
  @if ($benefits->isEmpty())
    <div class="card-box"><p class="muted" style="margin:0;">No benefits yet.</p></div>
  @else
    <table class="table">
      <thead><tr><th>#</th><th>Title</th><th>Status</th><th></th></tr></thead>
      <tbody>
        @foreach ($benefits as $b)
          <tr>
            <td class="muted">{{ $b->sort_order }}</td>
            <td><strong>{{ $b->title }}</strong><br><span class="muted">{{ Str::limit($b->summary, 80) }}</span></td>
            <td>@if($b->is_active)<span class="pill pill-on">Active</span>@else<span class="pill pill-off">Hidden</span>@endif</td>
            <td class="table__actions">
              <a href="{{ route('admin.benefits.edit', $b) }}" class="btn btn-outline btn-sm">Edit</a>
              <form method="POST" action="{{ route('admin.benefits.destroy', $b) }}" onsubmit="return confirm('Delete this benefit?')">
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
