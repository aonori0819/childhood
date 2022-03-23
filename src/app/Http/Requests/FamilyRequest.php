<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FamilyRequest extends FormRequest
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
            'name' => 'required|max:30',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'ファミリー名',
        ];
    }

    public function messages() {
        return [
            "name.required" => "ファミリー名を入力してください。",
            "name.Max" => "ファミリー名は30文字以内で入力してください。",
        ];
      }
}
