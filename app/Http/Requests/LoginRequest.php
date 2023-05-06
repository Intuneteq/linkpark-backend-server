<?php

namespace App\Http\Requests;

use App\Exceptions\CreateApiException;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    protected $user;
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'email.required' => 'email is a required field',
            'email.email' => 'Invalid Email',
            'password.required' => 'Password is a required field'
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @throws \App\Exceptions\CreateApiException
     */
    protected function failedValidation($validator)
    {
        // throw 422
        throw new CreateApiException($validator->errors()->first(), 422);
    }
}
