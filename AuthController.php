<?php

namespace App\Http\Controllers;

use App\Libraries\Famous\Authentification\Auth;

use App\Mail\RenewPassword;
use App\Models\User;
use Illuminate\Http\Request;
use View;
use Session;

class AuthController extends Controller
{

    public function login(Request $request) {

        if(Auth::authWithRememberToken()) {
            return redirect($request->get('redirect', '/'));
        }

        $data = [
            'redirect'  => $request->get('redirect', '/'),
        ];

        return View::make('Auth.login', $data);
    }

    public function loginStore(Request $request) {

        $redirect = $request->get('redirect','/');

        $this->validate($request, [
            'email'     => 'required',
            'password'  => 'required'
        ], [
            'email.required'    => fitrans('error.validation.email_required'),
            'password.required' => fitrans('error.validation.password_required')
        ]);

        if(Auth::auth($request->get('email'), $request->get('password'))) {

            if($request->get('stay_logged', 0) == 1) {
                Auth::generateRememberToken();
            }
            return redirect($redirect);

        } else {
            return View::make('Auth.login', ['redirect' => $redirect, 'autherror' => fitrans('auth.loginfailed'), 'data' => $request->all() ]);
        }
    }

    public function logout(Request $request) {
        Session::flush();
        return redirect('/')->withCookie(\Cookie::forget(env('auth_remember_token_cookie_name')));
    }

    public function recoverPassword(Request $request) {
        return View::make('Auth.recover');
    }

    public function recoverPasswordStore(Request $request) {

        $user = User::where('email', $request->get('email'))->first();

        if(!empty($user)) {
            //Use the invite_unique_id to update the password

            if(!empty($user->password)) { //If user don't exists yet, why he ask ?
                $uniqueHash = uniqid(true) . md5($user->email);
                $user->renew_password_hash = $uniqueHash;
                $user->save();

                \Mail::to($user->email)->send(new RenewPassword($user, $uniqueHash));
            }
        }

        return View::make('Auth.recover', ['success'    => fitrans('auth.password_sent')]);
    }

    public function renewPassword(Request $request, $recoverHash) {

        $data = [];

        if($request->get('error', 0) != 0) {
            $error = fitrans('auth.error.password_renew_not_the_same');
        } else {

            $user = User::where('renew_password_hash', $recoverHash)->first();

            $error = null;
            if (empty($user->password)) {
                $error = fitrans('auth.error.password_renew_not_on_standby_account');
            }
        }

        $data = array_merge($data, [
            'error' => $error,
            'recoverHash'  => $recoverHash
        ]);

        return View::make('Auth.renew' , $data);
    }

    public function renewPasswordStore(Request $request) {

        $user = User::where('renew_password_hash', $request->get('recoverHash'))->first();

        if(empty($user->password)) {
            return redirect()->route('auth.renewPassword', $request->get('recoverHash'));
        }

        if($request->get('password') == $request->get('password_confirmation')) {
            $user->password = \Hash::make($request->get('password'));
            $user->save();
        } else {
            return redirect()->route('auth.renewPassword', [$request->get('recoverHash'), 'error' => 1]);
        }

        return redirect()->route('auth.login');
    }
}
