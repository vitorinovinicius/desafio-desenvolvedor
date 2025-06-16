<?php

namespace App\Repositories\Mongo;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Mongo\RecordRepository;
use App\Models\Mongo\Record;
use App\Validators\Mongo\RecordValidator;

/**
 * Class RecordRepositoryEloquent.
 *
 * @package namespace App\Repositories\Mongo;
 */
class RecordRepositoryEloquent extends BaseRepository implements RecordRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Record::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
