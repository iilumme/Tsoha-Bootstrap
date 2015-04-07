<?php

class SarjaController extends BaseController {

    public static function store() {
        $param = $_POST;

        $sarja = new Sarja(array(
            'sarjanimi' => $param['sarjanimi']
        ));

        $sarja->save();
    }

}
