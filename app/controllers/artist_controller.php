<?php

class ArtistController extends BaseController {

    public static function index() {
        $artistit = Artisti::all();
        View::make('movie/artistiesittelykokeilu.html', array('artistit' => $artistit));
    }

    public static function showOne($id) {
        $artistit = Artisti::findOne($id);
        View::make('movie/artistiesittelykokeilu.html', array('artistit' => $artistit));
    }

}
