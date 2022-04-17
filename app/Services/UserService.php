<?php

namespace App\Services;

use App\Models\Pemrek\ReportAgent;
use App\Models\User\User;
use App\Repositories\UserRepository;
use App\Services\BaseService;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserService extends BaseService
{
    protected $repo;

    public function __construct(
        UserRepository $repo
    ) {
        parent::__construct();
        $this->repo = $repo;
    }

    public function update($request)
    {
        $user = Auth::user();
        # code...
        $db = DB::connection($this->connection);
        $db->beginTransaction();
        try {
            # code...
            $data = $request->all();

            $updated = $this->repo->update($data, $user->id);

            $db->commit();

            return $this->responseMessage(__('content.message.update.success'), 200, true, $updated);
        } catch (Exception $exc) {
            # code...
            Log::error($exc);
            $db->rollback();
            return $this->responseMessage(__('content.message.update.failed'), 400, false);
        }
    }

    public function show()
    {
        try {
            # code...
            $user = Auth::user();
            $collection = collect($user->toArray());
            if (Auth::user()->upline_id) {
                # code...
                $collection->put('upline_name', User::find(Auth::user()->upline_id)->name);
            } else {
                $collection->put('upline_name', null);
            }
            $data = $collection->all();

            return $this->responseMessage(__('content.message.read.success'), 200, true, $data);
        } catch (Exception $exc) {
            # code...
            Log::error($exc);
            return $this->responseMessage(__('content.message.read.failed'), 400, false);
        }
    }

    public function statistic($request)
    {
        try {
            # code...
            $user = Auth::user()->id;
            $dataMonthly = ReportAgent::where('user_id', $user)->whereMonth('created_at', date('m'));
            $dataWeekly = ReportAgent::where('user_id', $user)->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
            if (!empty($request->status)) {
                # code...
                $dataWeekly = $dataWeekly->where('status', $request->status);
                $dataMonthly = $dataMonthly->where('status', $request->status);
            }
            $dataWeekly = $dataWeekly->count();
            $dataMonthly = $dataMonthly->count();
            $data['weekly'] = $dataWeekly;
            $data['monthly'] = $dataMonthly;

            return $this->responseMessage(__('content.message.read.success'), 200, true, $data);
        } catch (Exception $exc) {
            # code...
            Log::error($exc);
            return $this->responseMessage(__('content.message.read.failed'), 400, false);
        }
    }

    public function image($request, $id)
    {
        # code...
        $file_data = $request->input('image');
        $replace = substr($file_data, 0, strpos($file_data, ',') + 1);
        $image = str_replace($replace, '', $file_data);
        $image = str_replace(' ', '+', $image);
        $extension = explode('/', mime_content_type($file_data))[1];
        $file_name = $id . '_profil_' . time() . '.' . $extension; //generating unique file name;

        if ($file_data != "") { // storing image in storage/app/public Folder
            Storage::disk('public')->put('profil_photos/' . $file_name, base64_decode($image));
        }
        return $file_name;
    }

    public function downline()
    {
        $user = Auth::user();
        try {
            $data = $this->repo->getDownlineByUserId($user->id);
            return $this->responseMessage(__('content.message.read.success'), 200, true, $data);
        } catch (Exception $exc) {
            Log::error($exc);
            return $this->responseMessage(__('content.message.read.failed'), 400, false);
        }
    }

    public function imageStore($request)
    {

        $user = Auth::user();

        $db = DB::connection($this->connection);
        $db->beginTransaction();

        try {
            if (!empty($request->image)) {
                $image = $this->image($request, $user->id);
                $data['image'] = $image;
            } else {
                $db->rollback();
                return $this->responseMessage(__('content.message.image.empty'), 400, false);
            }

            $updated = $this->repo->update($data, $user->id);

            $db->commit();

            return $this->responseMessage(__('content.message.update.success'), 200, true, $updated);
        } catch (Exception $exc) {
            # code...
            Log::error($exc);
            $db->rollback();
            return $this->responseMessage(__('content.message.update.failed'), 400, false);
        }
    }
}
