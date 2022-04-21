<?php

namespace App\Repositories;

use App\Models\Voucher;
use App\Repositories\BaseRepository;

class VoucherRepository extends BaseRepository
{
    public function __construct(Voucher $model)
    {
        $this->model = $model;
    }

}
