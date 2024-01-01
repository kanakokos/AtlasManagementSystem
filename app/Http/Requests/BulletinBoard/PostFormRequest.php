<?php

namespace App\Http\Requests\BulletinBoard;

use Illuminate\Foundation\Http\FormRequest;

class PostFormRequest extends FormRequest
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
            'post_title' => 'required|max:100',
            'post_body' => 'required|max:5000',
            'sub_category_id' => 'exists:sub_categories,id',
        ];
    }

    public function messages(){
        return [
            "required" => "必須項目です",
            'post_title.max' => 'タイトルは100文字以内で入力してください。',
            'post_body.max' => '最大文字数は5000文字です。',
            'sub_category_id.exists:sub_categories,id' => '登録されているカテゴリーを選択してください。',
        ];
    }
}
