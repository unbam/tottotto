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
        // 変更
        if ($this->id) {
            return [
                'login_id' => 'required|max:30|unique:users,login_id,' . $this->id,
                'name' => 'required|max:50',
                'email' => 'required|email|max:255|unique:users,email,' . $this->id,
            ];
        }
        // 新規
        else {
            return [
                'login_id' => 'required|max:30|unique:users',
                'name' => 'required|max:50',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|min:1|max:30|confirmed'
            ];
        }
    }
}
