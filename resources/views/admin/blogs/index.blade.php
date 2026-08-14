@extends('layouts.admin')
@section('title', 'Blog')
@section('heading', 'Blog')
@section('content')
  <div class="page-head">
    <h2>Blog posts</h2>
    <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary btn-sm">+ New post</a>
  </div>
  @if ($blogs->isEmpty())
    <div class="card-box"><p class="muted" style="margin:0;">No blog posts yet.</p></div>
  @else
    <table class="table">
      <thead><tr><th>Title</th><th>Author</th><th>Published</th><th>Status</th><th></th></tr></thead>
      <tbody>
        @foreach ($blogs as $b)
          <tr>
            <td><strong>{{ $b->title }}</strong><br><span class="muted">{{ Str::limit($b->excerpt, 80) }}</span></td>
            <td class="muted">{{ $b->author ?: '—' }}</td>
            <td class="muted">{{ $b->published_at?->format('M j, Y') ?: '—' }}</td>
            <td>@if($b->is_active)<span class="pill pill-on">Active</span>@else<span class="pill pill-off">Hidden</span>@endif</td>
            <td class="table__actions">
              <a href="{{ route('isla.blog.show', $b) }}" target="_blank" class="btn btn-outline btn-sm">View</a>
              <a href="{{ route('admin.blogs.edit', $b) }}" class="btn btn-outline btn-sm">Edit</a>
              <form method="POST" action="{{ route('admin.blogs.destroy', $b) }}" onsubmit="return confirm('Delete this post?')">
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
