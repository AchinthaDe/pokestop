@extends('admin.layout')

@section('admin-page','Edit Product')

@section('admin-content')
  <form method="POST" action="{{ route('admin.products.update',$product) }}" style="max-width:1100px;">
    @include('admin.products._form')
  </form>
@endsection
