@extends('app')

@section('title', '思い出の詳細')

@section('content')
  <div class="container">
    @include('memories.card')
  </div>
  @include('nav')
@endsection
