<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;
class StoreUserRequest extends FormRequest
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
            'name' => 'required',
            'roll_number' => 'required',
            'mobile_number' => 'required|unique:users,mobile_number',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ];
    }
}
