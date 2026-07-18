@extends('layouts.admin')
@section('title', 'FAQ')
@section('heading', 'FAQ')
@section('content')
  <div class="page-head">
    <h2>FAQs</h2>
    <a href="{{ route('admin.faqs.create') }}" class="btn btn-primary btn-sm">+ New FAQ</a>
  </div>
  @if ($faqs->isEmpty())
    <div class="card-box"><p class="muted" style="margin:0;">No FAQs yet.</p></div>
  @else
    <table class="table">
      <thead><tr><th>#</th><th>Question</th><th>Status</th><th></th></tr></thead>
      <tbody>
        @foreach ($faqs as $f)
          <tr>
            <td class="muted">{{ $f->sort_order }}</td>
            <td><strong>{{ $f->question }}</strong><br><span class="muted">{{ Str::limit($f->answer, 80) }}</span></td>
            <td>@if($f->is_active)<span class="pill pill-on">Active</span>@else<span class="pill pill-off">Hidden</span>@endif</td>
            <td class="table__actions">
              <a href="{{ route('isla.faqs.show', $f) }}" target="_blank" class="btn btn-outline btn-sm">View</a>
              <a href="{{ route('admin.faqs.edit', $f) }}" class="btn btn-outline btn-sm">Edit</a>
              <form method="POST" action="{{ route('admin.faqs.destroy', $f) }}" onsubmit="return confirm('Delete this FAQ?')">
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
