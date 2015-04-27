<?php

/* Elokuvien kontrollointi */

class MovieController extends BaseController {
    
    /* Elokuvan esittelysivulle tiedot */
    public static function showOne($leffaid) {

        $elokuva = Elokuva::findOne($leffaid);
        $valtio = Valtio::findValtioForElokuva($leffaid);
        $nayttelijat = Artisti::findArtistitForElokuva($leffaid, "Näyttelijä");
        $ohjaajat = Artisti::findArtistitForElokuva($leffaid, "Ohjaaja");
        $kuvaajat = Artisti::findArtistitForElokuva($leffaid, "Kuvaaja");
        $kassarit = Artisti::findArtistitForElokuva($leffaid, "Käsikirjoittaja");
        $genret = Genre::findGenretForElokuva($leffaid);
        $dvdt = DVDlista::findDVDTForElokuva($leffaid);
        $sarjat = Sarjalaari::findSarjatForElokuva($leffaid);

        $sarjatAndElokuvat = array();
        foreach ($sarjat as $s) {
            $sarja = array();
            $sarja['sarjanimi'] = $s->sarjanimi;
            $sarjanelokuvat = Sarjalaari::findSarjanElokuvat($s->sarjaid);
            $sarja[] = $sarjanelokuvat;
            $sarjatAndElokuvat[] = $sarja;
        }

        $arviot = Arviolaari::findArviotForElokuva($leffaid);
        $arvioitu = 0;
        if (BaseController::get_user_logged_in() != NULL) {
            if (Arviolaari::hasAddedStars($leffaid) > 0) {
                $arvioitu = Arviolaari::hasAddedStars($leffaid);
            }
        }

        $kommentit = Kommentti::findKommentitForElokuva($leffaid);
        $kommentoitu = 0;
        $kommentti = NULL;

        if (BaseController::get_user_logged_in() != NULL) {
            if (is_string(Kommentti::hasCommented($leffaid))) {
                $kommentoitu = 1;
                $kommentti = Kommentti::hasCommented($leffaid);
            }
        }

        View::make('movie/leffaetusivu.html', array(
            'elokuva' => $elokuva, 'valtio' => $valtio,
            'nayttelijat' => $nayttelijat, 'ohjaajat' => $ohjaajat,
            'kuvaajat' => $kuvaajat, 'kasikirjoittajat' => $kassarit,
            'genret' => $genret, 'arviot' => $arviot, 'kommentit' => $kommentit,
            'dvdt' => $dvdt, 'sarjatAndElokuvat' => $sarjatAndElokuvat,
            'arvioitu' => $arvioitu, 'kommentoitu' => $kommentoitu, 'kommentti' => $kommentti
        ));
    }

    /* Elokuvan lisäyssivulle tiedot */
    public static function addMoviePage() {
        $valtiot = Valtio::all();
        View::make('movie/leffalisays.html', array('valtiot' => $valtiot));
    }

    /* Elokuvan artistien-, genrejen- ja sarjojenlisäyssivulle tiedot */
    public static function addArtistsPage() {

        $nayttelijat = Artisti::findAllArtistitByTyyppi("Näyttelijä");
        $ohjaajat = Artisti::findAllArtistitByTyyppi("Ohjaaja");
        $kuvaajat = Artisti::findAllArtistitByTyyppi("Kuvaaja");
        $kassarit = Artisti::findAllArtistitByTyyppi("Käsikirjoittaja");
        $genret = Genre::all();
        $sarjat = Sarja::all();
        $valtiot = Valtio::all();
        View::make('movie/leffalisaysihmiset.html', array(
            'nayttelijat' => $nayttelijat, 'ohjaajat' => $ohjaajat,
            'kuvaajat' => $kuvaajat, 'kasikirjoittajat' => $kassarit,
            'genret' => $genret, 'sarjat' => $sarjat,
            'valtiot' => $valtiot
        ));
    }

    /* Elokuvan muokkaussivulle tiedot */
    public static function movieEditPage($leffaid) {
        $elokuva = Elokuva::findOne($leffaid);
        $valtiot = Valtio::all();
        $tamanhetkinenvaltio = Valtio::findValtioForElokuva($leffaid)->valtioid;
        $nayttelijat = Artisti::findArtistitForElokuva($leffaid, "Näyttelijä");
        $ohjaajat = Artisti::findArtistitForElokuva($leffaid, "Ohjaaja");
        $kuvaajat = Artisti::findArtistitForElokuva($leffaid, "Kuvaaja");
        $kassarit = Artisti::findArtistitForElokuva($leffaid, "Käsikirjoittaja");
        $genret = Genre::findGenretForElokuva($leffaid);
        $sarjat = Sarjalaari::findSarjatForElokuva($leffaid);

        $nayttelijatALL = Artisti::findAllArtistitByTyyppi("Näyttelijä");
        $ohjaajatALL = Artisti::findAllArtistitByTyyppi("Ohjaaja");
        $kuvaajatALL = Artisti::findAllArtistitByTyyppi("Kuvaaja");
        $kassaritALL = Artisti::findAllArtistitByTyyppi("Käsikirjoittaja");
        $genretALL = Genre::all();
        $sarjatALL = Sarja::all();

        View::make('movie/leffamuokkaus.html', array(
            'elokuva' => $elokuva, 'valtiot' => $valtiot, 'nayttelijat' => $nayttelijat,
            'ohjaajat' => $ohjaajat, 'kuvaajat' => $kuvaajat, 'kasikirjoittajat' => $kassarit,
            'genret' => $genret, 'sarjat' => $sarjat, 'tamanhetkinenvaltio' => $tamanhetkinenvaltio,
            'nayttelijatALL' => $nayttelijatALL, 'ohjaajatALL' => $ohjaajatALL, 'kuvaajatALL' => $kuvaajatALL,
            'kasikirjoittajatALL' => $kassaritALL, 'genretALL' => $genretALL, 'sarjatALL' => $sarjatALL
        ));
    }

    /* Arvion lisääminen elokuvalle */
    public static function addStar($leffaid) {
        $parametri = $_POST;
        $tahti = $parametri['tahti'];
        Arviolaari::addStarForMovie($leffaid, $tahti);
        Redirect::to('/movie/' . $leffaid);
    }

    /* Arvion poistaminen elokuvalta */
    public static function deleteStar($leffaid) {
        Arviolaari::deleteStarFromMovie($leffaid);
        Redirect::to('/movie/' . $leffaid);
    }

    /* Kommentin lisääminen elokuvalle */
    public static function addComment($leffaid) {
        $parametri = $_POST;
        $kommentti = $parametri['kommentti'];
        Kommentti::addCommentForMovie($leffaid, $kommentti);
        Redirect::to('/movie/' . $leffaid);
    }

    /* Kommentin poistaminen elokuvalta */
    public static function deleteComment($leffaid) {
        Kommentti::deleteCommentFromMovie($leffaid);
        Redirect::to('/movie/' . $leffaid);
    }

    
    /* REKISTERÖITYNEEN KÄYTTÄJÄN METODIT */


    /* Uuden elokuvaehdotuksen tallentaminen */
    public static function storeSuggestion() {
        $parametrit = $_POST;

        $attribuutit = array(
            'leffanimi' => $parametrit['leffanimi'],
            'vuosi' => $parametrit['vuosi'],
            'valtio' => $parametrit['valtio'],
            'kieli' => $parametrit['kieli'],
            'synopsis' => $parametrit['synopsis'],
            'traileriurl' => $parametrit['traileriurl']
        );

        $movie = new Elokuva($attribuutit);
        $errors = $movie->errors();

        if (count($errors) == 0) {
            $ryhmaid = $movie->saveSuggestion();
            Redirect::to('/addmovie/addpeople', array('message' => 'Ehdotus elokuvasta lisätty, lisää tekijät :)', 'ryhmaid' => $ryhmaid, 'lid' => $ryhmaid));
        } else {
            $valtiot = Valtio::all();
            View::make('/movie/leffalisays.html', array('errors' => $errors, 'attribuutit' => $attribuutit, 'valtiot' => $valtiot));
        }
    }

    /* Elokuvan muokkausehdotuksen tallentaminen */
    public static function updateSuggestion($leffaid) {
        $parametrit = $_POST;
        $attribuutit = array(
            'leffaid' => $leffaid, 'leffanimi' => $parametrit['leffanimi'], 'vuosi' => $parametrit['vuosi'],
            'valtio' => $parametrit['valtio'], 'kieli' => $parametrit['kieli'],
            'synopsis' => $parametrit['synopsis'], 'traileriurl' => $parametrit['traileriurl']
        );

        $movie = new Elokuva($attribuutit);
        $errors = $movie->errors();

        if (count($errors) == 0) {
            $ryhmaid = $movie->updateSuggestion();
            LaariController::updateSuggestion($leffaid, $ryhmaid);
        } else {
            $valtiot = Valtio::all();
            $nayttelijat = Artisti::findArtistitForElokuva($leffaid, "Näyttelijä");
            $ohjaajat = Artisti::findArtistitForElokuva($leffaid, "Ohjaaja");
            $kuvaajat = Artisti::findArtistitForElokuva($leffaid, "Kuvaaja");
            $kassarit = Artisti::findArtistitForElokuva($leffaid, "Käsikirjoittaja");
            $genret = Genre::findGenretForElokuva($leffaid);
            $tamanhetkinenvaltio = $attribuutit['valtio'];

            View::make('/movie/leffamuokkaus.html', array(
                'valtiot' => $valtiot, 'tamanhetkinenvaltio' => $tamanhetkinenvaltio,
                'nayttelijat' => $nayttelijat, 'ohjaajat' => $ohjaajat, 'kuvaajat' => $kuvaajat,
                'kasikirjoittajat' => $kassarit, 'genret' => $genret, 'errors' => $errors, 'elokuva' => $attribuutit
            ));
        }
    }

    /* YLLÄPITÄJÄN METODIT */


    /* Uuden elokuvan tallentaminen - ylläpitäjä tekee */
    public static function administratorStore() {
        $parametrit = $_POST;

        $attribuutit = array(
            'leffanimi' => $parametrit['leffanimi'],
            'vuosi' => $parametrit['vuosi'],
            'valtio' => $parametrit['valtio'],
            'kieli' => $parametrit['kieli'],
            'synopsis' => $parametrit['synopsis'],
            'traileriurl' => $parametrit['traileriurl']
        );

        $movie = new Elokuva($attribuutit);
        $errors = $movie->errors();

        if (count($errors) == 0) {
            $movieid = $movie->save();
            Redirect::to('/addmovie/addpeople', array('message' => 'Elokuvan tiedot lisätty onnistuneesti', 'lid' => $movieid));
        } else {
            $valtiot = Valtio::all();
            View::make('/movie/leffalisays.html', array('errors' => $errors, 'attribuutit' => $attribuutit, 'valtiot' => $valtiot));
        }
    }

    /* Elokuvan muokkaus - ylläpitäjä tekee */
    public static function administratorUpdate($leffaid) {
        $parametrit = $_POST;
        $attribuutit = array(
            'leffaid' => $leffaid, 'leffanimi' => $parametrit['leffanimi'], 'vuosi' => $parametrit['vuosi'],
            'valtio' => $parametrit['valtio'], 'kieli' => $parametrit['kieli'],
            'synopsis' => $parametrit['synopsis'], 'traileriurl' => $parametrit['traileriurl']
        );

        $movie = new Elokuva($attribuutit);
        $errors = $movie->errors();

        if (count($errors) == 0) {
            $movie->update();
        } else {
            $valtiot = Valtio::all();
            $nayttelijat = Artisti::findArtistitForElokuva($leffaid, "Näyttelijä");
            $ohjaajat = Artisti::findArtistitForElokuva($leffaid, "Ohjaaja");
            $kuvaajat = Artisti::findArtistitForElokuva($leffaid, "Kuvaaja");
            $kassarit = Artisti::findArtistitForElokuva($leffaid, "Käsikirjoittaja");
            $genret = Genre::findGenretForElokuva($leffaid);
            $tamanhetkinenvaltio = $attribuutit['valtio'];

            View::make('/movie/leffamuokkaus.html', array(
                'valtiot' => $valtiot, 'tamanhetkinenvaltio' => $tamanhetkinenvaltio,
                'nayttelijat' => $nayttelijat, 'ohjaajat' => $ohjaajat, 'kuvaajat' => $kuvaajat,
                'kasikirjoittajat' => $kassarit, 'genret' => $genret, 'errors' => $errors, 'elokuva' => $attribuutit
            ));
        }
    }

    /* Elokuvan poistaminen - ylläpitäjä tekee */
    public static function destroy($leffaid) {
        $movie = new Elokuva(array('leffaid' => $leffaid));
        $movie->destroy();
        Redirect::to('/', array('message' => 'Elokuvan poistaminen onnistui'));
    }

    /* Elokuvan poistaminen ylläpitosivuilla - ylläpitäjä tekee */
    public static function destroyMaintenance($leffaid) {
        $movie = new Elokuva(array('leffaid' => $leffaid));
        $movie->destroy();
        Redirect::to('/moviemaintenance', array('message' => 'Elokuvan poistaminen onnistui'));
    }

}
