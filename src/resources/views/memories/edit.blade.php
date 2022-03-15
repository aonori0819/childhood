
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
                    <textarea name="body" required class="form-control" rows="16" placeholder="ひとこと・できごと・おもいを入力">{{ $memory->body ?? old('body') }}
                    </textarea>
                    {{-- 画像アップロード --}}
                    @if ($memory->image_path)
                        <div class="image-upload">
                            <img src="{{ asset('storage/upload/' . $memory->image_path ) }}" width="150" alt="思い出の画像">
                        </div>
                    @endif
                    <span class="image-picker">
                        <label>写真・画像を変更</label>
                        <input type="file" name="image_path" accept="image/png,image/jpeg,image/gif,image/svg" >
                    </span>
                    <div class="delete-image">
                        <label>写真・画像を削除</label>
                        <input type="checkbox" name="delete_image" value="true">
                    </div>
                    {{-- お子さまを登録済の場合、お子さまを選ぶボタン（任意選択）を表示 --}}
                    @if (isset($child_list))
                    <div class="select-child">
                        <p>どちらのお子さまの記録ですか？</p>
                        @foreach($child_list as $id => $name)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="children[]" value="{{ $id }}" {{ $memory->children->contains($id) ? 'checked' : '' }}>
                                <label class="form-check-label" >{{ $name }}</label>
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
