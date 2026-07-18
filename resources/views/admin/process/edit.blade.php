@extends('layouts.admin')
@section('title', 'Edit step')
@section('heading', 'Edit process step')
@section('content')
  <div class="card-box">
    @include('admin.process.form', ['model' => $step, 'action' => route('admin.process-steps.update', $step), 'method' => 'PUT'])
  </div>
@endsection
