<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TagRequest extends FormRequest
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
            $unique = 'unique:tags,name,' . $this->id;
        }
        else {
            $unique = 'unique:tags';
        }

        return [
            'name' => 'required|max:100|' . $unique,
            'color' => 'required|regex:/#[a-zA-Z0-9]{6}/',
            'background_color' => 'required|regex:/#[a-zA-Z0-9]{6}/'
        ];
    }
}
