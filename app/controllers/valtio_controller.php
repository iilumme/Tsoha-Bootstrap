<?php

/* Valtiokontrolleri */

class ValtioController extends BaseController {

    /* Valtion esittelysivulle tiedot */
    public static function showOne($valtioid) {

        $country = Valtio::findOne($valtioid);
        $actors = Artisti::findArtistsForCountry($valtioid, 'Näyttelijä');
        $directors = Artisti::findArtistsForCountry($valtioid, 'Ohjaaja');
        $screenwriters = Artisti::findArtistsForCountry($valtioid, 'Käsikirjoittaja');
        $cinematographers = Artisti::findArtistsForCountry($valtioid, 'Kuvaaja');
        $movies = Elokuva::findElokuvatForValtiot($valtioid);

        View::make('/country/valtioetusivu.html', array(
            'valtio' => $country,
            'nayttelijat' => $actors,
            'ohjaajat' => $directors,
            'kuvaajat' => $cinematographers,
            'kasikirjoittajat' => $screenwriters,
            'elokuvat' => $movies
        ));
    }

    /* Valtion muokkaussivulle tiedot */
    public static function countryEdit($valtioid) {
        $country = Valtio::findOne($valtioid);
        View::make('/country/valtiomuokkaus.html', array('valtio' => $country));
    }

    /* Valtion muokkausehdotuksen tallentaminen */
    public static function updateSuggestion($valtioid) {
        $params = $_POST;

        $attributes = array(
            'valtioid' => $valtioid,
            'valtiobio' => $params['valtiobio']);
        $country = new Valtio($attributes);

        $country->updateSuggestion();
        Redirect::to('/country/' . $valtioid, array('message' => 'Muokkausehdotus on lähetetty ylläpitäjälle :)'));
    }
    
    /* Valtion muokkaaminen */
    public static function administratorUpdate($id) {
        $params = $_POST;

        $attributes = array(
            'valtioid' => $id,
            'valtiobio' => $params['valtiobio']);
        $country = new Valtio($attributes);

        $country->update();
        Redirect::to('/country/' . $id, array('message' => 'Tietojen päivittäminen onnistui! :)'));
    }

}
