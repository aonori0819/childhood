<?php

namespace App\Models;
use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Icon extends Model
{
    use HasFactory;

    public static function saveFile(Request $request)
    {
        $file = $request->icon_path;                                  //ファイルを取得
        $file_name = uniqid("icon_") . "." . $file->guessExtension(); //ユニークIDをファイル名にする
        $file->storeAs('icon', $file_name, ['disk' => 'public']);     //ファイルを格納

        return $file_name;
    }
}
