@extends('layouts.admin')
@section('title', 'New benefit')
@section('heading', 'New benefit')
@section('content')
  <div class="card-box">
    @include('admin.benefits.form', ['model' => null, 'action' => route('admin.benefits.store'), 'method' => 'POST'])
  </div>
@endsection
