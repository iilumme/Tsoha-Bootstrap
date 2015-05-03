<?php

/* Elokuvien kontrollointi */

class MovieController extends BaseController {


    /* Elokuvan esittelysivulle tiedot */
    public static function showOne($leffaid) {

        $elokuva = Elokuva::findOne($leffaid);
        $valtio = Valtio::findValtioForElokuva($leffaid);
        $nayttelijat = Artisti::findArtistsForMovie($leffaid, "Näyttelijä");
        $ohjaajat = Artisti::findArtistsForMovie($leffaid, "Ohjaaja");
        $kuvaajat = Artisti::findArtistsForMovie($leffaid, "Kuvaaja");
        $kassarit = Artisti::findArtistsForMovie($leffaid, "Käsikirjoittaja");
        $genret = Genre::findGenretForElokuva($leffaid);
        $dvdt = DVDlista::findDVDSForMovie($leffaid);
        $sarjat = Sarjalaari::findSarjatForElokuva($leffaid);

        $sarjatAndElokuvat = array();
        foreach ($sarjat as $s) {
            $sarja = array();
            $sarja['sarjanimi'] = $s->sarjanimi;
            $sarjanelokuvat = Sarjalaari::findSarjanElokuvat($s->sarjaid);
            $sarja[] = $sarjanelokuvat;
            $sarjatAndElokuvat[] = $sarja;
        }

        $arviot = Arviolaari::findStarsForMovie($leffaid);
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

        $onkosuosikki = 0;

        if (BaseController::get_user_logged_in() != NULL) {
            $onkosuosikki = Suosikkilista::isFavourite($leffaid);
        }

        $onkokatsottu = 0;

        if (BaseController::get_user_logged_in() != NULL) {
            $onkokatsottu = Katsotutlista::isWatched($leffaid);
        }

        $onkodvd = 0;

        if (BaseController::get_user_logged_in() != NULL) {
            $onkodvd = DVDlista::hasDVD($leffaid);
        }

        $onkomastarde = 0;

        if (BaseController::get_user_logged_in() != NULL) {
            $onkomastarde = Mastardelista::isMasTarde($leffaid);
        }

        $kaikillalistoilla = 0;

        if ($onkodvd == 1 && $onkokatsottu == 1 && $onkomastarde == 1 && $onkosuosikki == 1) {
            $kaikillalistoilla = 1;
        }

        $averagestar = Arviolaari::averageStar($leffaid);


        View::make('movie/leffaetusivu.html', array(
            'elokuva' => $elokuva, 'valtio' => $valtio, 'nayttelijat' => $nayttelijat,
            'ohjaajat' => $ohjaajat, 'kuvaajat' => $kuvaajat, 'kasikirjoittajat' => $kassarit,
            'genret' => $genret, 'arviot' => $arviot, 'kommentit' => $kommentit,
            'dvdt' => $dvdt, 'sarjatAndElokuvat' => $sarjatAndElokuvat, 'arvioitu' => $arvioitu,
            'kommentoitu' => $kommentoitu, 'kommentti' => $kommentti, 'onkosuosikki' => $onkosuosikki,
            'onkokatsottu' => $onkokatsottu, 'onkodvd' => $onkodvd, 'onkomastarde' => $onkomastarde,
            'kaikillalistoilla' => $kaikillalistoilla, 'keskiarvo' => $averagestar
        ));
    }

    /* Elokuvan lisäyssivulle tiedot */
    public static function addMoviePage() {
        $valtiot = Valtio::all();
        View::make('movie/leffalisays.html', array('valtiot' => $valtiot));
    }

    /* Elokuvan artistien-, genrejen- ja sarjojenlisäyssivulle tiedot */
    public static function addArtistsPage() {

        $nayttelijat = Artisti::findAllArtistsByType("Näyttelijä");
        $ohjaajat = Artisti::findAllArtistsByType("Ohjaaja");
        $kuvaajat = Artisti::findAllArtistsByType("Kuvaaja");
        $kassarit = Artisti::findAllArtistsByType("Käsikirjoittaja");
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
        $nayttelijat = Artisti::findArtistsForMovie($leffaid, "Näyttelijä");
        $ohjaajat = Artisti::findArtistsForMovie($leffaid, "Ohjaaja");
        $kuvaajat = Artisti::findArtistsForMovie($leffaid, "Kuvaaja");
        $kassarit = Artisti::findArtistsForMovie($leffaid, "Käsikirjoittaja");
        $genret = Genre::findGenretForElokuva($leffaid);
        $sarjat = Sarjalaari::findSarjatForElokuva($leffaid);

        $nayttelijatALL = Artisti::findAllArtistsNotInTheMovieByType("Näyttelijä", $leffaid);
        $ohjaajatALL = Artisti::findAllArtistsNotInTheMovieByType("Ohjaaja", $leffaid);
        $kuvaajatALL = Artisti::findAllArtistsNotInTheMovieByType("Kuvaaja", $leffaid);
        $kassaritALL = Artisti::findAllArtistsNotInTheMovieByType("Käsikirjoittaja", $leffaid);
        $genretALL = Genre::findAllGenresNotInTheMovie($leffaid);
        $sarjatALL = Sarja::findAllSeriesNotInTheMovie($leffaid);

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
        Redirect::to('/movie/' . $leffaid, array('starMessage' => 'Arvio lisätty! :) '));
    }

    /* Arvion poistaminen elokuvalta */
    public static function deleteStar($leffaid) {
        Arviolaari::deleteStarFromMovie($leffaid);
        Redirect::to('/movie/' . $leffaid, array('starMessage' => 'Arvio poistettu! :) '));
    }

    /* Kommentin lisääminen elokuvalle */
    public static function addComment($leffaid) {
        $parametri = $_POST;
        $kommentti = $parametri['kommentti'];
        Kommentti::addCommentForMovie($leffaid, $kommentti);
        Redirect::to('/movie/' . $leffaid, array('commentMessage' => 'Kommentti lisätty! :) '));
    }

    /* Kommentin poistaminen elokuvalta */
    public static function deleteComment($leffaid) {
        Kommentti::deleteCommentFromMovie($leffaid);
        Redirect::to('/movie/' . $leffaid, array('commentMessage' => 'Kommentti poistettu! :) '));
    }

    /* REKISTERÖITYNEEN KÄYTTÄJÄN METODIT */


    /* Uuden elokuvaehdotuksen tallentaminen */
    public static function storeSuggestion() {
        $params = $_POST;

        $attributes = array(
            'leffanimi' => $params['leffanimi'],
            'vuosi' => $params['vuosi'],
            'valtio' => $params['valtio'],
            'kieli' => $params['kieli'],
            'synopsis' => $params['synopsis'],
            'traileriurl' => $params['traileriurl']
        );

        $movie = new Elokuva($attributes);
        $errors = $movie->errors();

        if (count($errors) == 0) {
            $ryhmaid = $movie->saveSuggestion();
            Redirect::to('/addmovie/addpeople', array('message' => 'Ehdotus elokuvasta lisätty, lisää tekijät :)', 'ryhmaid' => $ryhmaid, 'lid' => $ryhmaid));
        } else {
            $valtiot = Valtio::all();
            View::make('/movie/leffalisays.html', array('errors' => $errors, 'attribuutit' => $attributes, 'valtiot' => $valtiot));
        }
    }

    /* Elokuvan muokkausehdotuksen tallentaminen */
    public static function updateSuggestion($leffaid) {
        $params = $_POST;
        $attributes = array(
            'leffaid' => $leffaid, 'leffanimi' => $params['leffanimi'], 'vuosi' => $params['vuosi'],
            'valtio' => $params['valtio'], 'kieli' => $params['kieli'],
            'synopsis' => $params['synopsis'], 'traileriurl' => $params['traileriurl']
        );

        $movie = new Elokuva($attributes);
        $errors = $movie->errors();

        if (count($errors) == 0) {
            $ryhmaid = $movie->updateSuggestion();
            LaariController::updateSuggestion($leffaid, $ryhmaid);
        } else {
            $valtiot = Valtio::all();
            $nayttelijat = Artisti::findArtistsForMovie($leffaid, "Näyttelijä");
            $ohjaajat = Artisti::findArtistsForMovie($leffaid, "Ohjaaja");
            $kuvaajat = Artisti::findArtistsForMovie($leffaid, "Kuvaaja");
            $kassarit = Artisti::findArtistsForMovie($leffaid, "Käsikirjoittaja");
            $genret = Genre::findGenretForElokuva($leffaid);
            $sarjat = Sarjalaari::findSarjatForElokuva($leffaid);
            $tamanhetkinenvaltio = $attributes['valtio'];

            $nayttelijatALL = Artisti::findAllArtistsNotInTheMovieByType("Näyttelijä", $leffaid);
            $ohjaajatALL = Artisti::findAllArtistsNotInTheMovieByType("Ohjaaja", $leffaid);
            $kuvaajatALL = Artisti::findAllArtistsNotInTheMovieByType("Kuvaaja", $leffaid);
            $kassaritALL = Artisti::findAllArtistsNotInTheMovieByType("Käsikirjoittaja", $leffaid);
            $genretALL = Genre::findAllGenresNotInTheMovie($leffaid);
            $sarjatALL = Sarja::findAllSeriesNotInTheMovie($leffaid);

            View::make('/movie/leffamuokkaus.html', array(
                'valtiot' => $valtiot, 'tamanhetkinenvaltio' => $tamanhetkinenvaltio,
                'nayttelijat' => $nayttelijat, 'ohjaajat' => $ohjaajat, 'kuvaajat' => $kuvaajat,
                'kasikirjoittajat' => $kassarit, 'genret' => $genret, 'sarjat' => $sarjat,
                'errors' => $errors, 'elokuva' => $attributes,
                'nayttelijatALL' => $nayttelijatALL, 'ohjaajatALL' => $ohjaajatALL, 'kuvaajatALL' => $kuvaajatALL,
                'kasikirjoittajatALL' => $kassaritALL, 'genretALL' => $genretALL, 'sarjatALL' => $sarjatALL
            ));
        }
    }

    /* YLLÄPITÄJÄN METODIT */


    /* Uuden elokuvan tallentaminen - ylläpitäjä tekee */
    public static function administratorStore() {
        $params = $_POST;

        $attributes = array(
            'leffanimi' => $params['leffanimi'],
            'vuosi' => $params['vuosi'],
            'valtio' => $params['valtio'],
            'kieli' => $params['kieli'],
            'synopsis' => $params['synopsis'],
            'traileriurl' => $params['traileriurl']
        );

        $movie = new Elokuva($attributes);
        $errors = $movie->errors();

        if (count($errors) == 0) {
            $movieid = $movie->save();
            Redirect::to('/addmovie/addpeople', array('message' => 'Elokuvan tiedot lisätty onnistuneesti! :)', 'lid' => $movieid));
        } else {
            $valtiot = Valtio::all();
            View::make('/movie/leffalisays.html', array('errors' => $errors, 'attribuutit' => $attributes, 'valtiot' => $valtiot));
        }
    }

    /* Elokuvan muokkaus - ylläpitäjä tekee */
    public static function administratorUpdate($leffaid) {
        $params = $_POST;
        $attributes = array(
            'leffaid' => $leffaid, 'leffanimi' => $params['leffanimi'], 'vuosi' => $params['vuosi'],
            'valtio' => $params['valtio'], 'kieli' => $params['kieli'],
            'synopsis' => $params['synopsis'], 'traileriurl' => $params['traileriurl']
        );

        $movie = new Elokuva($attributes);
        $errors = $movie->errors();

        if (count($errors) == 0) {
            $movie->update();
        } else {
            $valtiot = Valtio::all();
            $nayttelijat = Artisti::findArtistsForMovie($leffaid, "Näyttelijä");
            $ohjaajat = Artisti::findArtistsForMovie($leffaid, "Ohjaaja");
            $kuvaajat = Artisti::findArtistsForMovie($leffaid, "Kuvaaja");
            $kassarit = Artisti::findArtistsForMovie($leffaid, "Käsikirjoittaja");
            $genret = Genre::findGenretForElokuva($leffaid);
            $tamanhetkinenvaltio = $attributes['valtio'];

            View::make('/movie/leffamuokkaus.html', array(
                'valtiot' => $valtiot, 'tamanhetkinenvaltio' => $tamanhetkinenvaltio,
                'nayttelijat' => $nayttelijat, 'ohjaajat' => $ohjaajat, 'kuvaajat' => $kuvaajat,
                'kasikirjoittajat' => $kassarit, 'genret' => $genret, 'errors' => $errors, 'elokuva' => $attributes
            ));
        }
    }

    /* Elokuvan poistaminen - ylläpitäjä tekee */
    public static function destroy($leffaid) {
        $movie = new Elokuva(array('leffaid' => $leffaid));
        $movie->destroy();
        Redirect::to('/', array('deleteMessage' => 'Elokuvan poistaminen onnistui! :)'));
    }

    /* Elokuvan poistaminen ylläpitosivuilla - ylläpitäjä tekee */
    public static function destroyMaintenance($leffaid) {
        $movie = new Elokuva(array('leffaid' => $leffaid));
        $movie->destroy();
        Redirect::to('/moviemaintenance', array('deleteMessage' => 'Elokuvan poistaminen onnistui! :)'));
    }

}
