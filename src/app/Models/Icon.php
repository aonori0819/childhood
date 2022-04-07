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
	$path = Storage::disk('s3')->putFile('storage/icon', $icon, 'public');
	$file_name = Storage::disk('s3')->url($path);    
	 return $file_name;
    }
}
