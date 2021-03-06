<?php

namespace App\Http\Controllers;

use App\Http\Requests\MemoryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Memory;
use App\Models\User;
use App\Models\Family;
use App\Models\UserDetail;

class MemoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->authorizeResource(Memory::class, 'memory');  //ポリシー適用
    }

    public function index(Request $request)
    {
        $user = Auth::user();

        //family_id設定済の場合
        if (isset($user->userDetail->family))
        {
            $family = $user->userDetail->family;

            $query = Memory::query();
            $query->where('family_id', $family->id)->orderBy('created_at','desc');

            //検索窓とページネーション
            $keyword = $request->input('keyword');
            if (!empty($keyword)) {
                $query->where('body', 'like', '%' . $keyword . '%');
            }

            $memories = $query->paginate(10);

        } else {
        //family_id未設定の場合

            $query = Memory::query();
            $query->where('user_id', $user->id)->orderBy('created_at','desc');

            //検索窓とページネーション
            $keyword = $request->input('keyword');
            if (!empty($keyword)) {
                $query->where('body', 'like', '%' . $keyword . '%');
            }

            $memories = $query->paginate(10);

        }

        return view('memories.index', compact('memories', 'keyword'));

    }

    public function show(Memory $memory)
    {
        return view('memories.show', compact('memory'));
    }

    public function create()
    {
        $user = Auth::user();

        //family_id設定済の場合、同じファミリーに紐づく全てのお子さまを取得してビューのチェックボックスに表示
        if (isset($user->userDetail->family))
        {
            $child_list = Family::find($user->userDetail->family->id)->children;

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

        //family_id設定済の場合
        if (isset($request->user()->userDetail->family_id))
        {
            $memory->family_id = $request->user()->userDetail->family_id;
        }

        //アップロード画像の保存
	if ($request->image_path) {

            $image = $request->file('image_path');
	    $path = Storage::disk('s3')->putFile('storage/image', $image, 'public');
	    $file_name = Storage::disk('s3')->url($path);

            $memory->image_path = $file_name;
        }

        $memory->save();

        //思い出に子どもを紐づけて投稿する場合
        if (isset($request->children))
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

        //family_id設定済の場合
        if (isset($user->userDetail->family))
        {
            $child_list = Family::find($user->userDetail->family->id)->children;
        }else {
            $child_list = null;
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
            Storage::disk('s3')->delete('storage/image/'.$previous_file);
            $memory->image_path = null;
        }

        //アップロード画像の保存
        if (isset($request->image_path))
        {
            if(isset($memory->image_path))
            {
                Storage::disk('s3')->delete('storage/image/'.$previous_file); //前回アップロードしたファイルがある場合は削除
	    }
	    $image = $request->file('image_path');
	    $path = Storage::disk('s3')->putFile('storage/image', $image, 'public');
	    $file_name = Storage::disk('s3')->url($path);
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
            Storage::disk('s3')->delete('storage/image/'.$previous_file);
        }

        $memory->delete();

        return redirect()->route('memories.index');
    }

}
