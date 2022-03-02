@extends('app')

@section('title', '思い出一覧')

@section('content')
  <div class="container">
    @foreach($memories as $memory)
    <div class="card mt-3">
      <div class="card-body d-flex flex-row">
        <i class="fas fa-user-circle fa-3x mr-1"></i>
        <div>
          <div class="font-weight-bold">
            {{ $memory->user->name }}
          </div>
        </div>
      </div>
      <div class="card-body pt-0 pb-2">
        <div class="card-text">
         {!! nl2br(e( $memory->body )) !!}
        </div>
      </div>
    </div>
    @endforeach
  </div>
  @include('nav')
@endsection
