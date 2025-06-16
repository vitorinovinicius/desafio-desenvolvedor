<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\HistoryUploadRequest;
use App\Http\Controllers\Controller;
use App\Services\Api\UploadService;
use App\Http\Requests\UploadRequest;
use Illuminate\Http\Request;
use App\Models\Upload;

class UploadController extends Controller
{

    public function __construct(private UploadService $uploadService)
    {
        $this->uploadService = $uploadService;
    }
    /**
     * Handle the file upload.
     *
     * @param UploadRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UploadRequest $request)
    {
        return $this->uploadService->store($request);
    }

    /**
     * Retrieve upload history.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function history(HistoryUploadRequest $request)
    {
        return $this->uploadService->history($request);
    }
}
