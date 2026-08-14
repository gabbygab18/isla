@extends('layouts.admin')
@section('title', 'Edit Testimonial')
@section('heading', 'Edit Testimonial')
@section('content')
  <div class="card-box">
    @include('admin.testimonials.form', ['model' => $testimonial, 'action' => route('admin.testimonials.update', $testimonial), 'method' => 'PUT'])
  </div>
@endsection
