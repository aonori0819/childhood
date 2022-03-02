@extends('app')

@section('title', '思い出一覧')

@section('content')
  <div class="container">
    @foreach($memories as $memory)
         @include('memories.card')
    @endforeach
  </div>
  @include('nav')
@endsection
