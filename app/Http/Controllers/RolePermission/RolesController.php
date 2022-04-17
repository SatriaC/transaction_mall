<?php

namespace App\Http\Controllers\Admin\RolePermission;

use App\Http\Controllers\Controller;
use App\Services\Admin\RoleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    protected $service;

    public function __construct(
        RoleService $service
    )
    {
        $this->service = $service;
    }

    public function index()
    {
        # code...
        return view('pages.admin.roles.index');
    }

    public function create()
    {
        # code...
        $permissions = Permission::all();
        return view('pages.admin.roles.create', compact('permissions'));
    }

    public function edit($id)
    {
        # code...
        $item = Role::find($id);
        $permissions = Permission::all();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();

        // dd($rolePermissions);
        return view('pages.admin.roles.edit', compact('rolePermissions','permissions', 'item'));
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

    public function update(Request $request, $id)
    {
        # code...
        return $this->service->update($request, $id);
    }

    public function destroy($id)
    {
        # code...
        return $this->service->destroy($id);
    }
}
