<?php

namespace App\Helpers;

class PermissionHelper
{
    public static function checkPermissions($permissionRequired = [])
    {
        $user = request()->user();
        $userPermissions = $user->permissions();

        $isAllowed = false;
        if (!empty($permissionRequired)) {
            foreach ($permissionRequired as $permission) {
                if (in_array($permission, $userPermissions)) {
                    $isAllowed = true;
                }
            }
        } else {
            $isAllowed = true;
        }

        if ($isAllowed === false) {
            abort(403, __('content.message.not_authorize'));
        }
    }
}
