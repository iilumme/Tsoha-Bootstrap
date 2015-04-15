<?php

class UserController extends BaseController {

    public static function register() {
        $genret = Genre::all();
        View::make('users/rekisteroityminen.html', array('genret' => $genret));
    }

    public static function login() {
        View::make('users/kirjautuminen.html');
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

    public static function mypage() {
        View::make('users/omasivu.html');
    }

    public static function favourites() {
        $suosikit = Elokuva::findSuosikkiElokuvat(self::get_user_logged_in()->kayttajaid);
        $valtiot = Valtio::all();
        $elokuvat = Elokuva::all();
        View::make('users/suosikkilista.html', array(
            'elokuvat' => $suosikit,
            'valtiot' => $valtiot,
            'kaikkielokuvat' => $elokuvat
        ));
    }

    public static function watchedMovies() {
        $suosikit = Elokuva::findKatsotutElokuvat(self::get_user_logged_in()->kayttajaid);
        $valtiot = Valtio::all();
        $elokuvat = Elokuva::all();
        View::make('users/katsotutlista.html', array(
            'elokuvat' => $suosikit,
            'valtiot' => $valtiot,
            'kaikkielokuvat' => $elokuvat
        ));
    }

    public static function later() {
        $suosikit = Elokuva::findMasTardeElokuvat(self::get_user_logged_in()->kayttajaid);
        $valtiot = Valtio::all();
        $elokuvat = Elokuva::all();
        View::make('users/mastardelista.html', array(
            'elokuvat' => $suosikit,
            'valtiot' => $valtiot,
            'kaikkielokuvat' => $elokuvat
        ));
    }

    public static function dvds() {
        $suosikit = Elokuva::findDVDTForKayttaja(self::get_user_logged_in()->kayttajaid);
        $valtiot = Valtio::all();
        $elokuvat = Elokuva::all();
        View::make('users/DVDlista.html', array(
            'elokuvat' => $suosikit,
            'valtiot' => $valtiot,
            'kaikkielokuvat' => $elokuvat
        ));
    }

    public static function mypageedit() {
        $kayttaja = self::get_user_logged_in();
        $genret = Genre::all();
        $tamanhetkinengenre = self::get_user_logged_in()->lempigenre;
        View::make('users/kayttajamuokkaus.html', array(
            'kayttaja' => $kayttaja,
            'genret' => $genret,
            'tamanhetkinengenre' => $tamanhetkinengenre
        ));
    }

    public static function update($id) {
        $parametrit = $_POST;
        $attribuutit = array(
            'kayttajaid' => $id,
            'nimi' => $parametrit['nimi'],
            'kayttajatunnus' => $parametrit['kayttajatunnus'],
            'salasana' => $parametrit['salasana'],
            'lempigenre' => $parametrit['lempigenre']
        );

        $user = new Kayttaja($attribuutit);
        $errors = $user->errors();

        if (count($errors) == 0) {
            $user->update();
            Redirect::to('/mypage', array('message' => 'Tietojen päivittäminen onnistui! :)'));
        } else {
            $genret = Genre::all();
            $tamanhetkinengenre = $attribuutit['lempigenre'];
            View::make('users/kayttajamuokkaus.html', array(
                'errors' => $errors, 'kayttaja' => $attribuutit,
                'genret' => $genret, 'tamanhetkinengenre' => $tamanhetkinengenre
            ));
        }
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
        $errors = $user->errors();

        if (count($errors) == 0) {
            $user->save();
            Redirect::to('/login', array('message' => 'Kirjaudu sisään :)'));
        } else {
            $genret = Genre::all();
            View::make('users/rekisteroityminen.html', array(
                'genret' => $genret, 'errors' => $errors, 'attribuutit' => $attribuutit
            ));
        }
    }

    public static function destroy($id) {
        $user = new Kayttaja(array('kayttajaid' => $id));
        $user->destroy($id);
        Redirect::to('/', array('message' => 'Tilisi poistaminen onnistui'));
    }

}
