<?php

namespace App\Http\Controllers\Admin\RolePermission;

use App\Http\Controllers\Controller;
use App\Services\Admin\PermissionService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionsController extends Controller
{

    protected $service;

    public function __construct(
        PermissionService $service
    )
    {
        $this->service = $service;
    }

    public function index()
    {
        # code...
        return view('pages.admin.permission.index');
    }

    public function data(Request $request)
    {
        # code...
        return $this->service->data($request);
    }

    public function store(Request $request)
    {
        # code...
        return $this->service->store($request);
    }

    public function update(Request $request)
    {
        # code...
        return $this->service->update($request);
    }

    public function destroy($id)
    {
        # code...
        return $this->service->destroy($id);
    }
}
