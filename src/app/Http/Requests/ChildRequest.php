<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChildRequest extends FormRequest
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
            'birthday' => 'required|date',
            'icon_path' => 'file|image|max:1024|dimensions:max_width=500,max_height=500',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'お名前',
            'birthday' => 'お誕生日',
            'icon_path' => 'アイコン画像',
        ];
    }

    public function messages() {
        return [
            "name.required" => "お子さまのお名前を入力してください。",
            "name.max" => "お名前は20文字以内で入力してください。",
            "birthday.required" => "お子さまのお誕生日を入力してください。",
            "birthday.date" => "お誕生日は「2020/1/7」のように入力してください",
            "icon_path.file" => "アップロードできる画像の形式は、jpg,png,bmp,gif,svgです。",
            "icon_path.image" => "アップロードできる画像の形式は、jpg,png,bmp,gif,svgです。",
            "icon_path.max" => "アップロードできる画像の容量は最大1MBです。",
            "icon_path.dimensions" => "アップロードできる画像の大きさは、最大で縦500px・横500pxです。",
        ];
      }
}
