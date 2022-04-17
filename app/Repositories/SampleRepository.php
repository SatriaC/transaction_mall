<?php

namespace App\Repositories;

use App\Models\BaseModel;
use App\Repositories\BaseRepository;

class SampleRepository extends BaseRepository
{
    public function __construct(BaseModel $model)
    {
        $this->model = $model;
    }

    public function getByUserId($id)
    {
        $datas = $this->model
            ->where('user_id', $id)
            ->get();

        return $datas;
    }
}
