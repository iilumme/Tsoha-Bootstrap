<?php

/* Sarjojen kontrolloiminen */

class SarjaController extends BaseController {
    
    
    /* REKISTERÖITYNEEN KÄYTTÄJÄN METODI */
    
    /* Uuden sarjaehdotuksen tallentaminen */
    public static function storeSuggestion($ryhmaid) {
        $param = $_POST;
        $sarja = new Sarja(array('sarjanimi' => $param['sarjanimi']));

        $sarja->saveSuggestion($ryhmaid);
        LaariController::sarjalaariSaveSuggestionWithoutSarjaID($ryhmaid);
    }
    
    
    
    /* YLLÄPITÄJÄN METODIT*/

    /* Uuden sarjan tallentaminen */
    public static function administratorStore($leffaid) {
        $param = $_POST;
        $sarja = new Sarja(array('sarjanimi' => $param['sarjanimi']));

        $id = $sarja->save();
        $param['sarjalista'] = $id;
        LaariController::sarjalaariSaveAdministrator($param, $leffaid);
    }

}
