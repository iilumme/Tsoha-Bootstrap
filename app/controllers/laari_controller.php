<?php

class LaariController extends BaseController {

    public static function store() {
        $param = $_POST;
        $ryhmaid = (int) $param['ryhmaid'];

        LaariController::artistilaariSave($param, $ryhmaid);
        LaariController::genrelaariSave($param, $ryhmaid);

        if (isset($param['sarjalista'])) {
            LaariController::sarjalaariSave($param, $ryhmaid);
        }

        Redirect::to('/', array('message' => "Ehdotus elokuvasta tekijöineen lähetetty ylläpitäjälle :)"));
    }

    public static function artistilaariSave($param, $ryhmaid) {

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

    public static function genrelaariSave($param, $ryhmaid) {

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

    public static function sarjalaariSave($param, $ryhmaid) {

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

    public static function artistilaariSaveWithoutID($ryhmaid) {

        $artistilaari = new Artistilaari(array(
            'artistiid' => ':artistiid',
            'leffaid' => ':leffaid'
        ));
        $artistilaari->saveSuggestion($ryhmaid);
    }

    public static function genrelaariSaveWithoutID($ryhmaid) {

        $genrelaari = new Genrelaari(array(
            'genreid' => ':genreid',
            'leffaid' => ':leffaid'
        ));
        $genrelaari->saveSuggestion($ryhmaid);
    }

    public static function sarjalaariSaveWithoutID($ryhmaid) {

        $sarjalaari = new Sarjalaari(array(
            'sarjaid' => ':sarjaid',
            'leffaid' => ':leffaid'
        ));
        $sarjalaari->saveSuggestion($ryhmaid);
    }

    public static function adminStore() {
        $param = $_POST;
        $leffaid = (int) $param['leffaid'];
        
        LaariController::artistilaariSaveAdmin($param, $leffaid);
        LaariController::genrelaariSaveAdmin($param, $leffaid);

        if (isset($param['sarjalista'])) {
            LaariController::sarjalaariSaveAdmin($param, $leffaid);
        }

        Redirect::to('/movie/' . $leffaid, array('message' => "Elokuva kokonaisuudessaan lisätty! :)" . $leffaid));
    }

    public static function artistilaariSaveAdmin($param, $leffaid) {

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

    public static function genrelaariSaveAdmin($param, $leffaid) {

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

    public static function sarjalaariSaveAdmin($param, $leffaid) {

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
