<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\FamilyRequest;
use App\Models\Family;
use App\Models\Memory;
use App\Models\User;
use Exception;


class FamilyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->authorizeResource(Family::class, 'family'); //ポリシー適用
    }

    //家族設定（ファミリー名）新規登録フォーム
    public function create()
    {
        return view('families.create');
    }

    //家族設定（ファミリー名）の新規登録
    public function store(FamilyRequest $request)
    {
        DB::beginTransaction();
        try{
            $family = Family::Create(
                ['name' => $request->name,]
            );

            //user_detailにfamily_idを紐づける
            $user =Auth::user();
            $user_detail = User::find($user->id)->userDetail;
            $user_detail->family_id = $family->id;
            $user_detail->save();

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

        return redirect()->route('users.show', ['user' => $user ])
                         ->with('status','ファミリー名を登録しました');
    }

    //家族設定（ファミリー名）更新フォーム
    public function edit(Family $family)
    {
        return view('families.edit', compact('family'));
    }

    //家族設定（ファミリー名）の更新
    public function update(FamilyRequest $request, Family $family)
    {
        $family->fill($request->all())->save();
        $user = Auth::user();

        return redirect()->route('users.show', ['user' => $user ])
                         ->with('status','ファミリー名を登録しました');
    }
}
