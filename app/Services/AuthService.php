<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\BaseService;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthService extends BaseService
{
    protected $repo;

    public function __construct(
        UserRepository $repo,
    )
    {
        parent::__construct();
        $this->repo = $repo;
    }

    public function login($request)
    {
        $item = User::where('email', $request->email)->orderBy('created_at', 'desc')->first();
        if ($item) {
            # code...
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $user = Auth::user();
                $data['access_token'] = $user->createToken('nApp')->accessToken;
                
                return $this->responseMessage('Login Success', 200, true, $data);
            } else {
                return $this->responseMessage('These credentials do not match our records.', 400, false);
            }
        } else {
            # code...
            return $this->responseMessage('Email is not registered.', 404, false);
        }
    }

    public function register($request)
    {
        # code...
        $db = DB::connection($this->connection);
        $db->beginTransaction();
        try {
            # code...
            $data = $request->all();
            $data['birthdate'] = Carbon::parse($request->birthdate)->format('Y-m-d');
            $data['password'] = Hash::make($request->password);
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
}
