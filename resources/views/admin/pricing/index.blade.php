@extends('layouts.admin')
@section('title', 'Pricing')
@section('heading', 'Pricing plans')
@section('content')
  <div class="page-head">
    <h2>Pricing plans</h2>
    <a href="{{ route('admin.pricing-plans.create') }}" class="btn btn-primary btn-sm">+ New plan</a>
  </div>
  @if ($plans->isEmpty())
    <div class="card-box"><p class="muted" style="margin:0;">No plans yet.</p></div>
  @else
    <table class="table">
      <thead><tr><th>#</th><th>Name</th><th>Detail</th><th>Featured</th><th>Status</th><th></th></tr></thead>
      <tbody>
        @foreach ($plans as $p)
          <tr>
            <td class="muted">{{ $p->sort_order }}</td>
            <td><strong>{{ $p->name }}</strong> @if($p->ribbon)<span class="pill pill-rose">{{ $p->ribbon }}</span>@endif<br><span class="muted">{{ $p->tag }}</span></td>
            <td class="muted">{{ $p->detail }}</td>
            <td>@if($p->is_featured)<span class="pill pill-rose">Yes</span>@else<span class="muted">—</span>@endif</td>
            <td>@if($p->is_active)<span class="pill pill-on">Active</span>@else<span class="pill pill-off">Hidden</span>@endif</td>
            <td class="table__actions">
              <a href="{{ route('isla.pricing.show', $p) }}" target="_blank" class="btn btn-outline btn-sm">View</a>
              <a href="{{ route('admin.pricing-plans.edit', $p) }}" class="btn btn-outline btn-sm">Edit</a>
              <form method="POST" action="{{ route('admin.pricing-plans.destroy', $p) }}" onsubmit="return confirm('Delete this plan?')">
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
