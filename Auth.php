<?php

namespace App\Libraries\Famous\Authentification;

use App\Model\User;
use Carbon\Carbon;
use Session;
use Hash;

class Auth
{

    protected static $_user = null;

    public static function auth($email, $password) {

        self::$_user = User::where('email', $email)->first();

        if(!empty(self::$_user) && Hash::check($password, self::$_user->password)) {

            Session::put('auth_user_id', self::$_user->id);
            self::$_user->touch(); //Update_at update for last activity record

            return true;
        } else {
            return false;
        }
    }

    public static function authWithRememberToken() {

        $token = \Request::cookie(env('auth_remember_token_cookie_name'));

        if(is_array($token) || is_null($token) || strlen($token) < 12) {
            return false;
        }

        $tokenSplit = explode('-', $token);

        if(!isset($tokenSplit[0]) || !isset($tokenSplit[1])) {
            return false;
        }

        self::$_user = User::where('id', $tokenSplit[0])
            ->whereDate('updated_at', '>=', Carbon::now()->addDays(-5))
            ->first();

        if(!empty(self::$_user) && Hash::check($token, self::$_user->remember_token)) {
            Session::put('auth_user_id', self::$_user->id);
            self::generateRememberToken(); //Generate a new token
            return true;
        } else {
            return false;
        }
    }

    public static function generateRememberToken() {

        $user = self::getUser();

        if($user == FALSE) {
            Throw new \Exception('You can\'t remember an unlogged user in ' . __FILE__ .' on line ' . __LINE__);
        }

        $clearToken = $user->id.'-'. hash('sha256', uniqid(true));
        $hashedToken = \Hash::make($clearToken);
        $user->remember_token = $hashedToken;
        $user->save();

        $cookie = \Cookie::forever(env('auth_remember_token_cookie_name'), $clearToken);
        \Cookie::queue($cookie);

        return true;
    }

    public static function getUserId() {
        $userId = Session::get('auth_user_id');

        if(empty($userId)) {
            return false;
        } else {
            return $userId;
        }
    }

    public static function getUser() {
        $userId = Session::get('auth_user_id');

        $user = User::find($userId);

        if(empty($user)) {
            return false;
        } else {
            return $user;
        }
    }

}