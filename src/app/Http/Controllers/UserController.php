<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Family;
use App\Models\UserDetail;
use Exception;


class UserController extends Controller
{
    //家族情報一覧画面（ファミリーネーム、家族一覧、お子さま一覧）の表示
    public function show(User $user)
    {
        $data = $this->collectUserInfo($user);
        return view('users.show', compact('data'));
    }

    //ユーザー詳細情報（ユーザーネーム、お子さまとの関係、アイコン画像）の新規登録フォーム
    public function create(User $user)
    {
        return view('users.create', compact('user'));
    }

    //ユーザー詳細情報（ユーザーネーム、お子さまとの関係、アイコン画像）の新規登録
    public function store(Request $request, User $user)
    {
        DB::beginTransaction();
        try{
            $user->name = $request->name;
            $user->save();
            $user_detail = User::find($user->id)->user_detail;
            $user_detail->relation_to_child = $request->relation_to_child;
            $user_detail->icon_path = $request->icon_path;
            $user_detail->save();

        }catch(Exception $e){
            DB::rollback();
            return back()->withInput();
        }
        DB::commit();

        return redirect()->route('users.show', ['user' => $user,])
                            ->with('status','家族情報を登録しました');
    }

    //ユーザー詳細情報（ユーザーネーム、お子さまとの関係、アイコン画像）の更新フォーム
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    //ユーザー詳細情報（ユーザーネーム、お子さまとの関係、アイコン画像）の更新
    public function update(Request $request, User $user)
    {
        DB::beginTransaction();
        try{
            $user->name = $request->name;
            $user->save();
            $user_detail = User::find($user->id)->user_detail;
            $user_detail->relation_to_child = $request->relation_to_child;
            $user_detail->icon_path = $request->icon_path;
            $user_detail->save();

        }catch(Exception $e){
            DB::rollback();
            return back()->withInput();
        }
        DB::commit();

        return redirect()->route('users.show', ['user' => $user,])
                            ->with('status','家族情報を更新しました');
    }

    //ビューに渡すためのデータを集める
    private function collectUserInfo(User $user): array
    {
        $user_detail = User::find($user->id)->user_detail;

        if (isset( $user_detail->family_id )){

            $family = UserDetail::find($user_detail->id)->family;
            $user_details = Family::find($family->id)->user_details;
            $children = Family::find($family->id)->children;

        } else {
            $family = null;
            $user_details = null;
            $children = null;
        }

        $data = [
            'user' => $user,
            'family' => $family,
            'user_details' => $user_details,
            'children' => $children,
        ];

        return $data;
    }
}