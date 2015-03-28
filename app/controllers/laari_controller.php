<?php

class LaariController extends BaseController {

    public static function store() {
        $param = $_POST;

        $leffaid = (int) $param['elokuvanid'];

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

        Redirect::to('/movie/' . $leffaid, array('message' => "Elokuva lisätty!"));
    }

}
