<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MemoryRequest extends FormRequest
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
            'body' => 'required|max:500',
            'image_path' => 'file|image|max:3072|dimensions:max_width=1000,max_height=1000',

        ];
    }

    public function attributes()
    {
        return [
            'body' => '思い出',
            'image_path' => '写真・画像ファイル',
        ];
    }

    public function messages() {
        return [
            "body.required" => "思い出を入力してください。",
            "body.max" => "思い出は500文字以内で入力してください。",
            "image_path.file" => "アップロードできる画像の形式は、jpg,png,bmp,gif,svgです。",
            "image_path.image" => "アップロードできる画像の形式は、jpg,png,bmp,gif,svgです。",
            "image_path.max" => "アップロードできる画像の容量は最大3MBです。",
            "image.dimensions" => "アップロードできる画像の大きさは、最大で縦1000px・横1000pxです。",
        ];
      }
}
