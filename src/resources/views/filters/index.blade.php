@extends('app')

@section('title', '思い出をふりかえる')

@section('content')

    {{-- PickUp思い出の表示（ランダムに選ばれる） --}}
    <h8><p class="text-center mt-5">PickUp思い出</p></h8>
    <div class="container">
        @if (isset($memory))
                @include('memories.card')
        @endif
    </div>

    {{-- お子さまを登録済の場合、お子さまごとの思い出一覧へのリンクバナーを表示 --}}
    <h8><p class="text-center mt-4">お子さまごとの思い出をみる</p></h8>
    <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="card mt-2">
              <div class="card-body pt-2">
                <div class="card-text">
                    @if (isset($child_list))
                    <div class="form-inline justify-content-center">
                        @foreach($child_list as $child)
                            <a href="{{ route('filters.showByChild', [ 'child_id' => $child->id ])}}" class="mr-3">
                                <label>{{ $child->name }}</label>
                                @if(isset($child->icon_path))
                                    <image src="{{ asset('storage/icon/' . $child->icon_path ) }}" width="50" alt="{{ $child->name }}">
                                @endif
                            </a>
                        @endforeach
                    </div>
                    @endif
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>

    {{-- 年月別の思い出一覧へのリンクを表示 --}}
    <h8><p class="text-center mt-4">月ごとの思い出をみる</p></h8>
    <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="card mt-2">
              <div class="card-body pt-2">
                <div class="card-text">
                    @if (isset($month_list))
                    <div class="form-inline justify-content-center">
                        @foreach($month_list as $month_year)
                            <a href="{{ route('filters.showByMonth',[ 'month_year' => $month_year ])}}" class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded mr-3 mt-3" >{{ $month_year }}</a>
                        @endforeach
                    </div>
                    @endif
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>


  @include('nav')
@endsection
