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
        View::make('movie/artistiesittelykokeilu.html', array('artistit' => $artistit));
    }

}
