<?php

/* Etusivun, Kaikki-sivun ja hiekkalaatikon kontrollointi */

class BasisController extends BaseController {

    /* Testaus hiekkalaatikko */
    public static function sandbox() {
        // Testaa koodiasi täällä        
        Kint::dump(Viesti::all());
    }

    /* Näyttää etusivun */
    public static function firstPage() {
        View::make('basis/etusivu.html');
    }

    /* Kaikki-sivulle tiedot */
    public static function all() {
        $elokuvat = Elokuva::all();
        $artistit = Artisti::all();
        $valtiot = Valtio::all();
        $kayttajat = Kayttaja::all();
        View::make('basis/kaikki.html', array(
            'elokuvat' => $elokuvat,
            'artistit' => $artistit,
            'valtiot' => $valtiot,
            'kayttajat' => $kayttajat));
    }

}
