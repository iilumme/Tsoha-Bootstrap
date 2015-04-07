<?php

class ArtistController extends BaseController {

    public static function showOne($id) {
        $artistit = array();
        $artisti = Artisti::findOne($id);
        $artistit[] = $artisti;

        $valtiot = array();
        $valtio = Valtio::findValtioForArtisti($id);
        $valtiot[] = $valtio;

        $leffat = Elokuva::findElokuvatForArtisti($id);

        View::make('artist/artistietusivu.html', array(
            'artistit' => $artistit,
            'valtiot' => $valtiot,
            'elokuvat' => $leffat
        ));
    }

    public static function artistEdit($id) {
        $artistit = array();
        $artisti = Artisti::findOne($id);
        $artistit[] = $artisti;

        $valtiot = Valtio::all();
        $tamanhetkinenvaltio = Valtio::findValtioForArtisti($id);
        $leffat = Elokuva::findElokuvatForArtisti($id);

        View::make('artist/artistimuokkaus.html', array(
            'artistit' => $artistit,
            'valtiot' => $valtiot,
            'elokuvat' => $leffat,
            'tamanhetkinenvaltio' => $tamanhetkinenvaltio
        ));
    }

    public static function store() {
        $parametrit = $_POST;

        $attribuutit = array(
            'artistityyppi' => $parametrit['artistityyppi'],
            'etunimi' => $parametrit['etunimi'],
            'sukunimi' => $parametrit['sukunimi'],
            'bio' => $parametrit['bio'],
            'syntymavuosi' => (int) $parametrit['syntymavuosi'],
            'valtio' => (int) $parametrit['valtio']
        );

        $artisti = new Artisti(array(
            'artistityyppi' => $parametrit['artistityyppi'],
            'etunimi' => $parametrit['etunimi'],
            'sukunimi' => $parametrit['sukunimi'],
            'bio' => $parametrit['bio'],
            'syntymavuosi' => (int) $parametrit['syntymavuosi'],
            'valtio' => (int) $parametrit['valtio']
        ));

        $errors = $artisti->errors();

        if (count($errors) == 0) {
            $artisti->save();
        } else {
            
        }
    }

    public static function update($id) {
        $parametrit = $_POST;

        $attribuutit = array(
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
            $artist->update($id);
            Redirect::to('/artist/' . $id, array('message' => 'Tietojen päivittäminen onnistui! :)'));
        } else {
            $valtiot = Valtio::all();
            View::make('/artist/artistimuokkaus.html', array(
                'valtiot' => $valtiot,
                'attribuutit' => $attribuutit
            ));
        }
    }

    public static function destroy($id) {
        $artist = new Artisti(array('id' => $id));
        $artist->destroy($id);
        
        Redirect::to('/', array('message' => 'Artistin poistaminen onnistui'));
    }

}
