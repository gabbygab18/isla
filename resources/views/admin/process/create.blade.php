@extends('layouts.admin')
@section('title', 'New step')
@section('heading', 'New process step')
@section('content')
  <div class="card-box">
    @include('admin.process.form', ['model' => null, 'action' => route('admin.process-steps.store'), 'method' => 'POST'])
  </div>
@endsection
