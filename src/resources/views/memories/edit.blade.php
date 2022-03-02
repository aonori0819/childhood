
@extends('app')

@section('title', '思い出を編集する')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="card mt-3">
          <div class="card-body pt-0">
            <div class="card-text">
              <form method="POST" action="{{ route('memories.update', ['memory' => $memory] ) }}">
                @method('PATCH')
                @include('memories.form')
                <button type="submit" class="btn blue-gradient btn-block">更新する</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @include('nav')
@endsection
