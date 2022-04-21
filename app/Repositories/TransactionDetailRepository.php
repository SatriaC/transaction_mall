<?php

namespace App\Repositories;

use App\Models\TransactionDetail;
use App\Repositories\BaseRepository;

class TransactionDetailRepository extends BaseRepository
{
    public function __construct(TransactionDetail $model)
    {
        $this->model = $model;
    }
}
