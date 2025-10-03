@extends('admin.layout')

@section('admin-page','Create Product')

@section('admin-content')
  <form method="POST" action="{{ route('admin.products.store') }}" style="max-width:1100px;">
    @include('admin.products._form')
  </form>
@endsection
