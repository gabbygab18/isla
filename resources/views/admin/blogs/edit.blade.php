@extends('layouts.admin')
@section('title', 'Edit Blog Post')
@section('heading', 'Edit Blog Post')
@section('content')
  <div class="card-box">
    @include('admin.blogs.form', ['model' => $blog, 'action' => route('admin.blogs.update', $blog), 'method' => 'PUT'])
  </div>
@endsection
