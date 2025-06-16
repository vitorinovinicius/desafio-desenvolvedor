<?php

namespace App\Services\Api;

use App\Jobs\ImportFileJob;
use Illuminate\Support\Facades\Storage;
use App\Repositories\UploadRepository;
use App\Http\Resources\UploadResource;
use App\Http\Resources\HistoryUploadResource;
use App\Criteria\HistoryUploadCriteria;

class UploadService
{
    public function __construct(private UploadRepository $uploadRepository)
    {
        $this->uploadRepository = $uploadRepository;
    }

    public function store($request)
    {
        $file = $request->file('file');
        $hash = md5_file($file->getRealPath());

        if ($this->uploadRepository->where('uuid', $hash)->exists()) {
            return response()->json(['error' => 'Arquivo já enviado.'], 422);
        }

        $filename = $file->getClientOriginalName();
        $path = 'uploads/' . $filename;

        cleanAndStoreFile($file, $path);

        $upload = $this->uploadRepository->create([
            'file_name' => $filename,
            'uuid' => $hash,
            'file_path' => $path,
            'status' => 'Processing'
        ]);

        ImportFileJob::dispatch($upload, $path);

        return new UploadResource([
            'message' => 'Arquivo enviado com sucesso.',
            'file_name' => $filename,
            'uuid' => $hash,
            'status' => 'processing',
        ]);
    }

    public function history($request)
    {
        $filters = filter($request, ['filename', 'date']);

        $this->uploadRepository->pushCriteria(new HistoryUploadCriteria($filters));

        $uploads = $this->uploadRepository->orderBy('created_at', 'desc')->paginate(10);

        return HistoryUploadResource::collection($uploads);
    }
    

}