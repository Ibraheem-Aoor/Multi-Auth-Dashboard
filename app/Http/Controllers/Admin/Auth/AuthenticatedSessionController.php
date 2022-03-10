<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Auth\AdminLoginRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(AdminLoginRequest $request)
    {
        if($this->authenticate($request))
            return redirect()->intended(route('admin.dashboard'));

        return redirect(route('admin.login.form'))->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);;
    }


    public function authenticate($request)
    {
        $credentials = [
            'email' => $request->email ,
            'password' => $request->password
        ];
        $rememberMe = $request->has('remember') ? true : false;
        if(Auth::guard('admin')->attempt($credentials , $rememberMe))
        {
            $request->session()->regenerate();
            return true;
        }
        else
        {
            return false;
        }
    }


    /**
     * Destroy an authenticated admin session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect(route('admin.login.form'));
    }
}
