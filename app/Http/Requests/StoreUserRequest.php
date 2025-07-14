<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:8|max:100',
            'role' => 'required|string|in:admin,operator',
            'username' => 'required|min:8|max:100|unique:users,username',
            'email' => 'required|min:8|email|max:100|unique:users,email',
            'password' => [
                            'required',
                            'string',
                            'min:8',
                            'max:100',
                            'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'
                        ]
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with("modal", "admin-add")
        );
    }
    public function messages(){
        return [
            'password.regex' => 'password harus mengandung huruf besar, huruf kecil dan angka'
        ];
    }
    
}
