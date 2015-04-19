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
    public static function artisteditpage($artistiid) {

        $artisti = Artisti::findOne($artistiid);
        $valtiot = Valtio::all();
        $tamanhetkinenvaltio = Valtio::findValtioForArtisti($artistiid)->valtioid;
        $leffat = Elokuva::findElokuvatForArtisti($artistiid);

        View::make('artist/artistimuokkaus.html', array(
            'artisti' => $artisti, 'valtiot' => $valtiot,
            'elokuvat' => $leffat, 'tamanhetkinenvaltio' => $tamanhetkinenvaltio
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
            LaariController::artistilaariSaveWithoutID($ryhmaid);
        } else {
            //mieti tämä
        }
    }

    /* Artistin muokkauksehdotuksen tallentaminen */
    public static function updateSuggestion($id) {
        $parametrit = $_POST;
        $attribuutit = array('artistiid' => $id,
            'artistityyppi' => $parametrit['artistityyppi'],
            'etunimi' => $parametrit['etunimi'],
            'sukunimi' => $parametrit['sukunimi'],
            'bio' => $parametrit['bio'],
            'syntymavuosi' => (int) $parametrit['syntymavuosi'],
            'valtio' => (int) $parametrit['valtio']);

        $artist = new Artisti($attribuutit);
        $errors = $artist->errors();

        if (count($errors) == 0) {
            $artist->updateSuggestion();
            Redirect::to('/artist/' . $id, array('message' => 'Muokkausehdotus on lähetetty ylläpitäjälle :)'));
        } else {
            $valtiot = Valtio::all();
            $tamanhetkinenvaltio = $attribuutit['valtio'];
            View::make('/artist/artistimuokkaus.html', array('valtiot' => $valtiot,
                'tamanhetkinenvaltio' => $tamanhetkinenvaltio, 'artisti' => $attribuutit, 'errors' => $errors
            ));
        }
    }

    /* Artistin poistaminen */
    public static function destroy($id) {
        $artist = new Artisti(array('id' => $id));
        $artist->destroy($id);
        Redirect::to('/', array('message' => 'Artistin poistaminen onnistui! :)'));
    }

    /* Artistin poistaminen ylläpitosivuilla */
    public static function destroyMaintenance($id) {
        $artist = new Artisti(array('id' => $id));
        $artist->destroy($id);
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
            LaariController::artistilaariSaveAdmin($param, $leffaid);
        } else {
            //mieti tämä
        }
    }

    /* Artistin muokkaus - ylläpitäjä tekee */
    public static function administratorUpdate($id) {
        $parametrit = $_POST;
        $attribuutit = array('artistiid' => $id,
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
            Redirect::to('/artist/' . $id, array('message' => 'Tietojen päivittäminen onnistui! :)'));
        } else {
            $valtiot = Valtio::all();
            $tamanhetkinenvaltio = $attribuutit['valtio'];
            View::make('/artist/artistimuokkaus.html', array('valtiot' => $valtiot,
                'tamanhetkinenvaltio' => $tamanhetkinenvaltio, 'artisti' => $attribuutit, 'errors' => $errors
            ));
        }
    }

}
