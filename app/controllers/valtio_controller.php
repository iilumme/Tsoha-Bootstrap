<?php

/* Valtiokontrolleri */

class ValtioController extends BaseController {

    /* Valtion esittelysivulle tiedot */
    public static function showOne($valtioid) {

        $valtio = Valtio::findOne($valtioid);
        $nayttelijat = Artisti::findArtistitForValtio($valtioid, 'Näyttelijä');
        $ohjaajat = Artisti::findArtistitForValtio($valtioid, 'Ohjaaja');
        $kassarit = Artisti::findArtistitForValtio($valtioid, 'Käsikirjoittaja');
        $kuvaajat = Artisti::findArtistitForValtio($valtioid, 'Kuvaaja');
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
        $parametrit = $_POST;

        $attribuutit = array(
            'valtioid' => $valtioid,
            'valtiobio' => $parametrit['valtiobio']);
        $valtio = new Valtio($attribuutit);

        $valtio->updateSuggestion();
        Redirect::to('/country/' . $valtioid, array('message' => 'Muokkausehdotus on lähetetty ylläpitäjälle :)'));
    }
    
    /* Valtion muokkaaminen */
    public static function administratorUpdate($id) {
        $parametrit = $_POST;

        $attribuutit = array(
            'valtioid' => $id,
            'valtiobio' => $parametrit['valtiobio']);
        $valtio = new Valtio($attribuutit);

        $valtio->update();
        Redirect::to('/country/' . $id, array('message' => 'Tietojen päivittäminen onnistui! :)'));
    }

}
