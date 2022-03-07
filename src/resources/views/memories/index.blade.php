@extends('app')

@section('title', '思い出一覧')

@section('content')

    <div class="container">
        @foreach($memories as $memory)
                @include('memories.card')
        @endforeach
    </div>

    <div class="container">
        <div class="col-12 mt-5">
            <a href="{{ route('memories.create') }}">
                <input type="text" class="form-control" placeholder="ひとこと・できごと・おもいを入力">
            </a>
        </div>
    </div>

  @include('nav')
@endsection
