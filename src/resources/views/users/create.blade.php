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
                            <form method="POST" action="{{ route('users.store', ['user' => $user ]) }}">
                                @csrf
                                <div class="form-group">
                                    <h8><p class="mt-3">ユーザーネーム</p></h8>
                                    <textarea name="name" required class="form-control" rows="1" placeholder="ユーザーネーム">{{ $user->name ?? old('name') }}</textarea>
                                    <h8><p class="mt-5">お子さまとの関係</p></h8>
                                    <textarea name="relation_to_child" required class="form-control" rows="1" placeholder="お子さまとの関係">{{ old('relation_to_child') }}</textarea>
                                    <h8><p class="mt-5">アイコン画像</p></h8>
                                    <textarea name="icon_path" class="form-control" rows="1" placeholder=" アイコン画像">画像をアップロード</textarea>
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
