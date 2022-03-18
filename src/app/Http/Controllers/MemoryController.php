<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MemoryRequest;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\Models\Memory;
use App\Models\Child;
use App\Models\User;
use App\Models\Family;
use App\Models\UserDetail;

class MemoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->authorizeResource(Memory::class, 'memory');
    }

    public function index()
    {
        $user = Auth::user();
        $user_detail = User::find($user->id)->user_detail;

        //family_id設定済（先にファミリー名を設定済orメール招待）の場合、同じファミリーに紐づく全てのお子さまを取得してビューのチェックボックスに表示
        if (isset($user_detail->family_id))
        {
            $family = UserDetail::find($user_detail->id)->family;
            $children = Family::find($family->id)->children;
        }

        $memories = Memory::all()->sortBy('created_at');

        return view('memories.index', compact('memories'));
    }

    public function create()
    {
        $user = Auth::user();
        $user_detail = $user->user_detail;

        //family_id設定済（先にファミリー名を設定済orメール招待）の場合、同じファミリーに紐づく全てのお子さまを取得してビューのチェックボックスに表示
        if (isset($user_detail->family_id))
        {
            $family = UserDetail::find($user_detail->id)->family;
            $child_list = Family::find($family->id)->children->pluck("name", "id");
        }else {
            $child_list = null;
        }

        return view('memories.create', compact('child_list'));
    }

    public function store(MemoryRequest $request)
    {
        $memory = new Memory;
        $memory->user_id = Auth::id();
        $memory->body = $request->body;

        //family_id登録済の場合
        if (null!==($request->user()->user_detail->family_id))
        {
            $memory->family_id = $request->user()->user_detail->family_id;
        }

        //アップロード画像の保存
        if ($request->image_path) {
            $file = $request->file('image_path');                          //ファイルを取得
            $file_name = uniqid("image_") . "." . $file->guessExtension(); //ユニークIDをファイル名にする
            $file->storeAs('upload', $file_name, ['disk' => 'public']);    //ファイルを格納
            $memory->image_path = $file_name;
        }

        $memory->save();

        //思い出に子どもを紐づけて投稿する場合
        if (null!==($request->children))
        {
            foreach ($request->children as $child)
            {
                $memory->children()->attach($child);
            }
        }

        return redirect()->route('memories.index');
    }

    public function edit(Memory $memory)
    {
        $user = Auth::user();
        $user_detail = User::find($user->id)->user_detail;

        //family_id設定済（先にファミリー名を設定済orメール招待）の場合
        if (isset($user_detail->family_id))
        {
            $family = UserDetail::find($user_detail->id)->family;
            $child_list = Family::find($family->id)->children->pluck("name", "id");
        }else {
            $children = null;
        }

        return view('memories.edit', compact('memory','child_list'));
    }

    public function update(MemoryRequest $request, Memory $memory)
    {
        //思い出に子どもを紐づけて投稿する場合
        if (null!==($memory->children()))
        {
            $memory->children()->detach();
        }

        if (null!==($request->children))
        {
            $memory->children()->attach($request->children);
        }

        $memory->body = $request->body;

        //前回アップロードした画像の削除
        $previous_file = $memory->image_path;

        if ($request->delete_image==true)
        {
            Storage::disk('public')->delete('upload/'.$previous_file);
            $memory->image_path = null;
        }

        //アップロード画像の保存
        if ($request->image_path)
        {
            if($memory->image_path)
            {
                Storage::disk('public')->delete('upload/'.$previous_file); //前回アップロードしたファイルがある場合は削除
            }
            $file = $request->file('image_path');                          //今回アップロードされたファイルを取得
            $file_name = uniqid("image_") . "." . $file->guessExtension(); //ユニークIDをファイル名にする
            $file->storeAs('upload', $file_name, ['disk' => 'public']);    //ファイルを格納
            $memory->image_path = $file_name;
        }

        $memory->save();

        return redirect()->route('memories.index');
    }

    public function destroy(Memory $memory)
    {
        //アップロード画像がある場合、削除
        $previous_file = $memory->image_path;
        if ($previous_file)
        {
            Storage::disk('public')->delete('upload/'.$previous_file);
        }

        $memory->delete();

        return redirect()->route('memories.index');
    }

    public function show(Memory $memory)
    {
        return view('memories.show', compact('memory'));
    }

}
