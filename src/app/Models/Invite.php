<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use SendGrid;
use App\Models\Family;
use App\Models\Memory;
use Exception;

class Invite extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'family_id',
        'token',
    ];

    //招待用トークンを発行してinviteを作る
    public static function createInvite(Request $request, $user)
    {
        do {
            $token = Str::random(16);
        } while (self::where('token', $token)->first());

        DB::beginTransaction();
        try{
            //family_id未設定（ファミリー名未設定）の場合
            if(is_null($user->userDetail->family_id))
            {
                $family = new Family();
                $family->save();
                $user->userDetail->family_id = $family->id;
                $user->userDetail->save();

                //これまでに投稿した全ての思い出にfamily_idを紐づける
                $memories = Memory::where('user_id', $user->id)->get();
                foreach ($memories as $memory)
                {
                    $memory->family_id = $family->id;
                    $memory->save();
                }
            }

            self::create([
                'email' => $request->get('email'),
                'family_id' => $user->userDetail->family_id,
                'token' => $token,
            ]);

        }catch(Exception $e){
            DB::rollback();
            return back()->withInput();
        }
        DB::commit();

        return $token;
    }

    //招待メールを送信
    public static function sendMail(Request $request, $token, $user)
    {
        $request->validate([
            'email'    => 'required|email',
        ]);

        //招待用URLを生成
        $url_invited = URL::temporarySignedRoute('register', now()->addMinutes(60), ['token' => $token]);

        //SendGridでメール送信
        $from = new \SendGrid\Mail\From('spprtchildhood@gmail.com', 'childhood事務局');
        $to = new \SendGrid\Mail\To($request->email);
        $subject = new \SendGrid\Mail\Subject('childhoodアプリへの招待');
        $htmlContent = new \SendGrid\Mail\HtmlContent(strval(view('invite.mail-content',compact('url_invited','user'))));
        $email = new \SendGrid\Mail\Mail(
            $from,
            $to,
            $subject,
            null,
            $htmlContent
        );
        $sendgrid = new SendGrid(getenv('SENDGRID_API_KEY'));
        $response = $sendgrid->send($email);

        return $response;

    }

    public function family():BelongsTo
    {
        return $this->BelongsTo('App\Models\Family');
    }
}
