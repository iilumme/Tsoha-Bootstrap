<?php

/* Eri -Laareihin liittyvien asioiden kontrollointi */

class LaariController extends BaseController {
      
    
    /* REKISTERÖITYNEEN KÄYTTÄJÄN METODIT */
    

    /* Uuden elokuvan artistien, genrejen ja sarjojen ehdotusten tallentaminen */
    public static function storeSuggestion() {
        $param = $_POST;
        $ryhmaid = (int) $param['ryhmaid'];

        LaariController::artistilaariSaveSuggestion($param, $ryhmaid);
        LaariController::genrelaariSaveSuggestion($param, $ryhmaid);

        if (isset($param['sarjalista'])) {
            LaariController::sarjalaariSaveSuggestion($param, $ryhmaid);
        }

        Redirect::to('/', array('message' => "Ehdotus elokuvasta tekijöineen lähetetty ylläpitäjälle :)"));
    }

    /* Uuden elokuvan artistiehdotusten tallentaminen */
    public static function artistilaariSaveSuggestion($param, $ryhmaid) {

        $input = $param['artistilista'];
        $output = explode(',', $input);

        foreach ($output as $artistiid) {
            $artistilaari = new Artistilaari(array(
                'artistiid' => (int) $artistiid,
                'leffaid' => ':leffaid'
            ));
            $artistilaari->saveSuggestion($ryhmaid);
        }
    }

    /* Uuden elokuvan genreehdotusten tallentaminen */
    public static function genrelaariSaveSuggestion($param, $ryhmaid) {

        $input = $param['genrelista'];
        $output = explode(',', $input);

        foreach ($output as $genreid) {
            $genrelaari = new Genrelaari(array(
                'genreid' => (int) $genreid,
                'leffaid' => ':leffaid'
            ));
            $genrelaari->saveSuggestion($ryhmaid);
        }
    }

    /* Uuden elokuvan sarjaehdotusten tallentaminen */
    public static function sarjalaariSaveSuggestion($param, $ryhmaid) {

        $input = $param['sarjalista'];
        $output = explode(',', $input);

        foreach ($output as $sarjaid) {
            $sarjalaari = new Sarjalaari(array(
                'sarjaid' => (int) $sarjaid,
                'leffaid' => ':leffaid'
            ));
            $sarjalaari->saveSuggestion($ryhmaid);
        }
    }

    /* Uuden elokuvan uusien artistiehdotusten tallentaminen */
    public static function artistilaariSaveSuggestionWithoutArtistiID($ryhmaid) {

        $artistilaari = new Artistilaari(array(
            'artistiid' => ':artistiid',
            'leffaid' => ':leffaid'
        ));
        $artistilaari->saveSuggestion($ryhmaid);
    }

    /* Uuden elokuvan uusien genreehdotusten tallentaminen */
    public static function genrelaariSaveSuggestionWithoutGenreID($ryhmaid) {

        $genrelaari = new Genrelaari(array(
            'genreid' => ':genreid',
            'leffaid' => ':leffaid'
        ));
        $genrelaari->saveSuggestion($ryhmaid);
    }

    /* Uuden elokuvan uusien sarjaehdotusten tallentaminen */
    public static function sarjalaariSaveSuggestionWithoutSarjaID($ryhmaid) {

        $sarjalaari = new Sarjalaari(array(
            'sarjaid' => ':sarjaid',
            'leffaid' => ':leffaid'
        ));
        $sarjalaari->saveSuggestion($ryhmaid);
    }

    
    /* YLLÄPITÄJÄN METODIT*/
    
    
    /* Uuden elokuvan artistien, genrejen ja sarjojen tallentaminen - ylläpitäjä tekee */
    public static function administratorStore() {
        $param = $_POST;
        $leffaid = (int) $param['leffaid'];
        
        LaariController::artistilaariSaveAdministrator($param, $leffaid);
        LaariController::genrelaariSaveAdministrator($param, $leffaid);

        if (isset($param['sarjalista'])) {
            LaariController::sarjalaariSaveAdministrator($param, $leffaid);
        }

        Redirect::to('/movie/' . $leffaid, array('message' => "Elokuva kokonaisuudessaan lisätty! :)"));
    }

    /* Uuden elokuvan artistien tallentaminen - ylläpitäjä tekee */
    public static function artistilaariSaveAdministrator($param, $leffaid) {

        $input = $param['artistilista'];
        $output = explode(',', $input);

        foreach ($output as $artistiid) {
            $artistilaari = new Artistilaari(array(
                'artistiid' => (int) $artistiid,
                'leffaid' => $leffaid
            ));
            $artistilaari->save();
        }
    }

    /* Uuden elokuvan genrejen tallentaminen - ylläpitäjä tekee */
    public static function genrelaariSaveAdministrator($param, $leffaid) {

        $input = $param['genrelista'];
        $output = explode(',', $input);

        foreach ($output as $genreid) {
            $genrelaari = new Genrelaari(array(
                'genreid' => (int) $genreid,
                'leffaid' => $leffaid
            ));
            $genrelaari->save();
        }
    }
    
    /* Uuden elokuvan sarjojen tallentaminen - ylläpitäjä tekee */
    public static function sarjalaariSaveAdministrator($param, $leffaid) {

        $input = $param['sarjalista'];
        $output = explode(',', $input);

        foreach ($output as $sarjaid) {
            $sarjalaari = new Sarjalaari(array(
                'sarjaid' => (int) $sarjaid,
                'leffaid' => $leffaid
            ));
            $sarjalaari->save();
        }
    }

}
