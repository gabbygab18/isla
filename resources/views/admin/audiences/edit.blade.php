@extends('layouts.admin')
@section('title', 'Edit audience')
@section('heading', 'Edit audience')
@section('content')
  <div class="card-box">
    @include('admin.audiences.form', ['model' => $audience, 'action' => route('admin.audiences.update', $audience), 'method' => 'PUT'])
  </div>
@endsection
