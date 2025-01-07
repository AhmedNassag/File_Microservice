<?php

namespace App\Http\Requests\File;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
        $roles = [
            'file'          => 'required|file|mimes:png,jpg,jpeg,webp',
            'mediable_id'   => 'required',
            'mediable_type' => 'required|string',
        ];

        return $roles;
    }


    /**
     * Get the validation messages that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function messages()
    {
        return [
            'file.required'          => trans('validation.required'),
            'file.file'              => trans('validation.file'),
            'file.mimes'             => trans('validation.mimes'),
            'mediable_id.required'   => trans('validation.required'),
            'mediable_type.required' => trans('validation.required'),
            'mediable_type.string'   => trans('validation.string'),
        ];
    }
}
