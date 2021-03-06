<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Models\Family;
use App\Models\UserDetail;
use App\Models\Icon;
use Exception;


class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->authorizeResource(User::class, 'user'); //ポリシー適用
    }

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
    public function store(UserRequest $request, User $user)
    {
        DB::beginTransaction();
        try{
            $user->name = $request->name;
            $user->save();
            $user_detail = User::find($user->id)->userDetail;
            $user_detail->relation_to_child = $request->relation_to_child;

            //アイコン画像の保存
            if ($request->icon_path) {
              
                $user_detail->icon_path = Icon::saveFile($request);
            }

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
    //family_id設定済の場合、詳細情報の新規登録時もこのフォーム
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    //ユーザー詳細情報（ユーザーネーム、お子さまとの関係、アイコン画像）の更新
    //family_id設定済の場合、詳細情報の新規登録もこのアクションメソッド
    public function update(UserRequest $request, User $user)
    {
        DB::beginTransaction();
        try{
            $user->name = $request->name;
            $user->save();
            $user_detail = User::find($user->id)->userDetail;
            $user_detail->relation_to_child = $request->relation_to_child;

            //アイコン画像の変更
            if ($request->icon_path) {

                if($user_detail->icon_path)
                {
                    Storage::disk('s3')->delete('storage/icon/'.$user_detail->icon_path); //前回アップロードしたファイルがある場合は削除
		}
		$icon = $request->file('icon_path');
	        $path = Storage::disk('s3')->putFile('storage/icon', $icon, 'public');
		$file_name = Storage::disk('s3')->url($path);
                $user_detail->icon_path = $file_name;
            }

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
        $user_detail = User::find($user->id)->userDetail;

        if (isset( $user_detail->family_id )){

            $family = UserDetail::find($user_detail->id)->family;
            $user_details = Family::find($family->id)->userDetails;
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
