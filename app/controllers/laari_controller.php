<?php

class LaariController extends BaseController {

    public static function store() {
        $param = $_POST;
        $leffaid = (int) $param['leffaid'];

        LaariController::artistilaariSave($param, $leffaid);
        LaariController::genrelaariSave($param, $leffaid);

        if (isset($param['sarjalista'])) {
            LaariController::sarjalaariSave($param, $leffaid);
        }

        Redirect::to('/movie/' . $leffaid, array('message' => "Elokuva kokonaisuudessaan lisätty! :)"));
    }

    public static function artistilaariSave($param, $leffaid) {

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

    public static function genrelaariSave($param, $leffaid) {

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

    public static function sarjalaariSave($param, $leffaid) {

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
