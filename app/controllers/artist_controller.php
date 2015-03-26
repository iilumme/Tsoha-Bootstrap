<?php

class ArtistController extends BaseController {

    public static function index() {
        $artistit = Artisti::all();
        Kint::dump($artistit);
        View::make('movie/artistiesittelykokeilu.html', array('artistit' => $artistit));
    }

    public static function showOne($id) {
        $artistit = array();
        $artisti = Artisti::findOne($id);
        $artistit[] = $artisti;

        $valtiot = array();
        $valtio = Artisti::findValtio($id);
        $valtiot[] = $valtio;

        $leffat = array();
        $leffa = Artisti::findElokuvat($id);
        foreach ($leffa as $l) {
            $leffat[] = $l;
        }
        
        View::make('movie/artistiesittelykokeilu.html', array(
            'artistit' => $artistit,
            'valtiot' => $valtiot,
            'elokuvat' => $leffat
        ));
    }

    //KOODIKATSELMOINTI
}
