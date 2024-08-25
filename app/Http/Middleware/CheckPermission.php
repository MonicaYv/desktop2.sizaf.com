<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Helpers\PermissionHelper;


class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */  

    public function handle(Request $request, Closure $next)
    {        
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login'); 
        }
        
        $filteredPermissions = PermissionHelper::getFilteredPermissions(auth()->id());

        $routeName = $request->route()->getName();
        $routeUri = $request->path();

        $accessDenied = [];

        if (strpos($routeName, 'filemanager') !== false && empty($filteredPermissions['fileManager'])) {
            $accessDenied[] = 'fileManager';
        }
        
        if (strpos($routeName, 'logs') !== false && empty($filteredPermissions['backendManagement'])) {
            $accessDenied[] = 'backendManagement';
        }
        if (strpos($routeName, 'operation_logs') !== false && empty($filteredPermissions['backendManagement'])) {
            $accessDenied[] = 'backendManagement';
        }
        
        if (strpos($routeName, 'useradmin') !== false && empty($filteredPermissions['userManagement'])) {
            $accessDenied[] = 'userManagement';
        }
        
        if (strpos($routeName, 'rolesadmin') !== false && empty($filteredPermissions['roleManagement'])) {
            $accessDenied[] = 'roleManagement';
        }
        if (strpos($routeName, 'permissionsadmin') !== false && empty($filteredPermissions['roleManagement'])) {
            $accessDenied[] = 'userManagement';
        }
        
        // if (strpos($routeName, 'useradmin') !== false && empty($filteredPermissions['groupsManagement'])) {
        //     $accessDenied[] = 'groupsManagement';
        // }
        
        if (!empty($accessDenied)) {
            abort(403, "You have not permission to access this page.");
            // return response()->json(['error' => 'You do not have permission to access this page.'], 403);
        }
        return $next($request);
    }   
}
