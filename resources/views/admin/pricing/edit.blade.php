@extends('layouts.admin')
@section('title', 'Edit plan')
@section('heading', 'Edit pricing plan')
@section('content')
  <div class="card-box">
    @include('admin.pricing.form', ['model' => $plan, 'action' => route('admin.pricing-plans.update', $plan), 'method' => 'PUT'])
  </div>
@endsection
