@extends('layouts.admin')
@section('title', 'New menu item')
@section('heading', 'New menu item')
@section('content')
  <div class="card-box">
    @include('admin.nav.form', ['model' => null, 'action' => route('admin.nav-items.store'), 'method' => 'POST'])
  </div>
@endsection
