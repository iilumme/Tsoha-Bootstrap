<?php

class QueryController extends BaseController {

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

    public static function queryAccepted($id) {
        Kyselyehdotus::execute($id);
        Redirect::to('/maintenance', array('message' => 'Kysely onnistui! :)'));
    }

    public static function queryDenied($id) {
        Kyselyehdotus::destroy($id);
        Redirect::to('/maintenance', array('message' => 'Kysely hylätty! :)'));
    }

}
