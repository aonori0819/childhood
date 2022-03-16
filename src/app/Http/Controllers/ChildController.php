<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ChildRequest;
use App\Models\Child;
use App\Models\User;
use App\Models\Family;
use App\Models\Memory;
use App\Models\UserDetail;
use Exception;


class ChildController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->authorizeResource(Child::class, 'child'); //ポリシー適用
    }

    //お子さま情報の新規登録フォーム
    public function create()
    {
        return view('children.create');
    }

    //お子さま情報の新規登録
    public function store(ChildRequest $request)
    {
        DB::beginTransaction();
        try{
            //アイコン画像の保存
            if ($request->icon_path) {
                $file = $request->file('icon_path');                          //ファイルを取得
                $file_name = uniqid("icon_") . "." . $file->guessExtension(); //ユニークIDをファイル名にする
                $file->storeAs('icon', $file_name, ['disk' => 'public']);     //ファイルを格納
            } else {
                $file_name = null;
            }

            $child = Child::Create(
                ['name' => $request->name,
                 'icon_path' => $file_name,
                 'birthday' => $request->birthday ],
            );

        //family_idにchildを紐づける
            $user = Auth::user();
            $user_detail = User::find($user->id)->user_detail;

            //family_id設定済（先にファミリー名を設定済orメール招待）の場合
            if (isset($user_detail->family_id))
            {
                $family = UserDetail::find($user_detail->id)->family;

            } else {
            //family_id未設定（ファミリー名未設定orメール招待）の場合
                $family = new Family();
                $family->save();
                $user_detail->family_id = $family->id;
                $user_detail->save();
            }

            $child->family_id = $family->id;
            $child->save();

            //家族設定前に投稿した全ての思い出にfamily_idを紐づける
            $memories = Memory::where('user_id', $user->id)->get();
            foreach ($memories as $memory)
            {
                $memory->family_id = $family->id;
                $memory->save();
            }

        }catch(Exception $e){
            DB::rollback();
            return back()->withInput();
        }
        DB::commit();

        return redirect()->route('users.show', ['user' => $user])
                         ->with('status','お子さま情報を登録しました');
    }

    //お子さま情報の更新フォーム
    public function edit(Child $child)
    {
        return view('children.edit', compact('child'));
    }

    //お子さま情報の更新
    public function update(ChildRequest $request, Child $child)
    {
        $child->name = $request->name;
        $child->birthday = $request->birthday;

        //アイコン画像の変更
        if ($request->icon_path) {

            if($child->icon_path)
            {
                Storage::disk('public')->delete('icon/'.$child->icon_path); //前回アップロードしたファイルがある場合は削除
            }
            $file = $request->file('icon_path');                          //今回アップロードされたファイルを取得
            $file_name = uniqid("icon_") . "." . $file->guessExtension(); //ユニークIDをファイル名にする
            $file->storeAs('icon', $file_name, ['disk' => 'public']);     //ファイルを格納
            $child->icon_path = $file_name;
        }
        $child->save();
        $user = Auth::user();

        return redirect()->route('users.show', ['user' => $user])
                         ->with('status','お子さま情報を更新しました');
    }

    //お子さま情報の削除
    public function destroy(Child $child)
    {
        $child->delete();
        $user = Auth::user();

        return redirect()->route('users.show', ['user' => $user])
                         ->with('status','お子さま情報を削除しました');
    }
}
