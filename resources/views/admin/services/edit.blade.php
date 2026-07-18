@extends('layouts.admin')
@section('title', 'Edit service')
@section('heading', 'Edit service')
@section('content')
  <div class="card-box">
    @include('admin.services.form', ['model' => $service, 'action' => route('admin.services.update', $service), 'method' => 'PUT'])
  </div>
@endsection
