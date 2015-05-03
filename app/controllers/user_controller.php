<?php

/* Käyttäjiin liittyvät metodit */

class UserController extends BaseController {
    
    /* Rekisteröitymissivulle tiedot */
    public static function register() {
        $genres = Genre::all();
        View::make('users/rekisteroityminen.html', array('genret' => $genres));
    }

    /* Kirjautumissivu */
    public static function login() {
        View::make('users/kirjautuminen.html');
    }

    /* Kirjautumisen tarkistus */
    public static function handleLogin() {
        $params = $_POST;
        $user = Kayttaja::authenticate($params['kayttajatunnus'], $params['salasana']);

        if (!$user) {
            View::make('users/kirjautuminen.html', array('message' => 'Väärä käyttäjätunnus tai salasana'));
        } else {
            $_SESSION['user'] = $user->kayttajaid;
            Redirect::to('/', array('message' => 'Tervetuloa ' . $user->nimi . ' ^_^'));
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
    
    /* Käyttäjän sivu */
    public static function userPage($kayttajaid) {
        $user = Kayttaja::findOne($kayttajaid);
        $favorites = Elokuva::findSuosikkiElokuvat($kayttajaid);
        $dvds = Elokuva::findDVDTForKayttaja($kayttajaid);
        $stars = Arviolaari::findUsersStarredMovies($kayttajaid);
        View::make('users/registered_user/kayttajasivu.html', array(
            'kayttaja' => $user, 'suosikit' => $favorites,
            'dvdt' => $dvds, 'arviot' => $stars, 'lahettaja' => self::get_user_logged_in()->kayttajaid));
    }
    
    /* Käyttäjän tietojen muokkaussivu */
    public static function profileEdit() {
        $user = self::get_user_logged_in();
        $genres = Genre::all();
        $genreATM = self::get_user_logged_in()->lempigenre;
        View::make('users/registered_user/kayttajamuokkaus.html', array(
            'kayttaja' => $user,
            'genret' => $genres,
            'tamanhetkinengenre' => $genreATM
        ));
    }
    
    
    /* LISTAT */
    

    /* Suosikkilistasivu */
    public static function favourites() {
        $favorites = Elokuva::findSuosikkiElokuvat(self::get_user_logged_in()->kayttajaid);
        $countries = Valtio::all();
        $movies = Elokuva::allNotFavourites(self::get_user_logged_in()->kayttajaid);
        View::make('users/lists/suosikkilista.html', array(
            'elokuvat' => $favorites,
            'valtiot' => $countries,
            'kaikkielokuvat' => $movies
        ));
    }

    /* Katsotutlistasivu */
    public static function watchedMovies() {
        $watched = Elokuva::findKatsotutElokuvat(self::get_user_logged_in()->kayttajaid);
        $countries = Valtio::all();
        $movies = Elokuva::allNotWatched(self::get_user_logged_in()->kayttajaid);
        View::make('users/lists/katsotutlista.html', array(
            'elokuvat' => $watched,
            'valtiot' => $countries,
            'kaikkielokuvat' => $movies
        ));
    }

    /* Myöhemminkatsottaviensivu */
    public static function later() {
        $mastardes = Elokuva::findMasTardeElokuvat(self::get_user_logged_in()->kayttajaid);
        $countries = Valtio::all();
        $movies = Elokuva::allNotToBeWatched(self::get_user_logged_in()->kayttajaid);
        View::make('users/lists/mastardelista.html', array(
            'elokuvat' => $mastardes,
            'valtiot' => $countries,
            'kaikkielokuvat' => $movies
        ));
    }

    /* DVDlistasivu */
    public static function dvds() {
        $dvds = Elokuva::findDVDTForKayttaja(self::get_user_logged_in()->kayttajaid);
        $countries = Valtio::all();
        $movies = Elokuva::allNotDVD(self::get_user_logged_in()->kayttajaid);
        View::make('users/lists/DVDlista.html', array(
            'elokuvat' => $dvds,
            'valtiot' => $countries,
            'kaikkielokuvat' => $movies
        ));
    }

   
    
    /* Käyttäjän muokkaaminen */
    public static function update($kayttajaid) {
        $params = $_POST;
        $attributes = array(
            'kayttajaid' => $kayttajaid,
            'nimi' => $params['nimi'],
            'kayttajatunnus' => $params['kayttajatunnus'],
            'salasana' => $params['salasana'],
            'lempigenre' => $params['lempigenre'],
            'kuva' => $params['kuva']
        );

        $user = new Kayttaja($attributes);
        $errors = $user->errors();
        if (count($errors) == 0) {
            $user->update();
            Redirect::to('/mypage', array('message' => 'Tietojen päivittäminen onnistui! :)'));
        } else {
            $genres = Genre::all();
            $genreATM = $attributes['lempigenre'];
            View::make('users/registered_user/kayttajamuokkaus.html', array(
                'errors' => $errors, 'kayttaja' => $attributes,
                'genret' => $genres, 'tamanhetkinengenre' => $genreATM
            ));
        }
    }

    /* Uuden käyttäjän tallentaminen */
    public static function store() {
        $params = $_POST;
        $attributes = array(
            'nimi' => $params['nimi'],
            'kayttajatunnus' => $params['kayttajatunnus'],
            'salasana' => $params['salasana'],
            'lempigenre' => $params['lempigenre'],
            'kuva' => $params['kuva']
        );

        $user = new Kayttaja($attributes);
        $errors = $user->errors();

        if (count($errors) == 0) {
            $user->save();
            Redirect::to('/login', array('message' => 'Kirjaudu sisään :)'));
        } else {
            $genres = Genre::all();
            View::make('users/rekisteroityminen.html', array(
                'genret' => $genres, 'errors' => $errors, 'attribuutit' => $attributes
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
        Redirect::to('/usermaintenance', array('deleteMessage' => 'Tilin poistaminen onnistui'));
    }

    /* Listoille lisääminen ja poistaminen listoilta */
    
    public static function addFavourites() {
        $params = $_POST;
        $input = $params['lisayslista'];
        $output = explode(',', $input);
        $kayttajaid = self::get_user_logged_in()->kayttajaid;

        foreach ($output as $leffaid) {
            Suosikkilista::save($kayttajaid, $leffaid);
        }

        Redirect::to('/favourites');
    }
    
    public static function removeFavourites() {
        $params = $_POST;
        $input = $params['poistolista'];
        $output = explode(',', $input);
        $kayttajaid = self::get_user_logged_in()->kayttajaid;

        foreach ($output as $leffaid) {
            Suosikkilista::destroy($kayttajaid, $leffaid);
        }

        Redirect::to('/favourites');
    }
    
    public static function addDVDs() {
        $params = $_POST;
        $input = $params['lisayslista'];
        $output = explode(',', $input);
        $kayttajaid = self::get_user_logged_in()->kayttajaid;

        foreach ($output as $leffaid) {
            DVDlista::save($kayttajaid, $leffaid);
        }

        Redirect::to('/dvds');
    }

    public static function removeDVDs() {
        $params = $_POST;
        $input = $params['poistolista'];
        $output = explode(',', $input);
        $kayttajaid = self::get_user_logged_in()->kayttajaid;

        foreach ($output as $leffaid) {
            DVDlista::destroy($kayttajaid, $leffaid);
        }

        Redirect::to('/dvds');
    }

    public static function addWatched() {
        $params = $_POST;
        $input = $params['lisayslista'];
        $output = explode(',', $input);
        $kayttajaid = self::get_user_logged_in()->kayttajaid;

        foreach ($output as $leffaid) {
            Katsotutlista::save($kayttajaid, $leffaid);
        }

        Redirect::to('/watched');
    }

    public static function removeWatched() {
        $params = $_POST;
        $input = $params['poistolista'];
        $output = explode(',', $input);
        $kayttajaid = self::get_user_logged_in()->kayttajaid;

        foreach ($output as $leffaid) {
            Katsotutlista::destroy($kayttajaid, $leffaid);
        }

        Redirect::to('/watched');
    }

    public static function addMasTarde() {
        $params = $_POST;
        $input = $params['lisayslista'];
        $output = explode(',', $input);
        $kayttajaid = self::get_user_logged_in()->kayttajaid;

        foreach ($output as $leffaid) {
            Mastardelista::save($kayttajaid, $leffaid);
        }

        Redirect::to('/mastarde');
    }

    public static function removeMasTarde() {
        $params = $_POST;
        $input = $params['poistolista'];
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
     public static function addDVDMovie($leffaid) {

        $kayttajaid = self::get_user_logged_in()->kayttajaid;
        DVDlista::save($kayttajaid, $leffaid);
        Redirect::to('/movie/' . $leffaid);
    }

    
    
    /* YLLÄPITÄJÄN METODIT */


    /* Ylläpitäjän omasivu */
    public static function administratorPage() {
        View::make('users/administrator/yllapitajasivu.html');
    }

    /* Ylläpitäjän tietojen muokkaussivu */
    public static function administratorEdit() {
        $user = self::get_user_logged_in();
        $genres = Genre::all();
        $genreATM = self::get_user_logged_in()->lempigenre;
        View::make('users/registered_user/kayttajamuokkaus.html', array(
            'kayttaja' => $user,
            'genret' => $genres,
            'tamanhetkinengenre' => $genreATM
        ));
    }

    
    /* Elokuvien ylläpitosivu */
    public static function movieMaintenance() {
        $movies = Elokuva::all();
        View::make('users/administrator/leffojenyllapito.html', array('elokuvat' => $movies));
    }

    /* Artistien ylläpitosivu */
    public static function artistMaintenance() {
        $artists = Artisti::all();
        View::make('users/administrator/artistienyllapito.html', array('artistit' => $artists));
    }

    /* Käyttäjien ylläpitosivu */
    public static function userMaintenance() {
        $users = Kayttaja::all();
        View::make('users/administrator/kayttajienyllapito.html', array('kayttajat' => $users));
    }
    
    /* Sarjojen ylläpitosivu */
    public static function serieMaintenance() {
        $series = Sarja::all();
        View::make('users/administrator/sarjojenyllapito.html', array('sarjat' => $series));
    }
    
    /* Genrejen ylläpitosivu */
    public static function genreMaintenance() {
        $genres = Genre::all();
        View::make('users/administrator/genrejenyllapito.html', array('genret' => $genres));
    }
    
    /* Kommenttien ylläpitosivu */
    public static function commentMaintenance() {
        $comments = Kommentti::all();
        View::make('users/administrator/kommenttienyllapito.html', array('kommentit' => $comments));
    }
    
    /* Kommentin poistaminen ylläpitosivuilla */
    public static function destroyCommentMaintenance($kayttajaid, $leffaid) {
        $comment = new Kommentti(array('kayttajaid' => $kayttajaid,'leffaid' => $leffaid));
        $comment->destroy();
        Redirect::to('/commentmaintenance', array('deleteMessage' => 'Kommentin poistaminen onnistui'));
    }

}
