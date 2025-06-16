<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Ajuste conforme sua lógica de autorização
    }

    public function rules()
    {
        return [
            'file' => 'required|file|mimes:csv,txt,xls,xlsx|mimetypes:text/csv,application/csv,text/plain,application/vnd.ms-excel',
        ];
    }

    public function messages()
    {
        return [
            'file.required' => 'O arquivo é obrigatório.',
            'file.file' => 'O arquivo deve ser um arquivo válido.',
            'file.mimes' => 'O arquivo deve ser do tipo csv, txt, xls ou xlsx.',
            'file.mimetypes' => 'O arquivo deve ter um tipo MIME válido.',
        ];
    }
}
