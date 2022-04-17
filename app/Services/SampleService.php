<?php

namespace App\Services;

use App\Repositories\SampleRepository;
use App\Services\BaseService;
use Carbon\Carbon;

class SampleService extends BaseService
{
    protected $repo;

    public function __construct(
        SampleRepository $repo
    ) {
        parent::__construct();
        $this->repo = $repo;
    }

    public function all($request)
    {
        return $this->repo->getByUserId($request->id);
    }

    public function detail($id)
    {
        $data['time'] = Carbon::parse($time . '00', '');
        $this->repo->update($data, $id);


        return $this->repo->getById($id);
    }
}
