<?php

class SearchController extends BaseController {

    public static function searchpage() {
        $elokuvat = Elokuva::all();
        $nayttelijat = Artisti::findAllArtistit("Näyttelijä");
        $ohjaajat = Artisti::findAllArtistit("Ohjaaja");
        $kuvaajat = Artisti::findAllArtistit("Kuvaaja");
        $kassarit = Artisti::findAllArtistit("Käsikirjoittaja");
        $valtiot = Valtio::all();
        $genret = Genre::all();
        $palkinnot = Palkinto::all();
        $sarjat = Sarja::all();
        View::make('basis/haku.html', array(
            'valtiot' => $valtiot,
            'genret' => $genret,
            'palkinnot' => $palkinnot,
            'sarjat' => $sarjat,
            'nayttelijat' => $nayttelijat,
            'ohjaajat' => $ohjaajat,
            'kuvaajat' => $kuvaajat,
            'kasikirjoittajat' => $kassarit,
            'elokuvat' => $elokuvat
        ));
    }

    public static function search() {
        $parametrit = $_POST;

        $valinnat = array();

        if (isset($parametrit['leffaid'])) {
            $valinnat['leffaid'] = $parametrit['leffaid'];
        }
        if (isset($parametrit['nayttelija'])) {
            $valinnat['nayttelija'] = $parametrit['nayttelija'];
        }
        if (isset($parametrit['ohjaaja'])) {
            $valinnat['ohjaaja'] = $parametrit['ohjaaja'];
        }
        if (isset($parametrit['kuvaaja'])) {
            $valinnat['kuvaaja'] = $parametrit['kuvaaja'];
        }
        if (isset($parametrit['kasikirjoittaja'])) {
            $valinnat['kasikirjoittaja'] = $parametrit['kasikirjoittaja'];
        }
        if (isset($parametrit['valtio'])) {
            $valinnat['valtio'] = $parametrit['valtio'];
        }
        if (isset($parametrit['alkuvuosi'])) {
            $valinnat['alkuvuosi'] = $parametrit['alkuvuosi'];
        }
        if (isset($parametrit['loppuvuosi'])) {
            $valinnat['loppuvuosi'] = $parametrit['loppuvuosi'];
        }
        if (isset($parametrit['kieli'])) {
            $valinnat['kieli'] = $parametrit['kieli'];
        }
        if (isset($parametrit['genre'])) {
            $valinnat['genre'] = $parametrit['genre'];
        }
        if (isset($parametrit['palkinto'])) {
            $valinnat['palkinto'] = $parametrit['palkinto'];
        }
        if (isset($parametrit['sarja'])) {
            $valinnat['sarja'] = $parametrit['sarja'];
        }

        $tulokset = Elokuva::search($valinnat);

        View::make('basis/haku.html', array('tulokset' => $tulokset));
    }

}
