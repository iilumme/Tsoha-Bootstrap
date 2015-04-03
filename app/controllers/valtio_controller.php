<?php

class ValtioController extends BaseController {

    public static function showOne($id) {

        $valtio = array();
        $valtio[] = Valtio::findOne($id);

        $nayttelijat = array();
        $nayttelijat = Artisti::findArtistitForValtio($id, 'Näyttelijä');

        $ohjaajat = array();
        $ohjaajat = Artisti::findArtistitForValtio($id, 'Ohjaaja');

        $kassarit = array();
        $kassarit = Artisti::findArtistitForValtio($id, 'Käsikirjoittaja');

        $kuvaajat = array();
        $kuvaajat = Artisti::findArtistitForValtio($id, 'Kuvaaja');

        $elokuvat = array();
        $elokuvat = Elokuva::findElokuvatForValtiot($id);

        View::make('/suunnitelmat/valtioetusivu.html', array(
            'valtiot' => $valtio,
            'nayttelijat' => $nayttelijat,
            'ohjaajat' => $ohjaajat,
            'kuvaajat' => $kuvaajat,
            'kasikirjoittajat' => $kassarit,
            'elokuvat' => $elokuvat
        ));
    }

    public static function countryEdit($id) {
        $valtio = array();
        $valtio[] = Valtio::findOne($id);
        View::make('/suunnitelmat/valtiomuokkaus.html', array(
            'valtiot' => $valtio
        ));
    }

    public static function update($id) {
        $parametrit = $_POST;

        $attribuutit = array(
            'valtiobio' => $parametrit['valtiobio']
        );

        $valtio = new Valtio($attribuutit);

        $valtio->update($id);
        Redirect::to('/country/' . $id, array('message' => 'Tietojen päivittäminen onnistui! :)'));
    }

}
