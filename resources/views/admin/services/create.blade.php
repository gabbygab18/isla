@extends('layouts.admin')
@section('title', 'New service')
@section('heading', 'New service')
@section('content')
  <div class="card-box">
    @include('admin.services.form', ['model' => null, 'action' => route('admin.services.store'), 'method' => 'POST'])
  </div>
@endsection
