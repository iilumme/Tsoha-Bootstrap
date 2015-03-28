<?php

class MovieController extends BaseController {

    public static function showOne($id) {

        $elokuvat = Elokuva::findOne($id);
        $valtiot = Valtio::findValtioForElokuva($id);
        $nayttelijat = Artisti::findArtistitForElokuva($id, "Nayttelija");
        $ohjaajat = Artisti::findArtistitForElokuva($id, "Ohjaaja");
        $kuvaajat = Artisti::findArtistitForElokuva($id, "Kuvaaja");
        $kassarit = Artisti::findArtistitForElokuva($id, "Kasikirjoittaja");
        $genret = Genre::findGenretForElokuva($id);
        $palkinnot = Palkinto::findPalkinnotForElokuva($id);
        $arviot = Arviolaari::findArviotForElokuva($id);
        $dvdt = Lista::findDVDTForElokuva($id);

        View::make('movie/leffaetusivu.html', array(
            'elokuvat' => $elokuvat, 'valtiot' => $valtiot,
            'nayttelijat' => $nayttelijat, 'ohjaajat' => $ohjaajat,
            'kuvaajat' => $kuvaajat, 'kasikirjoittajat' => $kassarit,
            'genret' => $genret, 'palkinnot' => $palkinnot,
            'arviot' => $arviot, 'dvdt' => $dvdt
        ));
    }

    public static function add_movie() {
        $valtiot = Valtio::all();
        View::make('movie/leffalisays.html', array('valtiot' => $valtiot));
    }

    public static function add_artistit() {
        $nayttelijat = Artisti::findAllArtistit("Nayttelija");
        $ohjaajat = Artisti::findAllArtistit("Ohjaaja");
        $kuvaajat = Artisti::findAllArtistit("Kuvaaja");
        $kassarit = Artisti::findAllArtistit("Kasikirjoittaja");
        $genret = Genre::all();
        $sarjat = Sarja::all();
        $valtiot = Valtio::all();
        View::make('movie/leffalisaysihmiset.html', array(
            'nayttelijat' => $nayttelijat,
            'ohjaajat' => $ohjaajat,
            'kuvaajat' => $kuvaajat,
            'kasikirjoittajat' => $kassarit,
            'genret' => $genret,
            'sarjat' => $sarjat,
            'valtiot' => $valtiot
        ));
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

        Redirect::to('/addmovie/addpeople' , array('message' => $movie->leffaid));
    }

}
