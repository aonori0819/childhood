<?php

namespace App\Models;
use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Icon extends Model
{
    use HasFactory;

    public static function saveFile(Request $request)
    {
	$icon = $request->file('icon_path');

	//imagesというファイルに、第二引数に指定した画像を保存する
	$path = Storage::disk('s3')->putFile('storage/icon', $icon, 'public');

	//アップロードした画像のフルパスを取得
	$file_name = Storage::disk('s3')->url($path);    
	    return $file_name;
    }
}
