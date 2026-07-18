@extends('layouts.admin')
@section('title', 'Edit FAQ')
@section('heading', 'Edit FAQ')
@section('content')
  <div class="card-box">
    @include('admin.faqs.form', ['model' => $faq, 'action' => route('admin.faqs.update', $faq), 'method' => 'PUT'])
  </div>
@endsection
