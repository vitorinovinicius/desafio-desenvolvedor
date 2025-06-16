<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Api\RecordService;
use App\Http\Requests\SearchRequest;

class RecordController extends Controller
{
    /**
     * RecordController constructor.
     *
     * @param RecordService $service
     */
    public function __construct(private RecordService $recordService)
    {
        $this->recordService = $recordService;
    }
    /**
     * Search for records.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(SearchRequest $request)
    {
        return $this->recordService->search($request);
    }
}
