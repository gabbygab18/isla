@extends('layouts.admin')
@section('title', 'New FAQ')
@section('heading', 'New FAQ')
@section('content')
  <div class="card-box">
    @include('admin.faqs.form', ['model' => null, 'action' => route('admin.faqs.store'), 'method' => 'POST'])
  </div>
@endsection
