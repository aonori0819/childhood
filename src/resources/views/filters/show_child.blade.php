@extends('app')

@section('title', '思い出一覧')

@section('content')
    {{-- 検索フォーム --}}
    <div class="container">
        <div class="row">
            <div>
                <form class="form-inline" action="{{route('filters.showByChild',[ 'child_id' => $child_id ]) }}">
                    <input class="form-control" type="text" name="keyword" value="{{$keyword}}" placeholder="">
                    <button type="submit" class="btn btn-link"><i class="fas fa-search"></i></button>
                </form>
            </div>
        </div>
    </div>

    {{-- 思い出本文 --}}
    <div class="container">
        @foreach($memories as $memory)
                @include('memories.card')
        @endforeach
    </div>

    {{-- ページネーション --}}
    <div class="container">
        <div class="mt-2">
            <div class="paginate">
                {{ $memories->appends(Request::only('keyword'))->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>

    {{-- 入力フォーム --}}
    <div class="container">
        <div class="col-12 mt-2">
            <a href="{{ route('memories.create') }}">
                <input type="text" class="form-control" placeholder="ひとこと・できごと・おもいを入力">
            </a>
        </div>
    </div>

  @include('nav')
@endsection
