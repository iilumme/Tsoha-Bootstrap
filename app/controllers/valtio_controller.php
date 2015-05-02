<?php

/* Valtiokontrolleri */

class ValtioController extends BaseController {

    /* Valtion esittelysivulle tiedot */
    public static function showOne($valtioid) {

        $valtio = Valtio::findOne($valtioid);
        $nayttelijat = Artisti::findArtistsForCountry($valtioid, 'Näyttelijä');
        $ohjaajat = Artisti::findArtistsForCountry($valtioid, 'Ohjaaja');
        $kassarit = Artisti::findArtistsForCountry($valtioid, 'Käsikirjoittaja');
        $kuvaajat = Artisti::findArtistsForCountry($valtioid, 'Kuvaaja');
        $elokuvat = Elokuva::findElokuvatForValtiot($valtioid);

        View::make('/country/valtioetusivu.html', array(
            'valtio' => $valtio,
            'nayttelijat' => $nayttelijat,
            'ohjaajat' => $ohjaajat,
            'kuvaajat' => $kuvaajat,
            'kasikirjoittajat' => $kassarit,
            'elokuvat' => $elokuvat
        ));
    }

    /* Valtion muokkaussivulle tiedot */
    public static function countryEdit($valtioid) {
        $valtio = Valtio::findOne($valtioid);
        View::make('/country/valtiomuokkaus.html', array('valtio' => $valtio));
    }

    /* Valtion muokkausehdotuksen tallentaminen */
    public static function updateSuggestion($valtioid) {
        $params = $_POST;

        $attributes = array(
            'valtioid' => $valtioid,
            'valtiobio' => $params['valtiobio']);
        $valtio = new Valtio($attributes);

        $valtio->updateSuggestion();
        Redirect::to('/country/' . $valtioid, array('message' => 'Muokkausehdotus on lähetetty ylläpitäjälle :)'));
    }
    
    /* Valtion muokkaaminen */
    public static function administratorUpdate($id) {
        $params = $_POST;

        $attributes = array(
            'valtioid' => $id,
            'valtiobio' => $params['valtiobio']);
        $valtio = new Valtio($attributes);

        $valtio->update();
        Redirect::to('/country/' . $id, array('message' => 'Tietojen päivittäminen onnistui! :)'));
    }

}
