@extends('layouts.admin')
@section('title', 'Testimonials')
@section('heading', 'Testimonials')
@section('content')
  <div class="page-head">
    <h2>Testimonials</h2>
    <a href="{{ route('admin.testimonials.create') }}" class="btn btn-primary btn-sm">+ New Testimonial</a>
  </div>
  @if ($testimonials->isEmpty())
    <div class="card-box"><p class="muted" style="margin:0;">No testimonials yet.</p></div>
  @else
    <table class="table">
      <thead><tr><th>#</th><th>Testimonial</th><th>Status</th><th></th></tr></thead>
      <tbody>
        @foreach ($testimonials as $t)
          <tr>
            <td class="muted">{{ $t->sort_order }}</td>
            <td><strong>{{ $t->author }}</strong>@if($t->role) <span class="muted">— {{ $t->role }}</span>@endif<br><span class="muted">{{ Str::limit($t->quote, 90) }}</span></td>
            <td>@if($t->is_active)<span class="pill pill-on">Active</span>@else<span class="pill pill-off">Hidden</span>@endif</td>
            <td class="table__actions">
              <a href="{{ route('isla.testimonials') }}" target="_blank" class="btn btn-outline btn-sm">View</a>
              <a href="{{ route('admin.testimonials.edit', $t) }}" class="btn btn-outline btn-sm">Edit</a>
              <form method="POST" action="{{ route('admin.testimonials.destroy', $t) }}" onsubmit="return confirm('Delete this testimonial?')">
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
