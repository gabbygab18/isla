@extends('layouts.admin')
@section('title', 'New plan')
@section('heading', 'New pricing plan')
@section('content')
  <div class="card-box">
    @include('admin.pricing.form', ['model' => null, 'action' => route('admin.pricing-plans.store'), 'method' => 'POST'])
  </div>
@endsection
