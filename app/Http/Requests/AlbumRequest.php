<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AlbumRequest extends FormRequest
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
            //  'description' => 'required',
            'album_thumb' => 'required|image',
            // 'user_id' => 'require'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'Il campo :attribute è obbligatorio.'
        ];
    }
}
