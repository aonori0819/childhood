<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
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
            'body' => 'required|max:350',
        ];
    }

    public function attributes()
    {
        return [
            'body' => 'コメント',
        ];
    }

    public function messages() {
        return [
            "body.required" => "コメントを入力してください。",
            "body.max" => "コメントは350文字以内で入力してください。",
        ];
      }
}
