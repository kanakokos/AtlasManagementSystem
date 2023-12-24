<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; //false ⇒ true に変更(アクセス権限を求めない場合true)
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

            //ここからバリデーションルール
    public function rules()
    {
        return [
            'over_name' => 'required|string|max:10',
            'under_name' => 'required|string|max:10',
            'over_name_kana' => 'required|string|regex:/\A[ァ-ヴー]+\z/u|max:30',
            'under_name_kana' => 'required|string|regex:/\A[ァ-ヴー]+\z/u|max:30',
            'mail_address' => 'required|email|unique:users,mail_address|max:100',
            'sex' => 'required|in:1,2,3',
            'old_year' => 'required|after_or_equal:2000-01-01|before_or_equal:today',
            'old_month' => 'required|after_or_equal:2000-01-01|before_or_equal:today',
            'old_day' => 'required|after_or_equal:2000-01-01|before_or_equal:today',
            'role' => 'required|in:1,2,3,4',
            'password' => 'required|min:8|max:30|confirmed', //regex:/^[a-zA-Z0-9]*$/|
        ];
    }



            //ここからエラーメッセージ
    public function messages()
    {
        return [
            //over_name
            'over_name.required' => '姓は必須です',
            'over_name.string' => '姓は文字列で入力してください',
            'over_name.max' => '姓は10文字以内で入力してください',

            //under_name
            'under_name.required' => '名は必須です',
            'under_name.string' => '名は文字列で入力してください',
            'under_name.max' => '名は10文字以内で入力してください',

            //over_name_kana
            'over_name_kana.required' => 'セイは必須です',
            'over_name_kana.string' => 'セイは文字列で入力してください',
            'over_name_kana.regex:/\A[ァ-ヴー]+\z/u' => 'セイはカナで入力してください',
            'over_name_kana.max' => 'セイは30文字以内で入力してください',

            //under_name_kana
            'under_name_kana.required' => '名は必須です',
            'under_name_kana.string' => '名は文字列で入力してください',
            'under_name_kana.regex:/\A[ァ-ヴー]+\z/u' => 'セイはカナで入力してください',
            'under_name_kana.max' => '名は30文字以内で入力してください',

            //mail_address
            'mail_address.required' => 'メールアドレスは必須です',
            'mail_address.email' => '有効なメールアドレスを入力してください',
            'mail_address.unique:users,mail_address' => 'このメールアドレスは既に使用されています',
            'mail_address.max' => 'メールアドレスは100文字以内で入力してください',

            //sex　
            'sex.required' => '性別は必須です',
            'sex.in:1,2,3' => '性別を選択してください',

            //old_year,old_month,old_day　
            'old_year.required' => '年は必須です',
            'old_month.required' => '月は必須です',
            'old_day.required' => '日は必須です',
            // 'old_year.required_with:birth_month,birth_day' => '生年月日（年）が正しくありません',
            // 'old_month.required_with:birth_year,birth_day' => '生年月日（月）が正しくありません',
            // 'old_day.required_with:birth_year,birth_month' => '生年月日（日）が正しくありません',
            'old_year.after_or_equal:2000-01-01' => '2000年1月1日以降で選択してください',
            'old_month.after_or_equal:2000-01-01' => '2000年1月1日以降で選択してください',
            'old_day.after_or_equal:2000-01-01' => '2000年1月1日以降で選択してください',
            'old_year.before_or_equal:today' => '本日以前で選択してください',
            'old_month.before_or_equal:today' => '本日以前で選択してください',
            'old_day.before_or_equal:today' => '本日以前で選択してください',

            //role
            'role.required' => '役職は必須です',
            'role.in:1,2,3,4' => '役職を選択してください',

            //password
            'password.required' => 'パスワードは必須です',
            'password.min' => 'パスワードは8文字以上で入力してください',
            'password.max' => 'パスワードは30文字以内で入力してください',
            'password.confirmed' => 'パスワードを再度入力してください',

        ];
    }

}
