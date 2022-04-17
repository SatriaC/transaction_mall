<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\BaseRepository;

class UserRepository extends BaseRepository
{
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function updateCredit($id, $data)
    {
        # code...
        $item = $this->model->find($id);
        $item->update([
            'credits'=>$data->credits - 5,
        ]);

        return true;
    }
}
