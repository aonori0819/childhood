@extends('app')

@section('title', 'ファミリー名登録')

@section('content')
    <h4><p class="text-center mt-3">ファミリー名登録</p></h4>

    <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="card mt-3">
              <div class="card-body pt-3">
                <div class="card-text">
                  <form method="POST" action="{{ route('families.update', ['family' => $family ]) }}">
                    @method('PATCH')
                    @csrf
                    <div class="form-group">
                    <textarea name="name" required class="form-control" rows="1" placeholder="ファミリー名を設定">{{ $family->name ?? old('name') }}</textarea>
                    </div>
                    <button type="submit" class="btn blue-gradient btn-block">登録</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    <div class="container">
        <div class="card mt-3">


        <div class="card-body">
            <div class="card-text">

            </div>
        </div>
        </div>
    </div>
    @include('nav')
@endsection
