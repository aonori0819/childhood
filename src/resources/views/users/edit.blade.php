@extends('app')

@section('title', '家族情報登録')

@section('content')
    <h4><p class="text-center mt-3">家族情報登録</p></h4>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card mt-3">
                    <div class="card-body">
                        <div class="card-text">
                            <form method="POST" action="{{ route('users.update', ['user' => $user ]) }}" enctype="multipart/form-data">
                                @method('PATCH')
                                @csrf
                                <div class="form-group">
                                    <h8><p class="mt-3">ユーザーネーム</p></h8>
                                    @if($errors->has('name')) <span class="text-danger">{{ $errors->first('name') }}</span> @endif
                                    <textarea name="name" class="form-control" rows="1" placeholder="ユーザーネーム">{{ $user->name ?? old('name') }}</textarea>
                                    <h8><p class="mt-5">お子さまとの関係</p></h8>
                                    @if($errors->has('relation_to_child')) <span class="text-danger">{{ $errors->first('relation_to_child') }}</span> @endif
                                    <textarea name="relation_to_child" class="form-control" rows="1" placeholder="お子さまとの関係">{{ $user->userDetail->relation_to_child ?? old('relation_to_child') }}</textarea>
                                    <div class="image-picker">
                                        <label><p class="mt-5">アイコン画像</p></label>
                                        @if ($user->userDetail->icon_path)
                                            <div>
                                                <img src="{{ asset('storage/icon/' . $user->userDetail->icon_path ) }}" width="150" alt="アイコン画像">
                                            </div>
                                        @endif
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
