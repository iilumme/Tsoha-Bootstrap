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

        $dvd = DVDlista::findOne(1, 1);
        $dvdt = DVDlista::all();

        $suosikki = Suosikkilista::findOne(1, 1);
        $suosikit = Suosikkilista::all();

        $katsottu = Katsotutlista::findOne(1, 1);
        $katsotut = Katsotutlista::all();

        $mastarde = Mastardelista::findOne(1, 1);
        $mastardet = Mastardelista::all();


        $artistilaari = Artistilaari::findOne(2, 1);
        $artistilaarit = Artistilaari::all();

        $sarjalaari = Sarjalaari::findOne(1, 1);
        $sarjalaarit = Sarjalaari::all();

        $leffapalkinto = Leffapalkintolaari::findOne(1, 1);
        $leffapalkinnot = Leffapalkintolaari::all();

        $apalkinto = Artistipalkintolaari::findOne(1, 1);
        $apalkinnot = Artistipalkintolaari::all();

        $genrelaari = Genrelaari::findOne(1, 1);
        $genrelaarit = Genrelaari::all();

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

        Kint::dump($dvd);
        Kint::dump($dvdt);

        Kint::dump($suosikki);
        Kint::dump($suosikit);

        Kint::dump($katsottu);
        Kint::dump($katsotut);

        Kint::dump($mastarde);
        Kint::dump($mastardet);

        Kint::dump($artistilaari);
        Kint::dump($artistilaarit);

        Kint::dump($sarjalaari);
        Kint::dump($sarjalaarit);

        Kint::dump($leffapalkinto);
        Kint::dump($leffapalkinnot);

        Kint::dump($apalkinto);
        Kint::dump($apalkinnot);

        Kint::dump($genrelaari);
        Kint::dump($genrelaarit);

        $sa = Sarjalaari::findSarjanElokuvat(1);
        Kint::dump($sa);

        $elo = new Elokuva(array(
            'vuosi' => 1700,
            'kieli' => ' '
        ));

        $errors = $elo->errors();
        Kint::dump($errors);
    }

    public static function first_page() {
        View::make('basis/etusivu.html');
    }

//    public static function search() {
//        View::make('basis/haku.html');
//    }

    //USERS




    public static function artist() {
        View::make('suunnitelmat/artistiesittely.html');
    }

    public static function test() {
        View::make('suunnitelmat/testisivu.html');
    }

}
