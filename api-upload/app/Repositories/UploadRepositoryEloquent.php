<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\UploadRepository;
use App\Models\Upload;
use App\Validators\UploadValidator;

/**
 * Class UploadRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class UploadRepositoryEloquent extends BaseRepository implements UploadRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Upload::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
