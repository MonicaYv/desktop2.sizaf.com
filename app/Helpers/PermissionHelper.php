<?php

namespace App\Helpers;

use App\Models\User;
use App\Models\Roles;
use App\Models\Permissions;


class PermissionHelper
{
    public static function getFilteredPermissions($userId)
    {
        $getUsr = User::where('id', $userId)->first();

        // Initialize an empty filteredPermissions array
        $filteredPermissions = [
            'fileManager' => [],
            'userManagement' => [],
            'roleManagement' => [],
            'groupsManagement' => [],
            'backendManagement' => [],
            // 'desktopDownload' => [],
        ];

        if ($getUsr) {
            $roleID = $getUsr->roleID;

            $roles = Roles::where('id', $roleID)->first();

            if ($roles) {
                $permissionID = $roles->permissionID;

                $permissions = Permissions::where('id', $permissionID)->first();

                if ($permissions) {
                    $permissionArray = explode(',', $permissions->permissions);

                    $categories = [
                        'fileManager' => ['view', 'preview', 'download', 'upload', 'edit', 'delete', 'share', 'comments', 'dynamic', 'admin'],
                        'userManagement' => ['user-create', 'user-edit', 'user-view', 'user-delete', 'user-mass-upload', 'user-rollback', 'user-permanent-delete'],
                        'roleManagement' => ['role-create', 'role-edit', 'role-view', 'role-delete', 'role-mass-upload', 'role-rollback', 'role-permanent-delete'],
                        'groupsManagement' => ['group-create', 'group-edit', 'group-view', 'group-delete', 'group-mass-upload', 'group-rollback', 'group-permanent-delete'],
                        'backendManagement' => ['notice', 'storage', 'backups', 'logs'],
                        // 'desktopDownload' => ['desk-download'],
                    ];

                    foreach ($categories as $category => $categoryPermissions) {
                        $filteredPermissions[$category] = array_intersect($permissionArray, $categoryPermissions);
                    }
                }
            }
        }

        return $filteredPermissions;
    }
}
