@extends('app')

@section('title', '思い出の詳細')

@section('content')

     <!-- 思い出本文を表示 -->
    <div class="container">
        @include('memories.card')
    </div>

    <!-- コメント入力フォーム -->
    <div class="container">
        <div class="row">
        <div class="col-12">
            <div class="card pt-3 mt-3">
            <div class="card-body pt-0">
                <div class="card-text">
                    @if($errors->has('body')) <div class="text-danger">{{ $errors->first('body') }}</div> @endif
                    <form method="POST" action="{{ route('comments.store',  ['memory_id' => $memory->id]) }}">
                        @csrf
                        <div class="form-group">
                            <textarea name="body" class="form-control" rows="3" placeholder="コメントを入力"></textarea>
                        </div>

                        <button type="submit" class="btn blue-gradient btn-block">コメント送信</button>
                    </form>
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>


  @include('nav')
@endsection
