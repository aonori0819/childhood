@extends('app')

@section('title', '家族設定')

@section('content')

    <h4><p class="text-center mt-3">家族設定</p></h4>

{{-- ファミリー名設定 --}}
    <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="card mt-3">
              <div class="card-body pt-3">
                <div class="card-text">
                    {{-- familyネーム未設定／family_id未設定の場合 --}}
                    @if (is_null($data['family']))
                        <p>ファミリー名はまだ登録されていません</p>
                        <a href="{{ route('families.create') }}">　
                            <button type="submit" class="btn btn-link">ファミリー名設定　<i class="fa-solid fa-gear"></i></button>
                        </a>
                    @elseif (is_null($data['family']->name))
                    {{-- familyネーム未設定／family_id設定済の場合 --}}
                        <p>ファミリー名はまだ登録されていません</p>
                        <a href="{{ route('families.edit', ['family' => $data['family'] ]) }}">　
                            <button type="submit" class="btn btn-link">ファミリー名設定　<i class="fa-solid fa-gear"></i></button>
                        </a>
                    @else
                    {{-- familyネーム設定済／family_id設定済の場合 --}}
                        {{ $data['family']->name }}
                        <a href="{{ route('families.edit', ['family' => $data['family'] ]) }}">　
                            <button type="submit" class="btn btn-link">ファミリー名変更　<i class="fa-solid fa-gear"></i></button>
                        </a>
                    @endif
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

{{-- 家族一覧 --}}
    <h8><p class="text-center mt-5">家族一覧</p></h8>
    <div class="container">
        <div class="card mt-3">
            <div class="card-body">
                <div class="d-flex flex-row">
                    <div class="card-text">
                    {{-- family_id設定済みの場合、同じfamilyに属する家族の名前を表示する --}}
                        @if (isset($data['family']))
                            @foreach($data['user_details'] as $user_detail)
                                <div>
                                    {{ $user_detail->user->name }}
                                   （  {{ $user_detail->relation_to_child }}  ）
                                    <a href="{{ route('users.edit', ['user' => $user_detail->user, 'user_detail => $user_detail' ] ) }}" class="text-dark"><i class="fa-solid fa-gear"></i></a>
                                </div>
                            @endforeach

                    {{-- family_id未設定／お子さまとの関係設定済の場合、ログインユーザーの名前を表示してeditに --}}
                        @elseif(isset($data['user']->user_detail->relation_to_child))
                            <div>
                                {{ $data['user']->name }}
                                <a href="{{ route('users.edit', ['user' => $data['user'], 'user_detail' => $data['user']->user_detail ] ) }}" class="text-dark"><i class="fa-solid fa-gear"></i></a>
                            </div>
                    {{-- family_id未設定／お子さまとの関係未設定の場合、ログインユーザーの名前を表示してcreateに --}}
                        @else
                            <div>
                                {{ $data['user']->name }}
                                <a href="{{ route('users.create', ['user' => $data['user'] ] ) }}" class="text-dark"><i class="fa-solid fa-gear"></i></a>
                            </div>
                        @endif
                        {{-- ここで「＋家族を招待する」ボタンを追加 --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

{{-- お子さま一覧 --}}
    <h8><p class="text-center mt-5">お子さま一覧</p></h8>
    <div class="container">
        <div class="card mt-3">
            <div class="card-body">
                <div class="d-flex flex-row">
                    <div class="card-text">
                    {{--  登録済みのお子さまの名前を表示する --}}
                        @if (!is_null($data['children']))
                            @foreach($data['children'] as $child)
                                <div>
                                    {{ $child->name }}
                                    <a href="{{ route('children.edit', ['child' => $child ] ) }}" class="text-dark"><i class="fa-solid fa-gear"></i></a>
                                </div>
                            @endforeach
                        @endif

                    {{--  お子さまを追加する --}}
                        <a href="{{ route('children.create') }}" class="text-dark">＋お子さまを追加する</a>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center mt-5">
        <form id="logout-form" action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="btn btn-link" data-mdb-ripple-color="dark" style="border: solid 1px #ccc;">ログアウトする</button>
        </form>
    </div>
@include('nav')
@endsection
