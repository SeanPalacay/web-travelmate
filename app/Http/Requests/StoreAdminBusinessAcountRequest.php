<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdminBusinessAcountRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'firstname' => 'required|string|min:2|max:20',
            'lastname' => 'required|string|min:2|max:20',
            'birthdate' => ['required', 'date', 'before:' . now()->subYears(11)->toDateString()],
            'email' => 'required|email|unique:users,email,' . $this->route('id'),
            'password' => 'required|min:8|max:255', // Updated to allow longer passwords
            'mobile_no' => ['required', 'regex:/^\+639\d{9}$/', 'unique:users'],
            'business_name' => 'nullable|string|min:2|max:20',
            'type' => 'required',
            'locality' => 'nullable|string', // Set locality to a nullable string
        ];

        if ($this->isMethod('post')) {
            $rules['password'] = 'required|min:8|max:255|confirmed'; // Updated for POST requests
        } elseif ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['password'] = 'nullable|min:8|max:255|confirmed'; // Updated for PUT/PATCH requests
        }

        return $rules;
    }
}