<?php

namespace App\Repositories;

use App\Models\Item;
use App\Repositories\BaseRepository;

class ItemRepository extends BaseRepository
{
    public function __construct(Item $model)
    {
        $this->model = $model;
    }

}
