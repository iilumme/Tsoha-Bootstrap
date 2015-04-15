<?php

class BasisController extends BaseController {

    public static function sandbox() {
        // Testaa koodiasi täällä
        $elokuva = Elokuva::findOne(1);
        $elokuvat = Elokuva::all();

        $valtio = Valtio::findOne(1);
        $valtiot = Valtio::all();

        $artisti = Artisti::findOne(2);
        $artistit = Artisti::all();

        $genre = Genre::findOne(1);
        $genret = Genre::all();

        $kayttaja = Kayttaja::findOne(1);
        $kayttajat = Kayttaja::all();

        $kommentti = Kommentti::findOne(1, 1);
        $kommentit = Kommentti::all();

        $sarja = Sarja::findOne(1);
        $sarjat = Sarja::all();

        $arvio = Arviolaari::findOne(1, 1);
        $arviot = Arviolaari::all();

        $palkinto = Palkinto::findOne(1);
        $palkinnot = Palkinto::all();

        $suosikki = Suosikkilista::findOne(1, 1);
        $suosikit = Suosikkilista::all();

        $katsottu = Katsotutlista::findOne(1, 1);
        $katsotut = Katsotutlista::all();

        $mastarde = Mastardelista::findOne(1, 1);
        $mastardet = Mastardelista::all();

        $leffapalkinto = Leffapalkintolaari::findOne(1, 1);
        $leffapalkinnot = Leffapalkintolaari::all();

        $apalkinto = Artistipalkintolaari::findOne(1, 1);
        $apalkinnot = Artistipalkintolaari::all();

        Kint::dump($elokuva);
        Kint::dump($elokuvat);

        Kint::dump($valtio);
        Kint::dump($valtiot);

        Kint::dump($artisti);
        Kint::dump($artistit);

        Kint::dump($genre);
        Kint::dump($genret);

        Kint::dump($kayttaja);
        Kint::dump($kayttajat);

        Kint::dump($kommentti);
        Kint::dump($kommentit);

        Kint::dump($sarja);
        Kint::dump($sarjat);

        Kint::dump($arvio);
        Kint::dump($arviot);

        Kint::dump($palkinto);
        Kint::dump($palkinnot);

        Kint::dump($suosikki);
        Kint::dump($suosikit);

        Kint::dump($katsottu);
        Kint::dump($katsotut);

        Kint::dump($mastarde);
        Kint::dump($mastardet);

        Kint::dump($leffapalkinto);
        Kint::dump($leffapalkinnot);

        Kint::dump($apalkinto);
        Kint::dump($apalkinnot);

        $sa = Sarjalaari::findSarjanElokuvat(1);
        Kint::dump($sa);

        $favs = Elokuva::findSuosikkiElokuvat(self::get_user_logged_in()->kayttajaid);
        Kint::dump($favs);
    }

    public static function first_page() {
        View::make('basis/etusivukokeilu.html');
    }

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
