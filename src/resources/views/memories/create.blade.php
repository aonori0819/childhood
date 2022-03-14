@extends('app')

@section('title', '思い出を投稿')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="card mt-3">
          <div class="card-body pt-3">
            <div class="card-text">
              <form method="POST" action="{{ route('memories.store') }}">
                @csrf
                <div class="form-group">
                    <textarea name="body" required class="form-control" rows="16" placeholder="ひとこと・できごと・おもいを入力">{{ old('body') }}
                    </textarea>
                    {{-- お子さまを登録済の場合、お子さまを選ぶボタン（任意選択）を表示 --}}
                    @if (isset($child_list))
                        @foreach($child_list as $id => $name)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="children[]" value="{{ $id }}">
                                <label class="form-check-label" for="inlineRadio1">{{ $name }}</label>
                            </div>
                        @endforeach
                    @endif
                </div>
                <button type="submit" class="btn blue-gradient btn-block">投稿する</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @include('nav')
@endsection
