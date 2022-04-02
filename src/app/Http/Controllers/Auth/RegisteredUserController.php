<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\Invite;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;
use Exception;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {
        //家族招待URLの有効期限が切れている場合
        if((isset($request->token))&& (! $request->hasValidSignature()))
        {
            return view('invite.error');
        }

        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        DB::beginTransaction();
        try{

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $user_detail = UserDetail::create(['user_id' => $user->id]);

            //家族招待URLから登録した場合、family_idを紐づける
            if(isset($request->token))
            {
                $invite = Invite::where('token', $request->token)->firstOrFail();
                $user_detail->family_id = $invite->family_id;
                $user_detail->save();
            }

        }catch(Exception $e){
            DB::rollback();
            return back()->withInput();
        }
        DB::commit();

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
