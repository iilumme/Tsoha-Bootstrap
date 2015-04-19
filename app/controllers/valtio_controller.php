<?php

class ValtioController extends BaseController {

    public static function showOne($id) {

        $valtio = Valtio::findOne($id);
        $nayttelijat = Artisti::findArtistitForValtio($id, 'Näyttelijä');
        $ohjaajat = Artisti::findArtistitForValtio($id, 'Ohjaaja');
        $kassarit = Artisti::findArtistitForValtio($id, 'Käsikirjoittaja');
        $kuvaajat = Artisti::findArtistitForValtio($id, 'Kuvaaja');
        $elokuvat = Elokuva::findElokuvatForValtiot($id);

        View::make('/country/valtioetusivu.html', array(
            'valtio' => $valtio,
            'nayttelijat' => $nayttelijat,
            'ohjaajat' => $ohjaajat,
            'kuvaajat' => $kuvaajat,
            'kasikirjoittajat' => $kassarit,
            'elokuvat' => $elokuvat
        ));
    }

    public static function countryEdit($id) {
        $valtio = Valtio::findOne($id);
        View::make('/country/valtiomuokkaus.html', array('valtio' => $valtio));
    }

    public static function update($id) {
        $parametrit = $_POST;

        $attribuutit = array(
            'valtioid' => $id,
            'valtiobio' => $parametrit['valtiobio']);
        $valtio = new Valtio($attribuutit);

        $valtio->updateSuggestion();
        Redirect::to('/country/' . $id, array('message' => 'Muokkausehdotus on lähetetty ylläpitäjälle :)'));
    }
    
    public static function adminUpdate($id) {
        $parametrit = $_POST;

        $attribuutit = array(
            'valtioid' => $id,
            'valtiobio' => $parametrit['valtiobio']);
        $valtio = new Valtio($attribuutit);

        $valtio->update();
        Redirect::to('/country/' . $id, array('message' => 'Tietojen päivittäminen onnistui! :)'));
    }

}
