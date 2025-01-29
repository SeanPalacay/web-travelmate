<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDestinationRequest extends FormRequest
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
        $rules = [
            'company_name' => 'required|string|max:255',
            'company_address' => 'required|string|max:255',
            'about' => 'nullable|string',
            'destination_name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'operating_days' => 'required|array',
            'operating_hours_start' => 'required|array',
            'operating_hours_end' => 'required|array',
            'destination_address' => 'required|string|max:255',
            'locality' => 'required|string|max:255',
            'nearest_landmark1' => 'nullable|string|max:255',
            'nearest_landmark2' => 'nullable|string|max:255',
            'nearest_landmark3' => 'nullable|string|max:255',
            'amenities' => 'required|string|max:1000',
            'status' => 'required|in:pending,approved,rejected',
            'user_id' => 'required',
        ];

        // If this is a create request, make file fields required
        if ($this->isMethod('POST')) {
            $rules['company_permit'] = 'required|file|mimes:jpg,png,jpeg|max:5120';
            $rules['location_clearance'] = 'required|file|mimes:jpg,png,jpeg|max:5120';
            $rules['barangay_clearance'] = 'required|file|mimes:jpg,png,jpeg|max:5120';
            $rules['philhealth'] = 'required|file|mimes:jpg,png,jpeg|max:5120';
            $rules['corporate_bank_account'] = 'required|file|mimes:jpg,png,jpeg|max:5120';
            $rules['sec_registration'] = 'required|file|mimes:jpg,png,jpeg|max:5120';
            $rules['tin'] = 'required|file|mimes:jpg,png,jpeg|max:5120';
            $rules['sss'] = 'required|file|mimes:jpg,png,jpeg|max:5120';
        }

        return $rules;
    }
}