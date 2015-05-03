<?php

/* Elokuvien kontrollointi */

class MovieController extends BaseController {


    /* Elokuvan esittelysivulle tiedot */
    public static function showOne($leffaid) {

        $movie = Elokuva::findOne($leffaid);
        $country = Valtio::findValtioForElokuva($leffaid);
        $actors = Artisti::findArtistsForMovie($leffaid, "Näyttelijä");
        $directors = Artisti::findArtistsForMovie($leffaid, "Ohjaaja");
        $cinematographers = Artisti::findArtistsForMovie($leffaid, "Kuvaaja");
        $screenwriters = Artisti::findArtistsForMovie($leffaid, "Käsikirjoittaja");
        $genres = Genre::findGenretForElokuva($leffaid);
        $dvds = DVDlista::findDVDSForMovie($leffaid);
        $series = Sarjalaari::findSarjatForElokuva($leffaid);

        $seriesAndMovies = array();
        foreach ($series as $s) {
            $serie = array();
            $serie['sarjanimi'] = $s->sarjanimi;
            $moviesOfSerie = Sarjalaari::findSarjanElokuvat($s->sarjaid);
            $serie[] = $moviesOfSerie;
            $seriesAndMovies[] = $serie;
        }

        $stars = Arviolaari::findStarsForMovie($leffaid);
        $starred = 0;
        if (BaseController::get_user_logged_in() != NULL) {
            if (Arviolaari::hasAddedStars($leffaid) > 0) {
                $starred = Arviolaari::hasAddedStars($leffaid);
            }
        }

        $comments = Kommentti::findKommentitForElokuva($leffaid);
        $commented = 0;
        $comment = NULL;

        if (BaseController::get_user_logged_in() != NULL) {
            if (is_string(Kommentti::hasCommented($leffaid))) {
                $commented = 1;
                $comment = Kommentti::hasCommented($leffaid);
            }
        }

        $isfavourite = 0;

        if (BaseController::get_user_logged_in() != NULL) {
            $isfavourite = Suosikkilista::isFavourite($leffaid);
        }

        $iswatched = 0;

        if (BaseController::get_user_logged_in() != NULL) {
            $iswatched = Katsotutlista::isWatched($leffaid);
        }

        $isdvd = 0;

        if (BaseController::get_user_logged_in() != NULL) {
            $isdvd = DVDlista::hasDVD($leffaid);
        }

        $ismastarde = 0;

        if (BaseController::get_user_logged_in() != NULL) {
            $ismastarde = Mastardelista::isMasTarde($leffaid);
        }

        $inAllLists = 0;

        if ($isdvd == 1 && $iswatched == 1 && $ismastarde == 1 && $isfavourite == 1) {
            $inAllLists = 1;
        }

        $averagestar = Arviolaari::averageStar($leffaid);


        View::make('movie/leffaetusivu.html', array(
            'elokuva' => $movie, 'valtio' => $country, 'nayttelijat' => $actors,
            'ohjaajat' => $directors, 'kuvaajat' => $cinematographers, 'kasikirjoittajat' => $screenwriters,
            'genret' => $genres, 'arviot' => $stars, 'kommentit' => $comments,
            'dvdt' => $dvds, 'sarjatAndElokuvat' => $seriesAndMovies, 'arvioitu' => $starred,
            'kommentoitu' => $commented, 'kommentti' => $comment, 'onkosuosikki' => $isfavourite,
            'onkokatsottu' => $iswatched, 'onkodvd' => $isdvd, 'onkomastarde' => $ismastarde,
            'kaikillalistoilla' => $inAllLists, 'keskiarvo' => $averagestar
        ));
    }

    /* Elokuvan lisäyssivulle tiedot */
    public static function addMoviePage() {
        $countries = Valtio::all();
        View::make('movie/leffalisays.html', array('valtiot' => $countries));
    }

    /* Elokuvan artistien-, genrejen- ja sarjojenlisäyssivulle tiedot */
    public static function addArtistsPage() {

        $actors = Artisti::findAllArtistsByType("Näyttelijä");
        $directors = Artisti::findAllArtistsByType("Ohjaaja");
        $cinematographers = Artisti::findAllArtistsByType("Kuvaaja");
        $screenwriters = Artisti::findAllArtistsByType("Käsikirjoittaja");
        $genres = Genre::all();
        $series = Sarja::all();
        $countries = Valtio::all();
        View::make('movie/leffalisaysihmiset.html', array(
            'nayttelijat' => $actors, 'ohjaajat' => $directors,
            'kuvaajat' => $cinematographers, 'kasikirjoittajat' => $screenwriters,
            'genret' => $genres, 'sarjat' => $series,
            'valtiot' => $countries
        ));
    }

    /* Elokuvan muokkaussivulle tiedot */
    public static function movieEditPage($leffaid) {
        $movie = Elokuva::findOne($leffaid);
        $countries = Valtio::all();
        $countryATM = Valtio::findValtioForElokuva($leffaid)->valtioid;
        $actors = Artisti::findArtistsForMovie($leffaid, "Näyttelijä");
        $directors = Artisti::findArtistsForMovie($leffaid, "Ohjaaja");
        $cinematographers = Artisti::findArtistsForMovie($leffaid, "Kuvaaja");
        $screenwriters = Artisti::findArtistsForMovie($leffaid, "Käsikirjoittaja");
        $genres = Genre::findGenretForElokuva($leffaid);
        $series = Sarjalaari::findSarjatForElokuva($leffaid);

        $actorsALL = Artisti::findAllArtistsNotInTheMovieByType("Näyttelijä", $leffaid);
        $directorsALL = Artisti::findAllArtistsNotInTheMovieByType("Ohjaaja", $leffaid);
        $cinematographersALL = Artisti::findAllArtistsNotInTheMovieByType("Kuvaaja", $leffaid);
        $screenwritersALL = Artisti::findAllArtistsNotInTheMovieByType("Käsikirjoittaja", $leffaid);
        $genresALL = Genre::findAllGenresNotInTheMovie($leffaid);
        $seriesALL = Sarja::findAllSeriesNotInTheMovie($leffaid);

        View::make('movie/leffamuokkaus.html', array(
            'elokuva' => $movie, 'valtiot' => $countries, 'nayttelijat' => $actors,
            'ohjaajat' => $directors, 'kuvaajat' => $cinematographers, 'kasikirjoittajat' => $screenwriters,
            'genret' => $genres, 'sarjat' => $series, 'tamanhetkinenvaltio' => $countryATM,
            'nayttelijatALL' => $actorsALL, 'ohjaajatALL' => $directorsALL, 'kuvaajatALL' => $cinematographersALL,
            'kasikirjoittajatALL' => $screenwritersALL, 'genretALL' => $genresALL, 'sarjatALL' => $seriesALL
        ));
    }

    /* Arvion lisääminen elokuvalle */
    public static function addStar($leffaid) {
        $params = $_POST;
        $tahti = $params['tahti'];
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
        $params = $_POST;
        $comment = $params['kommentti'];
        Kommentti::addCommentForMovie($leffaid, $comment);
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
            $countries = Valtio::all();
            View::make('/movie/leffalisays.html', array('errors' => $errors, 'attribuutit' => $attributes, 'valtiot' => $countries));
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
            $countries = Valtio::all();
            $actors = Artisti::findArtistsForMovie($leffaid, "Näyttelijä");
            $directors = Artisti::findArtistsForMovie($leffaid, "Ohjaaja");
            $cinematographers = Artisti::findArtistsForMovie($leffaid, "Kuvaaja");
            $screenwriters = Artisti::findArtistsForMovie($leffaid, "Käsikirjoittaja");
            $genres = Genre::findGenretForElokuva($leffaid);
            $series = Sarjalaari::findSarjatForElokuva($leffaid);
            $countryATM = $attributes['valtio'];

            $actorsALL = Artisti::findAllArtistsNotInTheMovieByType("Näyttelijä", $leffaid);
            $directorsALL = Artisti::findAllArtistsNotInTheMovieByType("Ohjaaja", $leffaid);
            $cinematographersALL = Artisti::findAllArtistsNotInTheMovieByType("Kuvaaja", $leffaid);
            $screenwritersALL = Artisti::findAllArtistsNotInTheMovieByType("Käsikirjoittaja", $leffaid);
            $genresALL = Genre::findAllGenresNotInTheMovie($leffaid);
            $seriesALL = Sarja::findAllSeriesNotInTheMovie($leffaid);

            View::make('/movie/leffamuokkaus.html', array(
                'valtiot' => $countries, 'tamanhetkinenvaltio' => $countryATM,
                'nayttelijat' => $actors, 'ohjaajat' => $directors, 'kuvaajat' => $cinematographers,
                'kasikirjoittajat' => $screenwriters, 'genret' => $genres, 'sarjat' => $series,
                'errors' => $errors, 'elokuva' => $attributes,
                'nayttelijatALL' => $actorsALL, 'ohjaajatALL' => $directorsALL, 'kuvaajatALL' => $cinematographersALL,
                'kasikirjoittajatALL' => $screenwritersALL, 'genretALL' => $genresALL, 'sarjatALL' => $seriesALL
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
            $countries = Valtio::all();
            View::make('/movie/leffalisays.html', array('errors' => $errors, 'attribuutit' => $attributes, 'valtiot' => $countries));
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

            $countries = Valtio::all();
            $actors = Artisti::findArtistsForMovie($leffaid, "Näyttelijä");
            $directors = Artisti::findArtistsForMovie($leffaid, "Ohjaaja");
            $cinematographers = Artisti::findArtistsForMovie($leffaid, "Kuvaaja");
            $screenwriters = Artisti::findArtistsForMovie($leffaid, "Käsikirjoittaja");
            $genres = Genre::findGenretForElokuva($leffaid);
            $countryATM = $attributes['valtio'];
            $series = Sarjalaari::findSarjatForElokuva($leffaid);

            $actorsALL = Artisti::findAllArtistsNotInTheMovieByType("Näyttelijä", $leffaid);
            $directorsALL = Artisti::findAllArtistsNotInTheMovieByType("Ohjaaja", $leffaid);
            $cinematographersALL = Artisti::findAllArtistsNotInTheMovieByType("Kuvaaja", $leffaid);
            $screenwritersALL = Artisti::findAllArtistsNotInTheMovieByType("Käsikirjoittaja", $leffaid);
            $genresALL = Genre::findAllGenresNotInTheMovie($leffaid);
            $seriesALL = Sarja::findAllSeriesNotInTheMovie($leffaid);

            View::make('/movie/leffamuokkaus.html', array(
                'valtiot' => $countries, 'tamanhetkinenvaltio' => $countryATM,
                'nayttelijat' => $actors, 'ohjaajat' => $directors, 'kuvaajat' => $cinematographers,
                'kasikirjoittajat' => $screenwriters, 'genret' => $genres, 'errors' => $errors,
                'elokuva' => $attributes, 'sarjat' => $series,
                'nayttelijatALL' => $actorsALL, 'ohjaajatALL' => $directorsALL, 'kuvaajatALL' => $cinematographersALL,
                'kasikirjoittajatALL' => $screenwritersALL, 'genretALL' => $genresALL, 'sarjatALL' => $seriesALL
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
