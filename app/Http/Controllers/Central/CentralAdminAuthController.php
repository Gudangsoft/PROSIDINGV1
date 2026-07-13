<?php

namespace App\Http\Controllers\Central;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Login/logout for the shared central-admin password (see
 * App\Http\Middleware\EnsureCentralAdmin). Registered from both
 * routes/central.php (central domains) and routes/tenant.php (so the
 * "Kelola Tenant" link in a tenant's own admin sidebar works too) —
 * kept in one place so the two don't drift.
 */
class CentralAdminAuthController extends Controller
{
    public function showLogin()
    {
        return view('central.admin.login');
    }

    public function login(Request $request)
    {
        $request->validate(['password' => 'required|string']);

        $expected = config('central.admin_password');

        if (!$expected || !hash_equals($expected, $request->input('password'))) {
            return back()->withErrors(['password' => 'Password salah.']);
        }

        $request->session()->regenerate();
        $request->session()->put('central_admin_authenticated', true);

        return redirect($request->input('redirect', '/admin/tenants'));
    }

    public function logout(Request $request)
    {
        $request->session()->forget('central_admin_authenticated');
        $request->session()->regenerate();

        return redirect('/admin/login');
    }
}
