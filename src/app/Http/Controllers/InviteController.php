<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \Symfony\Component\HttpFoundation\Response;
use App\Models\Invite;


class InviteController extends Controller
{
    public function index()
    {
        return view('invite.index');
    }

    //家族招待メールの送信
    public function sendMail(Request $request)
    {
        $user = Auth::user();

        //tokenを発行
        $token = Invite::createInvite($request, $user);

        //SendGridでメールを送信
        $response = Invite::sendMail($request, $token, $user);

       if ($response->statusCode() == Response::HTTP_ACCEPTED) {
            return redirect()->route('users.show',compact('user'))->with('status','招待メールを送信しました');;
        } else {
            return redirect()->route('users.show',compact('user'))->with('status','メールの送信に失敗しました');;
        }
    }
}
