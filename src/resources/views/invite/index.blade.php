@extends('app')

@section('title', '家族を招待する')

@section('content')
    <h8><p class="text-center mt-5">家族招待メールを送信する</p></h8>
    <div class="container">
    　<div class="row">
        <div class="col-12">
        　<div class="card">
            　<div class="card-body pt-3">
                <div class="card-text d-flex justify-content-center">
                    <form method="post" action="{{ route('invite.send') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">送信先のメールアドレス</label>
                            <input type="email" class="form-control" id="email" name="email" style="width:450px">
                        </div>
                        <div class="d-flex justify-content-center mt-3">
                            <button type="submit" class="btn blue-gradient btn-block" style="width:150px">送信する</button>
                        </div>
                    </form>
                </div>
            </div>
          </div>
        </div>
    </div>
    <div class="d-flex justify-content-center mt-3">
        <button type="button" onClick="history.back()" class="btn btn-block bg-white btn-outline-teal1 text-decoration-none text-teal1 mt-3" style="width:150px">
        <i class="fas fa-arrow-left mr-1"></i>戻る
        </button>
    </div>

@include('nav')
@endsection
