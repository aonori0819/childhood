<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:20',
            'relation_to_child' => 'required|max:20',
            'icon_path' => 'file|image|max:1024|dimensions:max_width=500,max_height=500',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'ユーザーネーム',
            'relation_to_child' => 'お子さまとの関係',
            'icon_path' => 'アイコン画像',

        ];
    }

    public function messages() {
        return [
            "name.required" => "ユーザーネームを入力してください。",
            "name.max" => "ユーザーネームは20文字以内で入力してください。",
            "relation_to_child.required" => "お子さまとの関係を入力してください。",
            "relation_to_child.max" => "お子さまとの関係は20文字以内で入力してください。",
            "icon_path.file" => "アップロードできる画像の形式は、jpg,png,bmp,gif,svgです。",
            "icon_path.image" => "アップロードできる画像の形式は、jpg,png,bmp,gif,svgです。",
            "icon_path.max" => "アップロードできる画像の容量は最大1MBです。",
            "icon_path.dimensions" => "アップロードできる画像の大きさは、最大で縦500px・横500pxです。",
        ];
      }
}
