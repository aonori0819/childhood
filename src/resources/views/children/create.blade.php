@extends('app')

@section('title', 'お子さま登録')

@section('content')
    <h4><p class="text-center mt-3">お子さま登録</p></h4>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card mt-3">
                    <div class="card-body">
                        <div class="card-text">
                                <form method="POST" action="{{ route('children.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <h8><p class="mt-3">お子さまのお名前</p></h8>
                                    @if($errors->has('name')) <span class="text-danger">{{ $errors->first('name') }}</span> @endif
                                    <textarea name="name" class="form-control" rows="1" placeholder="ユーザーネーム">{{ $user->name ?? old('name') }}</textarea>
                                    <h8><p class="mt-5">お誕生日</p></h8>
                                    @if($errors->has('birthday')) <span class="text-danger">{{ $errors->first('birthday') }}</span> @endif
                                    <textarea name="birthday" class="form-control" rows="1" placeholder="お誕生日（例：2020/1/7）">{{ old('birthday') }}</textarea>
                                    <div class="image-picker">
                                        <label><p class="mt-5">アイコン画像</p></label>
                                        @if($errors->has('icon_path')) <div class="text-danger">{{ $errors->first('icon_path') }}</div> @endif
                                        <div>
                                            <input type="file" name="icon_path" accept="image/png,image/jpeg,image/gif,image/svg">
                                        </div>
                                     </div>
                                    <div class="mt-3">
                                        <button type="submit" class="btn blue-gradient">登録</button>
                                    </div>
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
