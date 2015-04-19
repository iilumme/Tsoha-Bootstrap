<?php

class BaseController {

    public static function get_user_logged_in() {
        if (isset($_SESSION['user'])) {
            $user_id = $_SESSION['user'];
            $user = Kayttaja::findOne($user_id);

            return $user;
        }
        return null;
    }

    public static function isAdministrator() {
        if (isset($_SESSION['user'])) {
            $user_id = $_SESSION['user'];
            if ($user_id == 2) {
                return TRUE;
            }
            return FALSE;
        }
        return FALSE;
    }

    public static function check_logged_in() {
        if (!isset($_SESSION['user'])) {
            Redirect::to('/login', array('message' => 'Kirjaudu sisään :)'));
        }
    }

}
