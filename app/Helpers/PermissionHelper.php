<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class PermissionHelper
{
    public static function checkControllerPermission(array $maps, $request, $next)
    {
        $user = Auth::user();
        $role = Role::find($user->role_id);

        $action = $request->route()->getActionMethod();

        if (isset($maps[$action]) && !$role->hasPermissionTo($maps[$action])) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
