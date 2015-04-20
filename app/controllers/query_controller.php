<?php

/* Kontrolleri kyselyehdotuksille ja -ryhmille */

class QueryController extends BaseController {

    
    /* Ylläpito-sivulle tiedot */
    public static function queryMaintenancePage() {

        $ryhmat = Kyselyryhma::allGroups();
        $ryhmatAndKyselyt = array();
        foreach ($ryhmat as $ryhma) {
            $kyselyryhmat = array();
            $kyselyryhmat['ryhmaid'] = $ryhma->ryhmaid;
            $ryhmankyselyt = Kyselyehdotus::allGroup_s_queries($ryhma->ryhmaid);
            $kyselyryhmat[] = $ryhmankyselyt;
            $ryhmatAndKyselyt[] = $kyselyryhmat;
        }

        View::make('users/administrator/kyselyjenyllapito.html', array('ryhmat' => $ryhmatAndKyselyt));
    }

    /* Kyselyjen suorittaminen */
    public static function queryAccepted($ryhmaid) {
        Kyselyryhma::execute($ryhmaid);
        Redirect::to('/querymaintenance', array('message' => 'Kysely onnistui! :)'));
    }

    /* Kyselyjen poistaminen */
    public static function queryDenied($ryhmaid) {
        Kyselyryhma::destroy($ryhmaid);
        Redirect::to('/querymaintenance', array('message' => 'Kysely hylätty ja poistettu! :)'));
    }

}
