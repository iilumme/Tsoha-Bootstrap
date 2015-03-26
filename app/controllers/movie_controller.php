<?php

class MovieController extends BaseController {

    public static function index() {
        $elokuvat = Elokuva::all();
        View::make('movie/leffaetusivukokeilu.html', array('elokuvat' => $elokuvat));
    }

    public static function showOne($id) {
        $elokuvat = array();
        $elokuva = Elokuva::findOne($id);
        $elokuvat[] = $elokuva;

        $valtiot = array();
        $valtio = Elokuva::findValtio($id);
        $valtiot[] = $valtio;

        $nayttelijat = array();
        $nay = Elokuva::findArtistit($id, "Nayttelija");
        foreach ($nay as $n) {
            $nayttelijat[] = $n;
        }

        $ohjaajat = array();
        $ohj = Elokuva::findArtistit($id, "Ohjaaja");
        foreach ($ohj as $o) {
            $ohjaajat[] = $o;
        }

        $kuvaajat = array();
        $kuv = Elokuva::findArtistit($id, "Kuvaaja");
        foreach ($kuv as $k) {
            $kuvaajat[] = $k;
        }

        $kassarit = array();
        $kas = Elokuva::findArtistit($id, "Kasikirjoittaja");
        foreach ($kas as $ka) {
            $kassarit[] = $ka;
        }
        
        $genret = array();
        $gen = Elokuva::findGenret($id);
        foreach ($gen as $g) {
            $genret[] = $g;
        }
        
        $palkinnot = array();
        $pal = Elokuva::findPalkinnot($id);
        foreach ($pal as $p) {
            $palkinnot[] = $p;
        }
        
        $arviot = array();
        $arv = Elokuva::findArviot($id);
        foreach ($arv as $a) {
            $arviot[] = $a;
        }
        
        $dvdt = array();
        $dvd = Lista::find($id);
        foreach ($dvd as $d) {
            $dvdt[] = $d;
        }
        

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

}
