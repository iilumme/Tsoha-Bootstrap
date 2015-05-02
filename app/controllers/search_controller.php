<?php

/* Haun kontrolleri */

class SearchController extends BaseController {

    /* Hakusivu ja hakeminen */
    public static function searchpage() {

        $params = $_GET;
        $kuvanpaikka = 0;
        $valinnat = array();

        if (isset($params['nayttelijalista']) && $params['nayttelijalista'][0] !== '') {
            $input = $params['nayttelijalista'][0];
            $output = explode(',', $input);

            foreach ($output as $n) {
                $valinnat['nayttelijalista'][] = $n;
            }
        }
        if (isset($params['ohjaajalista']) && $params['ohjaajalista'][0] !== '') {
            $input = $params['ohjaajalista'][0];
            $output = explode(',', $input);

            foreach ($output as $n) {
                $valinnat['ohjaajalista'][] = $n;
            }
        }
        if (isset($params['kuvaajalista']) && $params['kuvaajalista'][0] !== '') {
            $input = $params['kuvaajalista'][0];
            $output = explode(',', $input);
            foreach ($output as $n) {
                $valinnat['kuvaajalista'][] = $n;
            }
        }
        if (isset($params['kasikirjoittajalista']) && $params['kasikirjoittajalista'][0] !== '') {
            $input = $params['kasikirjoittajalista'][0];
            $output = explode(',', $input);
            foreach ($output as $n) {
                $valinnat['kasikirjoittajalista'][] = $n;
            }
        }
        if (isset($params['valtio']) && $params['valtio'] !== '...') {
            $valinnat['valtio'] = (int) $params['valtio'];
        }
        if (isset($params['alkuvuosi']) && $params['alkuvuosi'] !== '') {
            $valinnat['alkuvuosi'] = (int) $params['alkuvuosi'];
        }
        if (isset($params['loppuvuosi']) && $params['loppuvuosi'] !== '') {
            $valinnat['loppuvuosi'] = (int) $params['loppuvuosi'];
        }
        if (isset($params['kieli']) && $params['kieli'] !== '') {
            $valinnat['kieli'] = $params['kieli'];
        }
        if (isset($params['genre']) && $params['genre'] !== '...') {
            $valinnat['genre'] = (int) $params['genre'];
        }
        if (isset($params['sarja']) && $params['sarja'] !== '...') {
            $valinnat['sarja'] = (int) $params['sarja'];
        }


        if (sizeof($valinnat) > 0) {
            $tulokset = Elokuva::search($valinnat);
            if (sizeof($tulokset) === 0) {
                $kuvanpaikka = 1;
            }
        } else {
            $tulokset = null;
        }

        $valtiot = Valtio::all();
        $genret = Genre::all();
        $sarjat = Sarja::all();

        View::make('basis/haku.html', array(
            'valtiot' => $valtiot, 'genret' => $genret,'sarjat' => $sarjat,
            'tulokset' => $tulokset, 'valinnat' => $valinnat, 'kuvanpaikka' => $kuvanpaikka
        ));
    }

}
