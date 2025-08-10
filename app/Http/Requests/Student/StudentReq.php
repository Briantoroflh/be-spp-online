<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class StudentReq extends FormRequest
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
            'nisn' => 'required|string',
            'nis' => 'required|string',
            'name' => 'required|string',
            'classes_id' => 'required|string|exists:classes,id_classes',
            'alamat' => 'required|string',
            'no_telp' => 'required|string',
            'users_id' => 'required|string|exists:users,id_users'
        ];
    }
}
