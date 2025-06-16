<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class SearchFileCriteria.
 *
 * @package namespace App\Criteria;
 */
class SearchFileCriteria implements CriteriaInterface
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

        if (!empty($this->filters['TckrSymb'])) {
            $model->where('TckrSymb', $this->filters['TckrSymb']);
        }

        if (!empty($this->filters['RptDt'])) {
            $model->where('RptDt', $this->filters['RptDt']);
        }

        return $model;
    }
}
