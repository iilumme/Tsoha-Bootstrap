<?php

class SearchController extends BaseController {

    public static function searchpage() {

        $parametrit = $_GET;

        Kint::dump($parametrit);

        $valinnat = array();


        if (isset($parametrit['nayttelijalista']) && $parametrit['nayttelijalista'][0] !== '') {
            $input = $parametrit['nayttelijalista'][0];
            $output = explode(',', $input);

            foreach ($output as $n) {
                $valinnat['nayttelijalista'][] = $n;
            }
        }
        if (isset($parametrit['ohjaajalista']) && $parametrit['ohjaajalista'] !== '') {
            $input = $parametrit['ohjaajalista'];
            $output = explode(',', $input);
            $valinnat['ohjaajalista'] = $output;
        }
        if (isset($parametrit['kuvaajalista']) && $parametrit['kuvaajalista'] !== '') {
            $input = $parametrit['kuvaajalista'];
            $output = explode(',', $input);
            $valinnat['kuvaajalista'] = $output;
        }
        if (isset($parametrit['kasikirjoittajalista']) && $parametrit['kasikirjoittajalista'] !== '') {
            $input = $parametrit['kasikirjoittajalista'];
            $output = explode(',', $input);
            $valinnat['kasikirjoittajalista'] = $output;
        }
        if (isset($parametrit['valtio']) && $parametrit['valtio'] !== '...') {
            $valinnat['valtio'] = (int) $parametrit['valtio'];
        }
        if (isset($parametrit['alkuvuosi']) && $parametrit['alkuvuosi'] !== '') {
            $valinnat['alkuvuosi'] = (int) $parametrit['alkuvuosi'];
        }
        if (isset($parametrit['loppuvuosi']) && $parametrit['loppuvuosi'] !== '') {
            $valinnat['loppuvuosi'] = (int) $parametrit['loppuvuosi'];
        }
        if (isset($parametrit['kieli']) && $parametrit['kieli'] !== '') {
            $valinnat['kieli'] = $parametrit['kieli'];
        }
        if (isset($parametrit['genre']) && $parametrit['genre'] !== '...') {
            $valinnat['genre'] = (int) $parametrit['genre'];
        }
        if (isset($parametrit['palkinto']) && $parametrit['palkinto'] !== '...') {
            $valinnat['palkinto'] = (int) $parametrit['palkinto'];
        }
        if (isset($parametrit['sarja']) && $parametrit['sarja'] !== '...') {
            $valinnat['sarja'] = (int) $parametrit['sarja'];
        }

        Kint::dump($valinnat);

        if (sizeof($valinnat) > 0) {
            $tulokset = Elokuva::search($valinnat);
        } else {
            $tulokset = null;
        }


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
            'valtiot' => $valtiot, 'genret' => $genret,
            'palkinnot' => $palkinnot, 'sarjat' => $sarjat,
            'nayttelijat' => $nayttelijat, 'ohjaajat' => $ohjaajat,
            'kuvaajat' => $kuvaajat, 'kasikirjoittajat' => $kassarit,
            'elokuvat' => $elokuvat, 'tulokset' => $tulokset, 'valinnat' => $valinnat
        ));
    }

}
