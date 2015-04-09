<?php

class SarjaController extends BaseController {

    public static function store($leffaid) {
        $param = $_POST;

        $sarja = new Sarja(array(
            'sarjanimi' => $param['sarjanimi']
        ));

        $id = $sarja->save();
        $param['sarjalista'] = $id;
        LaariController::sarjalaariSave($param, $leffaid);
    }

}
