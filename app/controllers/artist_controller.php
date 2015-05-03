<?php

/* Kontrolloi artisteihin liittyviä sivuja */

class ArtistController extends BaseController {


    /* Artistin esittelysivulle tiedot */
    public static function showOne($artistiid) {

        $artist = Artisti::findOne($artistiid);
        $country = Valtio::findValtioForArtisti($artistiid);
        $movies = Elokuva::findElokuvatForArtisti($artistiid);

        View::make('artist/artistietusivu.html', array(
            'artisti' => $artist,
            'valtio' => $country,
            'elokuvat' => $movies
        ));
    }

    /* Artistin muokkaussivulle tiedot */
    public static function artistEditPage($artistiid) {

        $artist = Artisti::findOne($artistiid);
        $countries = Valtio::all();
        $countryATM = Valtio::findValtioForArtisti($artistiid)->valtioid;
        $movies = Elokuva::findElokuvatForArtisti($artistiid);
        $moviesALL = Elokuva::all();

        View::make('artist/artistimuokkaus.html', array(
            'artisti' => $artist, 'valtiot' => $countries,
            'elokuvat' => $movies, 'tamanhetkinenvaltio' => $countryATM,
            'elokuvatALL' => $moviesALL
        ));
    }

    /* Uusi ehdotus uudesta artistista ja sen tallentaminen */
    public static function storeSuggestion($ryhmaid) {
        $params = $_POST;

        $attributes = array(
            'artistityyppi' => $params['artistityyppi'],
            'etunimi' => $params['etunimi'],
            'sukunimi' => $params['sukunimi'],
            'bio' => $params['bio'],
            'syntymavuosi' => (int) $params['syntymavuosi'],
            'valtio' => (int) $params['valtio']
        );

        $artist = new Artisti($attributes);
        $errors = $artist->errors();

        if (count($errors) == 0) {
            $artist->saveSuggestion($ryhmaid);
            LaariController::artistilaariSaveSuggestionWithoutArtistiID($ryhmaid);
        } else {
            //LISÄOMINAISUUS
        }
    }

    /* Uusi ehdotus uudesta artistista, elokuvan päivittämisen yhteydessä */
    public static function storeSuggestionOnMovieUpdate($leffaid) {
        $params = $_POST;

        $attributes = array(
            'artistityyppi' => $params['artistityyppi'],
            'etunimi' => $params['etunimi'],
            'sukunimi' => $params['sukunimi'],
            'bio' => $params['bio'],
            'syntymavuosi' => (int) $params['syntymavuosi'],
            'valtio' => (int) $params['valtio']
        );

        $artisti = new Artisti($attributes);
        $errors = $artisti->errors();

        if (count($errors) == 0) {
            $ryhmaid = $artisti->saveSuggestionOwnGroup();
            LaariController::artistilaariSaveSuggestionWithoutArtistiIDWithLeffaID($leffaid, $ryhmaid);
        } else {
            //LISÄOMINAISUUS
        }
    }

    /* Artistin muokkauksehdotuksen tallentaminen */
    public static function updateSuggestion($artistiid) {
        $params = $_POST;

        $attributes = array('artistiid' => $artistiid,
            'artistityyppi' => $params['artistityyppi'],
            'etunimi' => $params['etunimi'],
            'sukunimi' => $params['sukunimi'],
            'bio' => $params['bio'],
            'syntymavuosi' => (int) $params['syntymavuosi'],
            'valtio' => (int) $params['valtio']);

        $artist = new Artisti($attributes);
        $errors = $artist->errors();

        if (count($errors) == 0) {
            $ryhmaid = $artist->updateSuggestion();
            LaariController::artistilaariUpdateMoviesSuggestion($params, $artistiid, $ryhmaid);
            Redirect::to('/artist/' . $artistiid, array('message' => 'Muokkausehdotus on lähetetty ylläpitäjälle! :)'));
        } else {
            $attributes['kuva'] = Artisti::findOne($artistiid)->kuva;
            $countries = Valtio::all();
            $countryATM = $attributes['valtio'];
            $movies = Elokuva::findElokuvatForArtisti($artistiid);
            $moviesALL = Elokuva::all();
            View::make('/artist/artistimuokkaus.html', array('valtiot' => $countries,
                'tamanhetkinenvaltio' => $countryATM, 'artisti' => $attributes, 'errors' => $errors,
                'elokuvat' => $movies, 'elokuvatALL' => $moviesALL
            ));
        }
    }

    /* Artistin poistaminen */
    public static function destroy($artistiid) {
        $artist = new Artisti(array('artistiid' => $artistiid));
        $artist->destroy();
        Redirect::to('/', array('deleteMessage' => 'Artistin poistaminen onnistui! :) '));
    }

    /* Artistin poistaminen ylläpitosivuilla */
    public static function destroyMaintenance($artistiid) {
        $artist = new Artisti(array('artistiid' => $artistiid));
        $artist->destroy();
        Redirect::to('/artistmaintenance', array('deleteMessage' => 'Artistin poistaminen onnistui! :)'));
    }

    
    /* YLLÄPITÄJÄN METODIT */


    /* Uuden artistin lisäys - ylläpitäjä tekee */
    public static function administratorStore($leffaid) {
        $params = $_POST;

        $attributes = array(
            'artistityyppi' => $params['artistityyppi'],
            'etunimi' => $params['etunimi'],
            'sukunimi' => $params['sukunimi'],
            'bio' => $params['bio'],
            'syntymavuosi' => (int) $params['syntymavuosi'],
            'valtio' => (int) $params['valtio']
        );

        $artist = new Artisti($attributes);
        $errors = $artist->errors();

        if (count($errors) == 0) {
            $artistiid = $artist->save();
            $param['artistilista'] = $artistiid;
            LaariController::artistilaariSaveAdministrator($param, $leffaid);
        } else {
            //LISÄOMINAISUUS
        }
    }

    /* Artistin muokkaus - ylläpitäjä tekee */
    public static function administratorUpdate($artistiid) {
        $params = $_POST;
        $attributes = array('artistiid' => $artistiid,
            'artistityyppi' => $params['artistityyppi'],
            'etunimi' => $params['etunimi'],
            'sukunimi' => $params['sukunimi'],
            'bio' => $params['bio'],
            'syntymavuosi' => (int) $params['syntymavuosi'],
            'valtio' => (int) $params['valtio']);

        $artist = new Artisti($attributes);
        $errors = $artist->errors();

        if (count($errors) == 0) {
            $artist->update();
            LaariController::artistilaariUpdateMoviesAdministrator($params, $artistiid);
            Redirect::to('/artist/' . $artistiid, array('message' => 'Tietojen päivittäminen onnistui! :)'));
        } else {         
            $attributes['kuva'] = Artisti::findOne($artistiid)->kuva;
            $countries = Valtio::all();
            $countryATM = $attributes['valtio'];
            $movies = Elokuva::findElokuvatForArtisti($artistiid);
            $moviesALL = Elokuva::all();
            View::make('/artist/artistimuokkaus.html', array('valtiot' => $countries,
                'tamanhetkinenvaltio' => $countryATM, 'artisti' => $attributes, 'errors' => $errors,
                'elokuvat' => $movies, 'elokuvatALL' => $moviesALL
            ));
        }
    }

}
