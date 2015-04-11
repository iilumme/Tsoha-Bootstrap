<?php

class SearchController extends BaseController {

    public static function searchpage() {

        $parametrit = $_GET;
        $valinnat = array();

        if (isset($parametrit['nayttelijalista']) && $parametrit['nayttelijalista'][0] !== '') {
            $input = $parametrit['nayttelijalista'][0];
            $output = explode(',', $input);

            foreach ($output as $n) {
                $valinnat['nayttelijalista'][] = $n;
            }
        }
        if (isset($parametrit['ohjaajalista']) && $parametrit['ohjaajalista'][0] !== '') {
            $input = $parametrit['ohjaajalista'][0];
            $output = explode(',', $input);

            foreach ($output as $n) {
                $valinnat['ohjaajalista'][] = $n;
            }
        }
        if (isset($parametrit['kuvaajalista']) && $parametrit['kuvaajalista'][0] !== '') {
            $input = $parametrit['kuvaajalista'][0];
            $output = explode(',', $input);
            foreach ($output as $n) {
                $valinnat['kuvaajalista'][] = $n;
            }
        }
        if (isset($parametrit['kasikirjoittajalista']) && $parametrit['kasikirjoittajalista'][0] !== '') {
            $input = $parametrit['kasikirjoittajalista'][0];
            $output = explode(',', $input);
            foreach ($output as $n) {
                $valinnat['kasikirjoittajalista'][] = $n;
            }
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

        $kuvanpaikka = 0;

        if (sizeof($valinnat) > 0) {
            $tulokset = Elokuva::search($valinnat);
            if (sizeof($tulokset) === 0) {
                $kuvanpaikka = 1;
            }
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
            'elokuvat' => $elokuvat, 'tulokset' => $tulokset, 'valinnat' => $valinnat,
            'kuvanpaikka' => $kuvanpaikka
        ));
    }

}
