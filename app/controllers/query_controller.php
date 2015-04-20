<?php

/* Kontrolleri kyselyehdotuksille ja -ryhmille */

class QueryController extends BaseController {

    
    /* Ylläpito-sivulle tiedot */
    public static function maintenance() {

        $ryhmat = Kyselyryhma::allGroups();
        $ryhmatALL = array();
        foreach ($ryhmat as $ryhma) {
            $kyselyryhmat = array();
            $kyselyryhmat['ryhmaid'] = $ryhma->ryhmaid;
            $ryhmankyselyt = Kyselyehdotus::allGroup_s_queries($ryhma->ryhmaid);
            $kyselyryhmat[] = $ryhmankyselyt;
            $ryhmatALL[] = $kyselyryhmat;
        }

        View::make('users/administrator/yllapito.html', array('ryhmat' => $ryhmatALL));
    }

    /* Kyselyjen suorittaminen */
    public static function queryAccepted($ryhmaid) {
        Kyselyryhma::execute($ryhmaid);
        Redirect::to('/maintenance', array('message' => 'Kysely onnistui! :)'));
    }

    /* Kyselyjen poistaminen */
    public static function queryDenied($ryhmaid) {
        Kyselyryhma::destroy($ryhmaid);
        Redirect::to('/maintenance', array('message' => 'Kysely hylätty ja poistettu! :)'));
    }

}
