<?php

class LaariController extends BaseController {

    public static function store() {
        $param = $_POST;
        $leffaid = (int) $param['elokuvanid'];

        LaariController::artistilaariSave($param, $leffaid);
        LaariController::genrelaariSave($param, $leffaid);

        if (isset($param['sarjalista'])) {
            LaariController::sarjalaariSave($param, $leffaid);
        }

        Redirect::to('/movie/' . $leffaid, array('message' => "Elokuva lisätty!"));
    }

    private static function artistilaariSave($param, $leffaid) {

        $input = $param['artistilista'];
        $output = array();
        $output = explode(',', $input);

        foreach ($output as $artistiid) {
            $artistilaari = new Artistilaari(array(
                'artistiid' => (int) $artistiid,
                'leffaid' => $leffaid
            ));

            $artistilaari->save();
        }
    }

    private static function genrelaariSave($param, $leffaid) {

        $genreinput = $param['genrelista'];
        $genreoutput = array();
        $genreoutput = explode(',', $genreinput);

        foreach ($genreoutput as $genreid) {
            $genrelaari = new Genrelaari(array(
                'genreid' => (int) $genreid,
                'leffaid' => $leffaid
            ));

            $genrelaari->save();
        }
    }

    private static function sarjalaariSave($param, $leffaid) {

        $sarjainput = $param['sarjalista'];
        $sarjaoutput = array();
        $sarjaoutput = explode(',', $sarjainput);

        foreach ($sarjaoutput as $sarjaid) {
            $sarjalaari = new Sarjalaari(array(
                'sarjaid' => (int) $sarjaid,
                'leffaid' => $leffaid
            ));

            $sarjalaari->save();
        }
    }

}
