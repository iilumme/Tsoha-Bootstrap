<?php

class ValtioController extends BaseController {

    public static function showOne($id) {

        $valtio = array();
        $valtio[] = Valtio::findOne($id);

        $nayttelijat = array();
        $nayttelijat = Artisti::findArtistitForValtio($id, 'Näyttelija');

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

}
