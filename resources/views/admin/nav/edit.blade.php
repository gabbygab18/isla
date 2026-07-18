@extends('layouts.admin')
@section('title', 'Edit menu item')
@section('heading', 'Edit menu item')
@section('content')
  <div class="card-box">
    @include('admin.nav.form', ['model' => $navItem, 'action' => route('admin.nav-items.update', $navItem), 'method' => 'PUT'])
  </div>
@endsection
