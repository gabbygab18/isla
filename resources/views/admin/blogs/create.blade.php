@extends('layouts.admin')
@section('title', 'New Blog Post')
@section('heading', 'New Blog Post')
@section('content')
  <div class="card-box">
    @include('admin.blogs.form', ['model' => null, 'action' => route('admin.blogs.store'), 'method' => 'POST'])
  </div>
@endsection
