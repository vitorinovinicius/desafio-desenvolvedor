<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class HistoryUploadCriteria.
 *
 * @package namespace App\Criteria;
 */
class HistoryUploadCriteria implements CriteriaInterface
{

    protected $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    /**
     * Apply criteria in query repository
     *
     * @param \Illuminate\Database\Eloquent\Builder $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->select('*');

        if (!empty($this->filters['filename'])) {
            $model = $model->where('file_name', 'like', '%' . $this->filters['filename'] . '%');
        }

        if (!empty($this->filters['date'])) {
            $model = $model->whereDate('created_at', $this->filters['date']);
        }

        return $model;
    }
}
