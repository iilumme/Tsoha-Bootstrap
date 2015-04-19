<?php

class SarjaController extends BaseController {

    public static function store($ryhmaid) {
        $param = $_POST;
        $sarja = new Sarja(array('sarjanimi' => $param['sarjanimi']));

        $sarja->saveSuggestion($ryhmaid);
        LaariController::sarjalaariSaveWithoutID($ryhmaid);
    }

    public static function adminStore($leffaid) {
        $param = $_POST;
        $sarja = new Sarja(array('sarjanimi' => $param['sarjanimi']));

        $id = $sarja->save();
        $param['sarjalista'] = $id;
        LaariController::sarjalaariSave($param, $leffaid);
    }

}
