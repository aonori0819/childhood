@extends('app')

@section('title', '思い出を投稿')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="card mt-3">
          <div class="card-body pt-3">
            <div class="card-text">
              <form method="POST" action="{{ route('memories.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    {{-- 本文 --}}
                    @if($errors->has('body')) <span class="text-danger">{{ $errors->first('body') }}</span> @endif
                    <textarea name="body" required class="form-control" rows="10" placeholder="ひとこと・できごと・おもいを入力">{{ old('body') }}
                    </textarea>

                    {{-- 画像アップロード --}}
                    <span class="image-picker">
                        <div class="mt-4"><label>■写真・画像をアップロード</label></div>
                        @if($errors->has('image_path')) <div class="text-danger">{{ $errors->first('image_path') }}</div> @endif
                        <div><input type="file" name="image_path" accept="image/png,image/jpeg,image/gif,image/svg" id="image_path"></div>
                    </span>

                    {{-- お子さまを登録済の場合、お子さまを選ぶボタン（任意選択）を表示 --}}
                    @if (isset($child_list))
                    <div class="select-child" >
                        <div class="mt-4">■どちらのお子さまの記録ですか？</div>
                        @foreach($child_list as $child)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="children[]" value="{{ $child->id }}">
                                <label class="form-check-label" >{{ $child->name }}
                                    @if(isset($child->icon_path))
                                        <div>
                                            <img src="{{ asset('storage/icon/' . $child->icon_path ) }}" width="50" alt="アイコン画像">
                                        </div>
                                    @endif
                                </label>
                            </div>
                        @endforeach
                    </div>
                    @endif
                </div>
                <div class="d-flex justify-content-center mt-3">
                    <button type="submit" class="btn blue-gradient btn-block" style="width:150px">記録する</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @include('nav')
@endsection
