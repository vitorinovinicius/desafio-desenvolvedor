<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HistoryUploadRequest extends FormRequest
{
        public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'filename' => [
                'nullable',
                'string',
                'max:255',
            ],
            'rpt_dt' => [
                'nullable',
                'date_format:Y-m-d',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'rpt_dt.date_format' => 'A data de referência deve estar no formato Y-m-d (ex: 2025-06-13).',
        ];
    }
}

