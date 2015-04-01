<?php

class UserController extends BaseController {

    public static function register() {
        View::make('users/rekisteroityminen.html');
    }

    public static function login() {
        View::make('users/kirjautuminen.html');
    }

    public static function lists() {
        View::make('users/lista.html');
    }

    public static function mypage() {
        View::make('users/omasivu.html');
    }

}
