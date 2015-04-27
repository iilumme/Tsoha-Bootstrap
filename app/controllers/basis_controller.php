<?php

/* Etusivun, Kaikki-sivun ja hiekkalaatikon kontrollointi */

class BasisController extends BaseController {

    /* Testaus hiekkalaatikko */
    public static function sandbox() {
        // Testaa koodiasi täällä
//        $elokuva = Elokuva::findOne(1);
//        $elokuvat = Elokuva::all();
//
//        $valtio = Valtio::findOne(1);
//        $valtiot = Valtio::all();
//
//        $artisti = Artisti::findOne(2);
//        $artistit = Artisti::all();
//
//        $genre = Genre::findOne(1);
//        $genret = Genre::all();
//
//        $kayttaja = Kayttaja::findOne(1);
//        $kayttajat = Kayttaja::all();
//
//        $kommentti = Kommentti::findOne(1, 1);
//        $kommentit = Kommentti::all();
//
//        $sarja = Sarja::findOne(1);
//        $sarjat = Sarja::all();
//
//        $arvio = Arviolaari::findOne(1, 1);
//        $arviot = Arviolaari::all();
//
//        Kint::dump($elokuva);
//        Kint::dump($elokuvat);
//
//        Kint::dump($valtio);
//        Kint::dump($valtiot);
//
//        Kint::dump($artisti);
//        Kint::dump($artistit);
//
//        Kint::dump($genre);
//        Kint::dump($genret);
//
//        Kint::dump($kayttaja);
//        Kint::dump($kayttajat);
//
//        Kint::dump($kommentti);
//        Kint::dump($kommentit);
//
//        Kint::dump($sarja);
//        Kint::dump($sarjat);
//
//        Kint::dump($arvio);
//        Kint::dump($arviot);
//
//        $sa = Sarjalaari::findSarjanElokuvat(1);
//        Kint::dump($sa);
//
//        $favs = Elokuva::findSuosikkiElokuvat(self::get_user_logged_in()->kayttajaid);
//        Kint::dump($favs);
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
        View::make('basis/kaikki.html', array(
            'elokuvat' => $elokuvat,
            'artistit' => $artistit,
            'valtiot' => $valtiot));
    }

}
