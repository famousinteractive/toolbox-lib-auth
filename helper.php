<?php

if( !function_exists('isAuth')) {
	function isAuth() {
		return (\App\Libraries\Famous\Authentification\Auth::getUserId() !== FALSE);
	}
}
