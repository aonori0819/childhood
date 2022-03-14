<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Family;
use App\Models\Memory;
use App\Models\User;
use Exception;


class FamilyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //家族設定新規登録フォーム
    public function create(Family $family)
    {
        return view('families.create', compact('family'));
    }

    //家族設定の新規登録
    public function store(Request $request)
    {
        DB::beginTransaction();
        try{
            $family = Family::create(
                ['id'=> $request->id],
                ['name' => $request->name],
            );

            $user =Auth::user();

            //user_detailにfamily_idを紐づける
            $user = Auth::user();
            $user_detail = User::find($user->id)->user_detail;
            $user_detail->family_id = $family->id;
            $user_detail->save();

            //家族設定前に投稿した全ての思い出にfamily_idを紐づける
            $memories = Memory::where('user_id', $user->id)->get();
            foreach ($memories as $memory)
            {
                $memory->family_id = $family->id;
            }

        }catch(Exception $e){
            DB::rollback();
            return back()->withInput();
        }
        DB::commit();

        return redirect()->route('users.show', ['user' => $user ])
                         ->with('status','ファミリー名を登録しました');
    }

    //家族設定更新フォーム
    public function edit(Family $family)
    {
        return view('families.edit', compact('family'));
    }

    //家族設定の更新
    public function update(Request $request, Family $family)
    {
            $family->fill($request->all())->save();
            $user = Auth::user();

        return redirect()->route('users.show', ['user' => $user ])
                         ->with('status','ファミリー名を登録しました');
    }
}
