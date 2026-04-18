<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BulkUploadRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'user_type' => 'required|in:students,staff,hods,wardens',
            'csv_file' => 'required|file|mimes:csv,txt|max:10240', // 10MB max
        ];
    }

    public function messages()
    {
        return [
            'user_type.required' => 'Please select a user type to upload.',
            'user_type.in' => 'Invalid user type selected.',
            'csv_file.required' => 'Please select a CSV file to upload.',
            'csv_file.file' => 'The uploaded file is not valid.',
            'csv_file.mimes' => 'The file must be a CSV file.',
            'csv_file.max' => 'The file size must not exceed 10MB.',
        ];
    }
}
