@extends('layouts.admin')
@section('title', 'Navigation Menu')
@section('heading', 'Navigation Menu')
@section('content')
  <div class="page-head">
    <h2>Menu items</h2>
    <a href="{{ route('admin.nav-items.create') }}" class="btn btn-primary btn-sm">+ New menu item</a>
  </div>
  <p class="muted" style="margin:-8px 0 18px;">These links appear in the site header and footer, in this order.</p>
  @if ($navItems->isEmpty())
    <div class="card-box"><p class="muted" style="margin:0;">No menu items yet.</p></div>
  @else
    <table class="table">
      <thead><tr><th>#</th><th>Label</th><th>URL</th><th>Status</th><th></th></tr></thead>
      <tbody>
        @foreach ($navItems as $n)
          <tr>
            <td class="muted">{{ $n->sort_order }}</td>
            <td><strong>{{ $n->label }}</strong></td>
            <td class="muted">{{ $n->url }}</td>
            <td>@if($n->is_active)<span class="pill pill-on">Active</span>@else<span class="pill pill-off">Hidden</span>@endif</td>
            <td class="table__actions">
              <a href="{{ route('admin.nav-items.edit', $n) }}" class="btn btn-outline btn-sm">Edit</a>
              <form method="POST" action="{{ route('admin.nav-items.destroy', $n) }}" onsubmit="return confirm('Delete this menu item?')">
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
