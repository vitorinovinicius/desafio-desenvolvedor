<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UploadResource extends JsonResource
{
    public function toArray($request)
    {
        // Retorna uma resposta simples, pode adicionar mais dados aqui
        return [
            'message' => $this->resource['message'] ?? 'Upload realizado com sucesso.',
            'file_name' => $this->resource['file_name'] ?? null,
            'uuid' => $this->resource['uuid'] ?? null,
            'status' => $this->resource['status'] ?? 'processing',
        ];
    }
}
