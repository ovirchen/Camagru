<?php


class Session
{
    private $id;
    public static $name;

    public function __construct()
    {
        session_start();
        $this->id = session_id();
    }
//    if (session_status() == PHP_SESSION_NONE) {
//        session_start();
//    }

    public function __destruct()
    {
        session_write_close();
    }


    public static $seesionFlashName = '__FlashBack';
    /**
     * [__construct description]
     */
//    public function __construct() {
//
//    }

    public static function start() {
        ini_set('session.use_only_cookies', 'Off');
        ini_set('session.use_cookies', 'On');
        ini_set('session.use_trans_sid', 'Off');
        ini_set('session.cookie_httponly', 'On');

        if (isset($_COOKIE[session_name()]) && !preg_match('/^[a-zA-Z0-9,\-]{22,52}$/', $_COOKIE[session_name()])) {
            exit('Error: Invalid session ID!');
        }

        session_set_cookie_params(0, '/');
        session_start();
    }

    public static function id() {
        return sha1(session_id());
    }

    public static function regenerate() {
        session_regenerate_id(true);
    }

    /**
     * [exists description]
     * @param  [type] $name [description]
     * @return [type]       [description]
     */
    public static function exists($name) {
        if(isset($name) && $name != '') {
            if(isset($_SESSION[$name])) {
                return true;
            }
        }

        return false;
    }

    /**
     * [set description]
     * @param [type] $name  [description]
     * @param [type] $value [description]
     */
    public static function set($name='', $value='') {
        if($name != '' && $value != '') {
            $_SESSION[$name] = $value;
        }
    }

    /**
     * [get description]
     * @param  [type] $name [description]
     * @return [type]       [description]
     */
    public static function get($name) {
        if(self::exists($name)) {
            return $_SESSION[$name];
        }

        return false;
    }

    /**
     * [delete description]
     * @param  [type] $name [description]
     * @return [type]       [description]
     */
    public static function delete($name) {
        if(self::exists($name)) {
            unset($_SESSION[$name]);
        }

        return false;
    }

    /**
     * [setFlash description]
     * @param string $value [description]
     */
    public static function setFlash($value='') {
        if($value != '') {
            self::set(self::$seesionFlashName, $value);
        }
    }

    /**
     * [getFlash description]
     * @return [type] [description]
     */
    public static function getFlash() {
        if(self::exists(self::$seesionFlashName)) {
            ob_start();
            echo self::get(self::$seesionFlashName);
            $content = ob_get_contents();
            ob_end_clean();

            self::delete(self::$seesionFlashName);

            return $content;
        }

        return false;
    }

    /**
     * [flashExists description]
     * @return [type] [description]
     */
    public static function flashExists() {
        return self::exists(self::$seesionFlashName);
    }

    /**
     * [destroy description]
     * @return void [description]
     */
    public static function destroy() {
        foreach($_SESSION as $sessionName) {
            self::delete($sessionName);
        }

        session_destroy();
    }
}