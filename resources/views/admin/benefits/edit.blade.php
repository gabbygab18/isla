@extends('layouts.admin')
@section('title', 'Edit benefit')
@section('heading', 'Edit benefit')
@section('content')
  <div class="card-box">
    @include('admin.benefits.form', ['model' => $benefit, 'action' => route('admin.benefits.update', $benefit), 'method' => 'PUT'])
  </div>
@endsection
