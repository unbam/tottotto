<?php

namespace App\Validation;

use App\User;
use Illuminate\Validation\Validator;

/**
 * カスタムバリデーションクラス
 * @package App\Validation
 */
class CustomValidator extends Validator {

    /**
     * 現在のパスワード確認
     * @param $attribute
     * @param $value string 入力パスワード
     * @param $parameters string ユーザーID
     * @return bool
     */
    public function validateCurrentPassword($attribute, $value, $parameters) {
        $user = User::find($parameters)->first();
        return (\Hash::check($value, $user->password));
    }
}
