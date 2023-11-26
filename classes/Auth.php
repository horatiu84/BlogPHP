<?php

/**
 * Authentication
 *
 * Login
 */
class Auth {
    /**
     * Return the user authentication status
     * @return boolean True if a user is logged in, false otherwise
     */
    public static function isLoggedIn(){
        return isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'];
    }

    /**
     * Requires the user to be logged in,otherwise will stop the app with an unauthorised message
     * @return void
     */
    public  static function requireLogin(){
        if (!static::isLoggedIn()) {
        die("unauthorised");}
    }

    /**
     * Log in usind the session
     * @return void
     */
    public static function login(){
        session_regenerate_id(true);

        $_SESSION['is_logged_in'] = true;
    }
    public static function logout(){
        $_SESSION=[];

        if(ini_get("session.use_cookies")){
            $parms = session_get_cookie_params();

            setcookie(
                session_name(),
                '',
                time()-42000,
                $parms["path"],
                $parms["domain"],
                $parms["secure"],
                $parms["httponly"]
            );
        }
        session_destroy();
    }
}