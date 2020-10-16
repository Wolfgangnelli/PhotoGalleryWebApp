<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => [
                'required', 'string', 'email', 'max:255',
                Rule::unique('users', 'email')->ignore($this->id, 'id')
            ],
            'password' => 'nullable|string|min:8|confirmed',
            'role' => [
                'required',
                Rule::in(['user', 'admin'])
            ]
        ];
    }

    public function messages()
    {
        return [
            'name.require' => 'The name is obligatory',
            'email.require' => 'The email is obligatory',
            'role.require' => 'The role is obligatory',
        ];
    }
}
