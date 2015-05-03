<?php

/* Haun kontrolleri */

class SearchController extends BaseController {

    /* Hakusivu ja hakeminen */
    public static function searchpage() {

        $params = $_GET;
        $timeOfPicture = 0;
        $options = array();

        if (isset($params['nayttelijalista']) && $params['nayttelijalista'][0] !== '') {
            $input = $params['nayttelijalista'][0];
            $output = explode(',', $input);

            foreach ($output as $n) {
                $options['nayttelijalista'][] = $n;
            }
        }
        if (isset($params['ohjaajalista']) && $params['ohjaajalista'][0] !== '') {
            $input = $params['ohjaajalista'][0];
            $output = explode(',', $input);

            foreach ($output as $n) {
                $options['ohjaajalista'][] = $n;
            }
        }
        if (isset($params['kuvaajalista']) && $params['kuvaajalista'][0] !== '') {
            $input = $params['kuvaajalista'][0];
            $output = explode(',', $input);
            foreach ($output as $n) {
                $options['kuvaajalista'][] = $n;
            }
        }
        if (isset($params['kasikirjoittajalista']) && $params['kasikirjoittajalista'][0] !== '') {
            $input = $params['kasikirjoittajalista'][0];
            $output = explode(',', $input);
            foreach ($output as $n) {
                $options['kasikirjoittajalista'][] = $n;
            }
        }
        if (isset($params['valtio']) && $params['valtio'] !== '...') {
            $options['valtio'] = (int) $params['valtio'];
        }
        if (isset($params['alkuvuosi']) && $params['alkuvuosi'] !== '') {
            $options['alkuvuosi'] = (int) $params['alkuvuosi'];
        }
        if (isset($params['loppuvuosi']) && $params['loppuvuosi'] !== '') {
            $options['loppuvuosi'] = (int) $params['loppuvuosi'];
        }
        if (isset($params['kieli']) && $params['kieli'] !== '') {
            $options['kieli'] = $params['kieli'];
        }
        if (isset($params['genre']) && $params['genre'] !== '...') {
            $options['genre'] = (int) $params['genre'];
        }
        if (isset($params['sarja']) && $params['sarja'] !== '...') {
            $options['sarja'] = (int) $params['sarja'];
        }


        if (sizeof($options) > 0) {
            $results = Elokuva::search($options);
            if (sizeof($results) === 0) {
                $timeOfPicture = 1;
            }
        } else {
            $results = null;
        }

        $valtiot = Valtio::all();
        $genret = Genre::all();
        $sarjat = Sarja::all();

        View::make('basis/haku.html', array(
            'valtiot' => $valtiot, 'genret' => $genret,'sarjat' => $sarjat,
            'tulokset' => $results, 'valinnat' => $options, 'kuvanpaikka' => $timeOfPicture
        ));
    }

}
