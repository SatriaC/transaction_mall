<?php

namespace App\Services;

use App\Helpers\Pagination;
use App\Repositories\BoardingHouseRepository;
use App\Repositories\UserRepository;
use App\Services\BaseService;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class BoardingHouseService extends BaseService
{
    protected $repo;
    protected $repoUser;

    public function __construct(
        BoardingHouseRepository $repo,
        UserRepository $repoUser,
    ) {
        parent::__construct();
        $this->repo = $repo;
        $this->repoUser = $repoUser;
    }

    public function index($request)
    {
        $data =  $this->repo->index($request);

        return Pagination::paginate($data, $request);
    }

    public function store($request)
    {
        $db = DB::connection($this->connection);
        $db->beginTransaction();
        try {
            # code...
            $data = $request->all();
            $data['user_id'] = Auth::guard('api')->user()->id;
            $item = $this->repo->create($data);
            $db->commit();

            return $this->responseMessage(__('content.message.create.success'), 200, true, $item);
        } catch (Exception $exc) {
            # code...
            Log::error($exc);
            $db->rollback();
            return $this->responseMessage(__('content.message.create.failed'), 400, false);
        }
    }

    public function update($request, $id)
    {
        # code...
        $db = DB::connection($this->connection);
        $db->beginTransaction();
        try {
            # code...
            $data = $request->all();
            $this->repo->update($data, $id);
            $db->commit();

            $item = $this->repo->getById($id);

            return $this->responseMessage(__('content.message.update.success'), 200, true, $item);
        } catch (Exception $exc) {
            # code...
            Log::error($exc);
            $db->rollback();
            return $this->responseMessage(__('content.message.update.failed'), 400, false);
        }
    }

    public function show($id)
    {
        try {
            # code...
            $data = $this->repo->getById($id);

            return $this->responseMessage(__('content.message.read.success'), 200, true, $data);
        } catch (Exception $exc) {
            # code...
            Log::error($exc);
            return $this->responseMessage(__('content.message.read.failed'), 400, false);
        }
    }

    public function availability($id)
    {
        $db = DB::connection($this->connection);
        $db->beginTransaction();
        try {
            # code...
            $credit = $this->repoUser->getById($id);
            if ($credit->credits < 5) {
                # code...
                return $this->responseMessage('You must top up your credits', 400, false);
            } else {
                # code...
                $data = $this->repo->availability($id);
                $this->repoUser->updateCredit($id, $credit);
                $db->commit();
                $item = $this->repoUser->getById($id);

                return $this->responseMessage(__('content.message.read.success'), 200, true, [$data, 'credits' => $item['credits']]);
            }
        } catch (Exception $exc) {
            # code...
            Log::error($exc);
            $db->rollback();
            return $this->responseMessage(__('content.message.read.failed'), 400, false);
        }
    }

    public function destroy($id)
    {
        # code...
        try {
            # code...
            $this->repo->delete($id);
            return $this->responseMessage(__('content.message.delete.success'), 200, true);
        } catch (\Throwable $exc) {
            # code...
            Log::error($exc);
            return $this->responseMessage(__('content.message.delete.failed'), 400, false);
        }
    }

}
