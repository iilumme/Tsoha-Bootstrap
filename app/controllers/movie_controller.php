<?php

class MovieController extends BaseController {

    public static function index() {
        $elokuvat = Elokuva::all();
        View::make('movie/leffaetusivukokeilu.html', array('elokuvat' => $elokuvat));
    }

    public static function showOne($id) {

        $elokuvat = Elokuva::findOne($id);
        $valtiot = Valtio::findValtio($id);
        $nayttelijat = Artisti::findArtistitForElokuva($id, "Nayttelija");
        $ohjaajat = Artisti::findArtistitForElokuva($id, "Ohjaaja");
        $kuvaajat = Artisti::findArtistitForElokuva($id, "Kuvaaja");
        $kassarit = Artisti::findArtistitForElokuva($id, "Kasikirjoittaja");
        $genret = Genre::findGenretForElokuva($id);
        $palkinnot = Palkinto::findPalkinnotForElokuva($id);
        $arviot = Arviolaari::findArviotForElokuva($id);
        $dvdt = Lista::findDVDTForElokuva($id);

        View::make('movie/leffaetusivukokeilu.html', array(
            'elokuvat' => $elokuvat,
            'valtiot' => $valtiot,
            'nayttelijat' => $nayttelijat,
            'ohjaajat' => $ohjaajat,
            'kuvaajat' => $kuvaajat,
            'kasikirjoittajat' => $kassarit,
            'genret' => $genret,
            'palkinnot' => $palkinnot,
            'arviot' => $arviot,
            'dvdt' => $dvdt
        ));
    }

    public static function addpage() {
        $valtiot = Valtio::all();
        View::make('movie/leffalisayskokeilu.html', array('valtiot' => $valtiot));
    }

    public static function addArstistit() {
        $valtiot = Artisti::findArtistit($n);
        View::make('movie/leffalisayskokeilu.html', array('valtiot' => $valtiot));
    }

    public static function store() {
        $parametrit = $_POST;

        $movie = new Elokuva(array(
            'leffanimi' => $parametrit['leffanimi'],
            'vuosi' => $parametrit['vuosi'],
            'valtio' => $parametrit['valtio'],
            'kieli' => $parametrit['kieli'],
            'synopsis' => $parametrit['synopsis'],
            'traileriurl' => $parametrit['traileriurl']
        ));

        $movie->save();

        Kint::dump($parametrit);

        Redirect::to('/movie/' . $movie->leffaid, array('message' => 'done'));
    }

}
