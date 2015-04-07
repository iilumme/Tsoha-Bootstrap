<?php

class UserController extends BaseController {

    public static function register() {
        $genret = Genre::all();
        View::make('users/rekisteroityminen.html', array('genret' => $genret));
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

    public static function handle_login() {
        $parametrit = $_POST;

        $kayttaja = Kayttaja::authenticate($parametrit['kayttajatunnus'], $parametrit['salasana']);

        if (!$kayttaja) {
            View::make('users/kirjautuminen.html', array('message' => 'Väärä käyttäjätunnus tai salasana'));
        } else {
            $_SESSION['user'] = $kayttaja->kayttajaid;

            Redirect::to('/', array('message' => 'Tervetuloa ' . $kayttaja->nimi . ' ^_^'));
        }
    }

    public static function logout() {
        $_SESSION['user'] = null;
        Redirect::to('/login', array('messagehappy' => 'Tervetuloa pian takaisin :)'));
    }

    public static function store() {
        $parametrit = $_POST;

        $attribuutit = array(
            'nimi' => $parametrit['nimi'],
            'kayttajatunnus' => $parametrit['kayttajatunnus'],
            'salasana' => $parametrit['salasana'],
            'lempigenre' => $parametrit['lempigenre']
        );

        $user = new Kayttaja($attribuutit);

        $user->save();
        
        Redirect::to('/login', array('message' => 'Kirjaudu sisään :)'));
    }

}
