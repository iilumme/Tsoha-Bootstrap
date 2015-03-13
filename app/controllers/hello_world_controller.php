<?php

class HelloWorldController extends BaseController {

    public static function index() {
        // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
        echo 'Tämä on etusivu! :D';
    }

    public static function sandbox() {
        // Testaa koodiasi täällä
        View::make('helloworld.html');
    }

    public static function first_page() {
        View::make('suunnitelmat/etusivu.html');
    }

    public static function add_movie() {
        View::make('movie/leffalisays.html');
    }

    public static function add_people() {
        View::make('movie/leffalisaysihmiset.html');
    }

    public static function register() {
        View::make('users/rekisteroityminen.html');
    }

    public static function login() {
        View::make('users/kirjautuminen.html');
    }

    public static function search() {
        View::make('suunnitelmat/haku.html');
    }

}
