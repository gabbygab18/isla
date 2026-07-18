@extends('layouts.admin')
@section('title', 'New audience')
@section('heading', 'New audience')
@section('content')
  <div class="card-box">
    @include('admin.audiences.form', ['model' => null, 'action' => route('admin.audiences.store'), 'method' => 'POST'])
  </div>
@endsection
