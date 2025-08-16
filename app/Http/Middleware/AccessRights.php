<?php

namespace App\Http\Middleware;

use App\Models\AdminModel;
use App\Models\AccessRightsModel;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccessRights
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        $user_id = auth()->user()->id;

        $checkAdmin = AdminModel::where('user_id', $user_id)->first();

        if (Auth::user() && $checkAdmin != NULL) {

            if ($checkAdmin['deleted'] == 0) {

                $checkAccessRights = AccessRightsModel::where('admin_id', $checkAdmin['id'])->first();
                if ($request->is('admin/voucher/*') && $checkAccessRights['voucher'] == 1) {
                    return $next($request);
                } else if ($request->is('admin/setting/*') && $checkAccessRights['settings'] == 1) {
                    return $next($request);
                } else if ($request->is('admin/staff/*') && $checkAccessRights['admin_staff'] == 1) {
                    return $next($request);
                } else if ($request->is('admin/gift/*') && $checkAccessRights['gift'] == 1) {
                    return $next($request);
                }

                // Redirects when access is denied

                // voucher access denied
                else if ($request->is('admin/voucher/*')) {
                    if ($checkAccessRights['gift'] == 1) {
                        return redirect("/admin/gift/list");
                    } else if ($checkAccessRights['admin_staff'] == 1) {
                        return redirect("/admin/staff/list");
                    } else if ($checkAccessRights['settings'] == 1) {
                        return redirect("/admin/setting/metatag");
                    }
                }

                // gifts access denied
                else if ($request->is('admin/gift/*')) {
                    if ($checkAccessRights['voucher'] == 1) {
                        return redirect("/admin/voucher/list");
                    } else if ($checkAccessRights['settings'] == 1) {
                        return redirect("/admin/setting/metatag");
                    } else if ($checkAccessRights['admin_staff'] == 1) {
                        return redirect("/admin/staff/list");
                    }
                }

                // Settings access denied
                else if ($request->is('admin/setting/*')) {
                    if ($checkAccessRights['voucher'] == 1) {
                        return redirect("/admin/voucher/list");
                    } else if ($checkAccessRights['gift'] == 1) {
                        return redirect("/admin/gift/list");
                    } else if ($checkAccessRights['admin_staff'] == 1) {
                        return redirect("/admin/staff/list");
                    }
                }

                // Staff access denied
                else if ($request->is('admin/staff/*')) {
                    if ($checkAccessRights['voucher'] == 1) {
                        return redirect("/admin/voucher/list");
                    } else if ($checkAccessRights['gift'] == 1) {
                        return redirect("/admin/gift/list");
                    } else if ($checkAccessRights['settings'] == 1) {
                        return redirect("/admin/settings/metatag");
                    }
                }

                // If no access to anything
                return abort(403, 'Unauthorized access.');

            }
        }

        return abort(404);
    }
}
