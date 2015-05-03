<?php

/* Sarjojen kontrolloiminen */

class SarjaController extends BaseController {
    
    
    /* REKISTERÖITYNEEN KÄYTTÄJÄN METODI */
    
    /* Uuden sarjaehdotuksen tallentaminen */
    public static function storeSuggestion($ryhmaid) {
        $params = $_POST;
        $serie = new Sarja(array('sarjanimi' => $params['sarjanimi']));

        $serie->saveSuggestion($ryhmaid);
        LaariController::sarjalaariSaveSuggestionWithoutSarjaID($ryhmaid);
    }
    
    /* Uuden sarjaehdotuksen tallentaminen, elokuvan muokkauksen yhteydessä */
    public static function storeSuggestionWithLeffaID($leffaid) {
        $params = $_POST;
        $serie = new Sarja(array('sarjanimi' => $params['sarjanimi']));

        $ryhmaid = $serie->saveSuggestionOwnGroup();
        LaariController::sarjalaariSaveSuggestionWithoutSarjaIDWithLeffaID($leffaid, $ryhmaid);
    }
    
    
    /* YLLÄPITÄJÄN METODIT*/

    /* Uuden sarjan tallentaminen */
    public static function administratorStore($leffaid) {
        $params = $_POST;
        $serie = new Sarja(array('sarjanimi' => $params['sarjanimi']));

        $sarjaid = $serie->save();
        $params['sarjalista'] = $sarjaid;
        LaariController::sarjalaariSaveAdministrator($params, $leffaid);
    }
    
    /* Sarjan poistaminen ylläpitosivulla */
    public static function destroyMaintenance($sarjaid) {
        $serie = new Sarja(array('sarjaid' => $sarjaid));
        $serie->destroy();
        Redirect::to('/seriemaintenance', array('message' => 'Sarjan poistaminen onnistui'));
    }

}
