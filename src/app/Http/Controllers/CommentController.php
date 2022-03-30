<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Memory;
use App\Http\Requests\CommentRequest;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->authorizeResource(Comment::class, 'comment'); //ポリシー適用
    }

    public function store(CommentRequest $request, Comment $comment)
    {
        $comment->user_id = $request->user()->id;
        $comment->memory_id = $request->memory_id;
        $comment->body = $request->body;
        $comment->save();
        $memory = Memory::findOrFail($comment->memory_id);

        return redirect()->route('memories.show', ['memory' => $memory])->with('status','コメントを投稿しました');
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();
        $memory = Memory::find($comment->memory_id);

        return redirect()->route('memories.show', ['memory' => $memory])->with('status','コメントを削除しました');
    }
}
