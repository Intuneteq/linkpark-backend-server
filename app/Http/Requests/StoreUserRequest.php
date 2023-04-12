<?php

namespace App\Http\Requests;

use App\Exceptions\CreateApiException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {

        return [
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'school_id' => 'required',
            'user_type' => ['required', Rule::in(['guardian', 'student'])],
            'first_name' => 'required',
            'last_name' => 'required'
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
        // var_dump('here 2');
        // If email is not unique throw 409

        // else throw 422
        throw new CreateApiException($validator->errors()->first(), 422);
    }
}
