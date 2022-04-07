
@extends('app')

@section('title', '思い出を編集する')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="card mt-3">
          <div class="card-body pt-3">
            <div class="card-text">
              <form method="POST" action="{{ route('memories.update', ['memory' => $memory] ) }}" enctype="multipart/form-data" >
                @method('PATCH')
                @csrf
                <div class="form-group">
                    {{-- 本文 --}}
                    @if($errors->has('body')) <span class="text-danger">{{ $errors->first('body') }}</span> @endif
                    <textarea name="body" required class="form-control" rows="10" placeholder="ひとこと・できごと・おもいを入力">{{ $memory->body ?? old('body') }}
                    </textarea>

                    {{-- 画像アップロード --}}
                    @if ($memory->image_path)
                        <div class="image-upload">
                            <img src="{{ $memory->image_path }}" width="150" alt="思い出の画像">
                        </div>
                    @endif
                    <span class="image-picker">
                        <div class="mt-4"><label>■写真・画像を変更</label></div>
                        @if($errors->has('image_path')) <div class="text-danger">{{ $errors->first('image_path') }}</div> @endif
                        <input type="file" name="image_path" accept="image/png,image/jpeg,image/gif,image/svg" >
                    </span>
                    <div class="delete-image">
                        <div class="mt-4">
                            <label>■写真・画像を削除</label>
                            <input type="checkbox" name="delete_image" value="true">
                        </div>
                    </div>

                    {{-- お子さまを登録済の場合、お子さまを選ぶボタン（任意選択）を表示 --}}
                    @if (isset($child_list))
                    <div class="select-child">
                        <p>■どちらのお子さまの記録ですか？</p>
                        @foreach($child_list as $child)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="children[]" value="{{ $child->id }}" {{ $memory->children->contains($child->id) ? 'checked' : '' }}>
                                <label class="form-check-label" >{{ $child->name }}
                                    @if(isset($child->icon_path))
                                        <div>
                                            <img src="{{ $child->icon_path }}" width="50" alt="アイコン画像">
                                        </div>
                                    @endif
                                </label>
                            </div>
                        @endforeach
                    `</div>
                    @endif
                </div>
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
