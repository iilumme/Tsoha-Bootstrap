<?php

class SearchController extends BaseController {

    public static function search() {
        $valtiot = Valtio::all();
        $genret = Genre::all();
        $palkinnot = Palkinto::all();
        $sarjat = Sarja::all();
        View::make('basis/haku.html', array(
            'valtiot' => $valtiot,
            'genret' => $genret,
            'palkinnot' => $palkinnot,
            'sarjat' => $sarjat
        ));
    }

}
