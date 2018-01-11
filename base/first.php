<?php

require_once 'classes/config.php';
require_once 'classes/cookie.php';
require_once 'classes/session.php';
require_once 'classes/user.php';
require_once 'classes/token.php';
require_once 'classes/validate.php';
require_once 'classes/db.php';
require_once 'classes/input.php';
require_once 'classes/hash.php';
require_once 'classes/redirect.php';
session_start();

$GLOBALS['config'] = array(
    'mysql' => array(
        'host' => '127.0.0.1',
        'username' => 'root',
        'password' => '',
        'db' => 'db'
    ),
    'remember' => array(
        'cookie_name' => 'hash',
        'cookie_expiry' => 3600
    ),
    'sessions' => array(
        'session_name' => 'user',
        'token_name' => 'token'
    )
);

if(Cookie::exists(Config::get('remember/cookie_name')) && !Session::exists(Config::get('sessions/session_name'))) {
    $hash = Cookie::get(Config::get('remember/cookie_name'));
    $hashCheck = DB::getInstance()->get('users_session', array('hash', '=', $hash));

    if($hashCheck->count()) {
        $user = new User($hashCheck->first()->user_id);
        $user->login();
    }
}
