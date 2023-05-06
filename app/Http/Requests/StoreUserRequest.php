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
            'school_id' => 'required|integer',
            'user_type' => ['required', Rule::in(['guardian', 'student'])],
            'first_name' => ['required'],
            'last_name' => ['required']
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
            'school_id.required' => 'school Id is a required field',
            'school_id.integer' => 'school Id must be an Integer',
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
        // If email is not unique throw 409
        if (isset($validator->failed()['email']['Unique'])) {
            throw new CreateApiException($validator->errors()->first(), 409);
        }

        // If school ID is not an integer, throw a 400
        if (isset($validator->failed()['school_id']['Integer'])) {
            throw new CreateApiException($validator->errors()->first(), 400);
        }

        // else throw 422
        throw new CreateApiException($validator->errors()->first(), 422);
    }
}
