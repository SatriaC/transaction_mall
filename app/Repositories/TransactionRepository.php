<?php

namespace App\Repositories;

use App\Models\Transaction;
use App\Repositories\BaseRepository;

class TransactionRepository extends BaseRepository
{
    public function __construct(Transaction $model)
    {
        $this->model = $model;
    }

}
