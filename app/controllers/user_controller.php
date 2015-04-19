<?php

/* Käyttäjiin liittyvät metodit */

class UserController extends BaseController {
    
    /* Rekisteröitymissivulle tiedot */
    public static function register() {
        $genret = Genre::all();
        View::make('users/rekisteroityminen.html', array('genret' => $genret));
    }

    /* Kirjautumissivu */
    public static function login() {
        View::make('users/kirjautuminen.html');
    }

    /* Kirjautumisen tarkistus */
    public static function handleLogin() {
        $parametrit = $_POST;
        $kayttaja = Kayttaja::authenticate($parametrit['kayttajatunnus'], $parametrit['salasana']);

        if (!$kayttaja) {
            View::make('users/kirjautuminen.html', array('message' => 'Väärä käyttäjätunnus tai salasana'));
        } else {
            $_SESSION['user'] = $kayttaja->kayttajaid;
            Redirect::to('/', array('message' => 'Tervetuloa ' . $kayttaja->nimi . ' ^_^'));
        }
    }

    /* Uloskirjautuminen */
    public static function logout() {
        $_SESSION['user'] = null;
        Redirect::to('/login', array('messagehappy' => 'Tervetuloa pian takaisin :)'));
    }

    /* Käyttäjän omasivu */
    public static function myPage() {
        View::make('users/registered_user/omasivu.html');
    }
    
    /* Käyttäjän tietojen muokkaussivu */
    public static function profileEdit() {
        $kayttaja = self::get_user_logged_in();
        $genret = Genre::all();
        $tamanhetkinengenre = self::get_user_logged_in()->lempigenre;
        View::make('users/registered_user/kayttajamuokkaus.html', array(
            'kayttaja' => $kayttaja,
            'genret' => $genret,
            'tamanhetkinengenre' => $tamanhetkinengenre
        ));
    }
    
    
    /* LISTAT */
    

    /* Suosikkilistasivu */
    public static function favourites() {
        $suosikit = Elokuva::findSuosikkiElokuvat(self::get_user_logged_in()->kayttajaid);
        $valtiot = Valtio::all();
        $elokuvat = Elokuva::allNotFavourites(self::get_user_logged_in()->kayttajaid);
        View::make('users/lists/suosikkilista.html', array(
            'elokuvat' => $suosikit,
            'valtiot' => $valtiot,
            'kaikkielokuvat' => $elokuvat
        ));
    }

    /* Katsotutlistasivu */
    public static function watchedMovies() {
        $suosikit = Elokuva::findKatsotutElokuvat(self::get_user_logged_in()->kayttajaid);
        $valtiot = Valtio::all();
        $elokuvat = Elokuva::allNotWatched(self::get_user_logged_in()->kayttajaid);
        View::make('users/lists/katsotutlista.html', array(
            'elokuvat' => $suosikit,
            'valtiot' => $valtiot,
            'kaikkielokuvat' => $elokuvat
        ));
    }

    /* Myöhemminkatsottaviensivu */
    public static function later() {
        $suosikit = Elokuva::findMasTardeElokuvat(self::get_user_logged_in()->kayttajaid);
        $valtiot = Valtio::all();
        $elokuvat = Elokuva::allNotToBeWatched(self::get_user_logged_in()->kayttajaid);
        View::make('users/lists/mastardelista.html', array(
            'elokuvat' => $suosikit,
            'valtiot' => $valtiot,
            'kaikkielokuvat' => $elokuvat
        ));
    }

    /* DVDlistasivu */
    public static function dvds() {
        $suosikit = Elokuva::findDVDTForKayttaja(self::get_user_logged_in()->kayttajaid);
        $valtiot = Valtio::all();
        $elokuvat = Elokuva::allNotDVD(self::get_user_logged_in()->kayttajaid);
        View::make('users/lists/DVDlista.html', array(
            'elokuvat' => $suosikit,
            'valtiot' => $valtiot,
            'kaikkielokuvat' => $elokuvat
        ));
    }

   
    
    /* Käyttäjän muokkaaminen */
    public static function update($kayttajaid) {
        $parametrit = $_POST;
        $attribuutit = array(
            'kayttajaid' => $kayttajaid,
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
            View::make('users/registered_user/kayttajamuokkaus.html', array(
                'errors' => $errors, 'kayttaja' => $attribuutit,
                'genret' => $genret, 'tamanhetkinengenre' => $tamanhetkinengenre
            ));
        }
    }

    /* Uuden käyttäjän tallentaminen */
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

    /* Käyttäjän poistaminen */
    public static function destroy($kayttajaid) {
        $user = new Kayttaja(array('kayttajaid' => $kayttajaid));
        $user->destroy();
        Redirect::to('/', array('message' => 'Tilisi poistaminen onnistui'));
    }

    /* Käyttäjän poistaminen ylläpitosivulla */
    public static function destroyMaintenance($kayttajaid) {
        $user = new Kayttaja(array('kayttajaid' => $kayttajaid));
        $user->destroy();
        Redirect::to('/usermaintenance', array('message' => 'Tilisi poistaminen onnistui'));
    }

    /* Listoille lisääminen ja poistaminen listoilta */
    
    public static function addFavourites() {
        $parametrit = $_POST;
        $input = $parametrit['lisayslista'];
        $output = explode(',', $input);
        $kayttajaid = self::get_user_logged_in()->kayttajaid;

        foreach ($output as $leffaid) {
            Suosikkilista::save($kayttajaid, $leffaid);
        }

        Redirect::to('/favourites');
    }
    
    public static function removeFavourites() {
        $parametrit = $_POST;
        $input = $parametrit['poistolista'];
        $output = explode(',', $input);
        $kayttajaid = self::get_user_logged_in()->kayttajaid;

        foreach ($output as $leffaid) {
            Suosikkilista::destroy($kayttajaid, $leffaid);
        }

        Redirect::to('/favourites');
    }
    
    public static function addDVDs() {
        $parametrit = $_POST;
        $input = $parametrit['lisayslista'];
        $output = explode(',', $input);
        $kayttajaid = self::get_user_logged_in()->kayttajaid;

        foreach ($output as $leffaid) {
            DVDlista::save($kayttajaid, $leffaid);
        }

        Redirect::to('/dvds');
    }

    public static function removeDVDs() {
        $parametrit = $_POST;
        $input = $parametrit['poistolista'];
        $output = explode(',', $input);
        $kayttajaid = self::get_user_logged_in()->kayttajaid;

        foreach ($output as $leffaid) {
            DVDlista::destroy($kayttajaid, $leffaid);
        }

        Redirect::to('/dvds');
    }

    public static function addWatched() {
        $parametrit = $_POST;
        $input = $parametrit['lisayslista'];
        $output = explode(',', $input);
        $kayttajaid = self::get_user_logged_in()->kayttajaid;

        foreach ($output as $leffaid) {
            Katsotutlista::save($kayttajaid, $leffaid);
        }

        Redirect::to('/watched');
    }

    public static function removeWatched() {
        $parametrit = $_POST;
        $input = $parametrit['poistolista'];
        $output = explode(',', $input);
        $kayttajaid = self::get_user_logged_in()->kayttajaid;

        foreach ($output as $leffaid) {
            Katsotutlista::destroy($kayttajaid, $leffaid);
        }

        Redirect::to('/watched');
    }

    public static function addMasTarde() {
        $parametrit = $_POST;
        $input = $parametrit['lisayslista'];
        $output = explode(',', $input);
        $kayttajaid = self::get_user_logged_in()->kayttajaid;

        foreach ($output as $leffaid) {
            Mastardelista::save($kayttajaid, $leffaid);
        }

        Redirect::to('/mastarde');
    }

    public static function removeMasTarde() {
        $parametrit = $_POST;
        $input = $parametrit['poistolista'];
        $output = explode(',', $input);
        $kayttajaid = self::get_user_logged_in()->kayttajaid;

        foreach ($output as $leffaid) {
            Mastardelista::destroy($kayttajaid, $leffaid);
        }

        Redirect::to('/mastarde');
    }
    
    
    /* Listoille lisääminen elokuvan esittelysivuilta */

    public static function addFavourite($leffaid) {

        $kayttajaid = self::get_user_logged_in()->kayttajaid;
        Suosikkilista::save($kayttajaid, $leffaid);
        Redirect::to('/movie/' . $leffaid);
    }

    public static function addWatchedMovie($leffaid) {

        $kayttajaid = self::get_user_logged_in()->kayttajaid;
        Katsotutlista::save($kayttajaid, $leffaid);
        Redirect::to('/movie/' . $leffaid);
    }

    public static function addMastardeMovie($leffaid) {

        $kayttajaid = self::get_user_logged_in()->kayttajaid;
        Mastardelista::save($kayttajaid, $leffaid);
        Redirect::to('/movie/' . $leffaid);
    }

    
    
    /* YLLÄPITÄJÄN METODIT */


    /* Ylläpitäjän omasivu */
    public static function administratorPage() {
        View::make('users/administrator/yllapitajasivu.html');
    }

    /* Ylläpitäjän tietojen muokkaussivu */
    public static function administratorEdit() {
        $kayttaja = self::get_user_logged_in();
        $genret = Genre::all();
        $tamanhetkinengenre = self::get_user_logged_in()->lempigenre;
        View::make('users/registered_user/kayttajamuokkaus.html', array(
            'kayttaja' => $kayttaja,
            'genret' => $genret,
            'tamanhetkinengenre' => $tamanhetkinengenre
        ));
    }

    
    /* Elokuvien ylläpitosivu */
    public static function movieMaintenance() {
        $elokuvat = Elokuva::all();
        View::make('users/administrator/leffojenyllapito.html', array('elokuvat' => $elokuvat));
    }

    /* Artistien ylläpitosivu */
    public static function artistMaintenance() {
        $artistit = Artisti::all();
        View::make('users/administrator/artistienyllapito.html', array('artistit' => $artistit));
    }

    /* Käyttäjien ylläpitosivu */
    public static function userMaintenance() {
        $kayttajat = Kayttaja::all();
        View::make('users/administrator/kayttajienyllapito.html', array('kayttajat' => $kayttajat));
    }

}
