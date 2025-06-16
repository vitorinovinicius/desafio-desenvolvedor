<?php 
namespace App\Services\Api;

use Illuminate\Http\Request;
use App\Criteria\SearchFileCriteria;
use App\Repositories\Mongo\RecordRepository;

class RecordService
{
    public function __construct(private RecordRepository $recordRepository)
    {
        $this->recordRepository = $recordRepository;
    }

    /**
     * Search for records based on the request parameters.
     *
     * @param Request $request
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function search($request)
    {
        $filters = filter($request, ['TckrSymb', 'RptDt']);

        $search = $this->recordRepository->pushCriteria(new SearchFileCriteria($filters))->paginate(20);

        return response()->json([
            'status' => 'success',
            'data'   => $search
        ], 200, [], JSON_UNESCAPED_UNICODE);
    }
}