<?php

/* Kontrolleri kyselyehdotuksille ja -ryhmille */

class QueryController extends BaseController {

    
    /* Ylläpito-sivulle tiedot */
    public static function queryMaintenancePage() {

        $groups = Kyselyryhma::allGroups();
        $groupsAndQueries = array();
        foreach ($groups as $group) {
            $querygroup = array();
            $querygroup['ryhmaid'] = $group->ryhmaid;
            $queriesOfGroup = Kyselyehdotus::allGroup_s_queries($group->ryhmaid);
            $querygroup[] = $queriesOfGroup;
            $groupsAndQueries[] = $querygroup;
        }

        View::make('users/administrator/kyselyjenyllapito.html', array('ryhmat' => $groupsAndQueries));
    }
    
    /* Tietojen lisäyssivu */
    public static function queryAddPage() {
        View::make('users/administrator/tietojenlisays.html');
    }
    
    /* Tietojen lisäys */
    public static function addQuery() {
        
        $params = $_POST;
        
        $queryGroup = new Kyselyryhma(array());
        $ryhmaid = $queryGroup->save();
        $query = new Kyselyehdotus(array('kysely' => $params['kysely']));
        $query->save();
        Kyselyryhma::saveToLaari($ryhmaid, $query->kyselyid);      
        Kyselyryhma::execute($ryhmaid);
        
        Redirect::to('/addquery', array('message' => 'Onnistui! :)'));
    }


    /* Kyselyjen suorittaminen */
    public static function queryAccepted($ryhmaid) {
        Kyselyryhma::execute($ryhmaid);
        Redirect::to('/querymaintenance', array('successMessage' => 'Kysely onnistui! :)'));
    }

    /* Kyselyjen poistaminen */
    public static function queryDenied($ryhmaid) {
        Kyselyryhma::destroy($ryhmaid);
        Redirect::to('/querymaintenance', array('deleteMessage' => 'Kysely hylätty ja poistettu! :)'));
    }

}
