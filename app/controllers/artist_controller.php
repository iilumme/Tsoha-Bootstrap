<?php

/* Kontrolloi artisteihin liittyviä sivuja */

class ArtistController extends BaseController {
    
    /* Artistin esittelysivulle tiedot */
    public static function showOne($artistiid) {

        $artisti = Artisti::findOne($artistiid);
        $valtio = Valtio::findValtioForArtisti($artistiid);
        $leffat = Elokuva::findElokuvatForArtisti($artistiid);

        View::make('artist/artistietusivu.html', array(
            'artisti' => $artisti,
            'valtio' => $valtio,
            'elokuvat' => $leffat
        ));
    }

    /* Artistin muokkaussivulle tiedot */
    public static function artistEditPage($artistiid) {

        $artisti = Artisti::findOne($artistiid);
        $valtiot = Valtio::all();
        $tamanhetkinenvaltio = Valtio::findValtioForArtisti($artistiid)->valtioid;
        $leffat = Elokuva::findElokuvatForArtisti($artistiid);
        $elokuvatALL = Elokuva::all();
        
        View::make('artist/artistimuokkaus.html', array(
            'artisti' => $artisti, 'valtiot' => $valtiot,
            'elokuvat' => $leffat, 'tamanhetkinenvaltio' => $tamanhetkinenvaltio,
            'elokuvatALL' => $elokuvatALL
        ));
    }

    /* Uuden artistiehdotuksen tallentaminen */
    //HUOMIO ITSELLE!
    public static function storeSuggestion($ryhmaid) {
        $parametrit = $_POST;

        $attribuutit = array(
            'artistityyppi' => $parametrit['artistityyppi'],
            'etunimi' => $parametrit['etunimi'],
            'sukunimi' => $parametrit['sukunimi'],
            'bio' => $parametrit['bio'],
            'syntymavuosi' => (int) $parametrit['syntymavuosi'],
            'valtio' => (int) $parametrit['valtio']
        );

        $artisti = new Artisti($attribuutit);
        $errors = $artisti->errors();

        if (count($errors) == 0) {
            $artisti->saveSuggestion($ryhmaid);
            LaariController::artistilaariSaveSuggestionWithoutArtistiID($ryhmaid);
        } else {
            //mieti tämä
        }
    }
    
    /* Uuden artistiehdotuksen tallentaminen */
    //HUOMIO ITSELLE!
    public static function storeSuggestionUpdate($leffaid) {
        $parametrit = $_POST;

        $attribuutit = array(
            'artistityyppi' => $parametrit['artistityyppi'],
            'etunimi' => $parametrit['etunimi'],
            'sukunimi' => $parametrit['sukunimi'],
            'bio' => $parametrit['bio'],
            'syntymavuosi' => (int) $parametrit['syntymavuosi'],
            'valtio' => (int) $parametrit['valtio']
        );

        $artisti = new Artisti($attribuutit);
        $errors = $artisti->errors();

        if (count($errors) == 0) {
            $ryhmaid = $artisti->saveSuggestionOwnGroup();
            LaariController::artistilaariSaveSuggestionWithoutArtistiIDWithLeffaID($leffaid, $ryhmaid);
        } else {
            //mieti tämä
        }
    }

    /* Artistin muokkauksehdotuksen tallentaminen */
    public static function updateSuggestion($artistiid) {
        $parametrit = $_POST;
        $attribuutit = array('artistiid' => $artistiid,
            'artistityyppi' => $parametrit['artistityyppi'],
            'etunimi' => $parametrit['etunimi'],
            'sukunimi' => $parametrit['sukunimi'],
            'bio' => $parametrit['bio'],
            'syntymavuosi' => (int) $parametrit['syntymavuosi'],
            'valtio' => (int) $parametrit['valtio']);

        $artist = new Artisti($attribuutit);
        $errors = $artist->errors();

        if (count($errors) == 0) {
            $ryhmaid = $artist->updateSuggestion();
            LaariController::artistilaariUpdateSuggestionMovies($parametrit, $artistiid, $ryhmaid);
            Redirect::to('/artist/' . $artistiid, array('message' => 'Muokkausehdotus on lähetetty ylläpitäjälle :)'));
        } else {
            $valtiot = Valtio::all();
            $tamanhetkinenvaltio = $attribuutit['valtio'];
            View::make('/artist/artistimuokkaus.html', array('valtiot' => $valtiot,
                'tamanhetkinenvaltio' => $tamanhetkinenvaltio, 'artisti' => $attribuutit, 'errors' => $errors
            ));
        }
    }

    /* Artistin poistaminen */
    public static function destroy($artistiid) {
        $artist = new Artisti(array('artistiid' => $artistiid));
        $artist->destroy();
        Redirect::to('/', array('message' => 'Artistin poistaminen onnistui! :)'));
    }

    /* Artistin poistaminen ylläpitosivuilla */
    public static function destroyMaintenance($artistiid) {
        $artist = new Artisti(array('artistiid' => $artistiid));
        $artist->destroy();
        Redirect::to('/artistmaintenance', array('message' => 'Artistin poistaminen onnistui! :)'));
    }

    /* Uuden artistin lisäys - ylläpitäjä tekee */
    //HUOMIO ITSELLE!!
    public static function administratorStore($leffaid) {
        $parametrit = $_POST;

        $attribuutit = array(
            'artistityyppi' => $parametrit['artistityyppi'],
            'etunimi' => $parametrit['etunimi'],
            'sukunimi' => $parametrit['sukunimi'],
            'bio' => $parametrit['bio'],
            'syntymavuosi' => (int) $parametrit['syntymavuosi'],
            'valtio' => (int) $parametrit['valtio']
        );

        $artisti = new Artisti($attribuutit);
        $errors = $artisti->errors();

        if (count($errors) == 0) {
            $id = $artisti->save();
            $param['artistilista'] = $id;
            LaariController::artistilaariSaveAdministrator($param, $leffaid);
        } else {
            //mieti tämä
        }
    }

    /* Artistin muokkaus - ylläpitäjä tekee */
    public static function administratorUpdate($artistiid) {
        $parametrit = $_POST;
        $attribuutit = array('artistiid' => $artistiid,
            'artistityyppi' => $parametrit['artistityyppi'],
            'etunimi' => $parametrit['etunimi'],
            'sukunimi' => $parametrit['sukunimi'],
            'bio' => $parametrit['bio'],
            'syntymavuosi' => (int) $parametrit['syntymavuosi'],
            'valtio' => (int) $parametrit['valtio']);

        $artist = new Artisti($attribuutit);
        $errors = $artist->errors();

        if (count($errors) == 0) {
            $artist->update();
            LaariController::artistilaariUpdateMoviesAdministrator($parametrit, $artistiid);
            Redirect::to('/artist/' . $artistiid, array('message' => 'Tietojen päivittäminen onnistui! :)'));
        } else {
            $valtiot = Valtio::all();
            $tamanhetkinenvaltio = $attribuutit['valtio'];
            View::make('/artist/artistimuokkaus.html', array('valtiot' => $valtiot,
                'tamanhetkinenvaltio' => $tamanhetkinenvaltio, 'artisti' => $attribuutit, 'errors' => $errors
            ));
        }
    }

}
