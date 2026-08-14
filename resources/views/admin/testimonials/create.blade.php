@extends('layouts.admin')
@section('title', 'New Testimonial')
@section('heading', 'New Testimonial')
@section('content')
  <div class="card-box">
    @include('admin.testimonials.form', ['model' => null, 'action' => route('admin.testimonials.store'), 'method' => 'POST'])
  </div>
@endsection
