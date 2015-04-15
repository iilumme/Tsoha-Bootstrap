<?php

class MovieController extends BaseController {

    public static function showOne($id) {

        $elokuva = Elokuva::findOne($id);
        $valtio = Valtio::findValtioForElokuva($id);
        $nayttelijat = Artisti::findArtistitForElokuva($id, "Näyttelijä");
        $ohjaajat = Artisti::findArtistitForElokuva($id, "Ohjaaja");
        $kuvaajat = Artisti::findArtistitForElokuva($id, "Kuvaaja");
        $kassarit = Artisti::findArtistitForElokuva($id, "Käsikirjoittaja");
        $genret = Genre::findGenretForElokuva($id);
        $palkinnot = Palkinto::findPalkinnotForElokuva($id);
        $sarjanelokuvat = Sarjalaari::findSarjanElokuvat($id);
        $arviot = Arviolaari::findArviotForElokuva($id);
        $kommentit = Kommentti::findKommentitForElokuva($id);
        $dvdt = DVDlista::findDVDTForElokuva($id);

        View::make('movie/leffaetusivu.html', array(
            'elokuva' => $elokuva, 'valtio' => $valtio,
            'nayttelijat' => $nayttelijat, 'ohjaajat' => $ohjaajat,
            'kuvaajat' => $kuvaajat, 'kasikirjoittajat' => $kassarit,
            'genret' => $genret, 'palkinnot' => $palkinnot, 'arviot' => $arviot,
            'kommentit' => $kommentit, 'dvdt' => $dvdt, 'sarjanelokuvat' => $sarjanelokuvat
        ));
    }

    public static function addmoviepage() {
        $valtiot = Valtio::all();
        View::make('movie/leffalisays.html', array('valtiot' => $valtiot));
    }

    public static function addartistspage() {
        $nayttelijat = Artisti::findAllArtistit("Näyttelijä");
        $ohjaajat = Artisti::findAllArtistit("Ohjaaja");
        $kuvaajat = Artisti::findAllArtistit("Kuvaaja");
        $kassarit = Artisti::findAllArtistit("Käsikirjoittaja");
        $genret = Genre::all();
        $sarjat = Sarja::all();
        $valtiot = Valtio::all();
        View::make('movie/leffalisaysihmiset.html', array(
            'nayttelijat' => $nayttelijat, 'ohjaajat' => $ohjaajat,
            'kuvaajat' => $kuvaajat, 'kasikirjoittajat' => $kassarit,
            'genret' => $genret, 'sarjat' => $sarjat,
            'valtiot' => $valtiot
        ));
    }

    public static function movieeditpage($id) {
        $elokuva = Elokuva::findOne($id);
        $valtiot = Valtio::all();
        $tamanhetkinenvaltio = Valtio::findValtioForElokuva($id)->valtioid;
        $nayttelijat = Artisti::findArtistitForElokuva($id, "Näyttelijä");
        $ohjaajat = Artisti::findArtistitForElokuva($id, "Ohjaaja");
        $kuvaajat = Artisti::findArtistitForElokuva($id, "Kuvaaja");
        $kassarit = Artisti::findArtistitForElokuva($id, "Käsikirjoittaja");
        $genret = Genre::findGenretForElokuva($id);
        $palkinnot = Palkinto::findPalkinnotForElokuva($id);

        View::make('movie/leffamuokkaus.html', array(
            'elokuva' => $elokuva, 'valtiot' => $valtiot,
            'nayttelijat' => $nayttelijat, 'ohjaajat' => $ohjaajat,
            'kuvaajat' => $kuvaajat, 'kasikirjoittajat' => $kassarit,
            'genret' => $genret, 'palkinnot' => $palkinnot,
            'tamanhetkinenvaltio' => $tamanhetkinenvaltio
        ));
    }

    public static function update($id) {
        $parametrit = $_POST;
        $attribuutit = array(
            'leffaid' => $id, 'leffanimi' => $parametrit['leffanimi'], 'vuosi' => $parametrit['vuosi'],
            'valtio' => $parametrit['valtio'], 'kieli' => $parametrit['kieli'],
            'synopsis' => $parametrit['synopsis'], 'traileriurl' => $parametrit['traileriurl']
        );

        $movie = new Elokuva($attribuutit);
        $errors = $movie->errors();

        if (count($errors) == 0) {
            $movie->update();
            Redirect::to('/movie/' . $id, array('message' => 'Tietojen päivittäminen onnistui! :)'));
        } else {
            $valtiot = Valtio::all();
            $nayttelijat = Artisti::findArtistitForElokuva($id, "Näyttelijä");
            $ohjaajat = Artisti::findArtistitForElokuva($id, "Ohjaaja");
            $kuvaajat = Artisti::findArtistitForElokuva($id, "Kuvaaja");
            $kassarit = Artisti::findArtistitForElokuva($id, "Käsikirjoittaja");
            $genret = Genre::findGenretForElokuva($id);
            $palkinnot = Palkinto::findPalkinnotForElokuva($id);
            $tamanhetkinenvaltio = $attribuutit['valtio'];

            View::make('/movie/leffamuokkaus.html', array(
                'valtiot' => $valtiot, 'tamanhetkinenvaltio' => $tamanhetkinenvaltio,
                'nayttelijat' => $nayttelijat, 'ohjaajat' => $ohjaajat, 'kuvaajat' => $kuvaajat,
                'kasikirjoittajat' => $kassarit, 'genret' => $genret, 'palkinnot' => $palkinnot,
                'errors' => $errors, 'elokuva' => $attribuutit
            ));
        }
    }

    public static function store() {
        $parametrit = $_POST;

        $attribuutit = array(
            'leffanimi' => $parametrit['leffanimi'],
            'vuosi' => $parametrit['vuosi'],
            'valtio' => $parametrit['valtio'],
            'kieli' => $parametrit['kieli'],
            'synopsis' => $parametrit['synopsis'],
            'traileriurl' => $parametrit['traileriurl']
        );

        $movie = new Elokuva($attribuutit);
        $errors = $movie->errors();

        if (count($errors) == 0) {
            $movie->save();
            Redirect::to('/addmovie/addpeople', array('message' => 'Elokuvan tiedot lisätty onnistuneesti', 'lid' => $movie->leffaid));
        } else {
            $valtiot = Valtio::all();
            View::make('/movie/leffalisays.html', array('errors' => $errors, 'attribuutit' => $attribuutit, 'valtiot' => $valtiot));
        }
    }

    public static function destroy($id) {
        $movie = new Elokuva(array('leffaid' => $id));
        $movie->destroy($id);
        Redirect::to('/', array('message' => 'Elokuvan poistaminen onnistui'));
    }

}
