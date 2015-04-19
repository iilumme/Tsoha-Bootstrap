<?php

class ArtistController extends BaseController {

    public static function showOne($id) {

        $artisti = Artisti::findOne($id);
        $valtio = Valtio::findValtioForArtisti($id);
        $leffat = Elokuva::findElokuvatForArtisti($id);

        View::make('artist/artistietusivu.html', array(
            'artisti' => $artisti,
            'valtio' => $valtio,
            'elokuvat' => $leffat
        ));
    }

    public static function artisteditpage($id) {

        $artisti = Artisti::findOne($id);
        $valtiot = Valtio::all();
        $tamanhetkinenvaltio = Valtio::findValtioForArtisti($id)->valtioid;
        $leffat = Elokuva::findElokuvatForArtisti($id);

        View::make('artist/artistimuokkaus.html', array(
            'artisti' => $artisti, 'valtiot' => $valtiot,
            'elokuvat' => $leffat, 'tamanhetkinenvaltio' => $tamanhetkinenvaltio
        ));
    }

    public static function store($ryhmaid) {
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

    public static function update($id) {
        $parametrit = $_POST;
        $attribuutit = array(
            'artistiid' => $id,
            'artistityyppi' => $parametrit['artistityyppi'],
            'etunimi' => $parametrit['etunimi'],
            'sukunimi' => $parametrit['sukunimi'],
            'bio' => $parametrit['bio'],
            'syntymavuosi' => (int) $parametrit['syntymavuosi'],
            'valtio' => (int) $parametrit['valtio']
        );

        $artist = new Artisti($attribuutit);
        $errors = $artist->errors();

        if (count($errors) == 0) {
            $artist->updateSuggestion();
            Redirect::to('/artist/' . $id, array('message' => 'Muokkausehdotus on lähetetty ylläpitäjälle :)'));
        } else {
            $valtiot = Valtio::all();
            $tamanhetkinenvaltio = $attribuutit['valtio'];
            View::make('/artist/artistimuokkaus.html', array(
                'valtiot' => $valtiot, 'tamanhetkinenvaltio' => $tamanhetkinenvaltio,
                'artisti' => $attribuutit, 'errors' => $errors
            ));
        }
    }

    public static function destroy($id) {
        $artist = new Artisti(array('id' => $id));
        $artist->destroy($id);
        Redirect::to('/', array('message' => 'Artistin poistaminen onnistui! :)'));
    }
    
    public static function destroyMaintenance($id) {
        $artist = new Artisti(array('id' => $id));
        $artist->destroy($id);
        Redirect::to('/artistmaintenance', array('message' => 'Artistin poistaminen onnistui! :)'));
    }

    public static function adminStore($leffaid) {
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

    public static function adminUpdate($id) {
        $parametrit = $_POST;
        $attribuutit = array(
            'artistiid' => $id,
            'artistityyppi' => $parametrit['artistityyppi'],
            'etunimi' => $parametrit['etunimi'],
            'sukunimi' => $parametrit['sukunimi'],
            'bio' => $parametrit['bio'],
            'syntymavuosi' => (int) $parametrit['syntymavuosi'],
            'valtio' => (int) $parametrit['valtio']
        );

        $artist = new Artisti($attribuutit);
        $errors = $artist->errors();

        if (count($errors) == 0) {
            $artist->update();
            Redirect::to('/artist/' . $id, array('message' => 'Tietojen päivittäminen onnistui! :)'));
        } else {
            $valtiot = Valtio::all();
            $tamanhetkinenvaltio = $attribuutit['valtio'];
            View::make('/artist/artistimuokkaus.html', array(
                'valtiot' => $valtiot, 'tamanhetkinenvaltio' => $tamanhetkinenvaltio,
                'artisti' => $attribuutit, 'errors' => $errors
            ));
        }
    }

}
