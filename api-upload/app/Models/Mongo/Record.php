<?php

namespace App\Models\Mongo;

use MongoDB\Laravel\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Record extends Model implements Transformable
{
    use TransformableTrait;

    protected $connection = 'mongodb';
    protected $collection = 'records';

    protected $fillable = [
        'RptDt',
        'TckrSymb',
        'MktNm',
        'SctyCtgyNm',
        'ISIN',
        'CrpnNm'
    ];
}

