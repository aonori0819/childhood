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
                            <form method="POST" action="{{ route('children.update', ['child' => $child ]) }}">
                                @method('PATCH')
                                @csrf
                                <div class="form-group">
                                    <h8><p class="mt-3">お子さまのお名前</p></h8>
                                    <textarea name="name" required class="form-control" rows="1" placeholder="お子さまのお名前">{{ $child->name ?? old('name') }}</textarea>
                                    <h8><p class="mt-5">お誕生日</p></h8>
                                    <textarea name="birthday" required class="form-control" rows="1" placeholder="お誕生日">{{ $child->birthday ?? old('birthday') }}</textarea>
                                    <h8><p class="mt-5">アイコン画像</p></h8>
                                    <textarea name="icon_path" class="form-control" rows="1" placeholder=" アイコン画像">画像をアップロード</textarea>
                                    <a href= "{{ $user_details->icon_path ?? old('icon_path') }}" >
                                </div>
                                <div class="mt-3">
                                    <button type="submit" class="btn blue-gradient">登録</button>
                                </div>
                            </form>
                            <form method="POST" action="{{ route('children.destroy', $child) }}" class="delete-child">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn blue-gradient">削除</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('nav')
@endsection
