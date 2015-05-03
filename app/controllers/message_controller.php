<?php

/* Viestien kontrollointi */

class MessageController extends BaseController {


    /* Postilaatikkosivulle tiedot */
    public static function mailbox() {
        $arrived = Viesti::arrived();
        $sent = Viesti::sent();
        $users = Kayttaja::all();
        $coA = Viesti::countOfArrived();
        $coS = Viesti::countOfSent();
        View::make('users/registered_user/postilaatikko.html', array(
            'saapuneet' => $arrived, 'lahetetyt' => $sent,
            'kayttajat' => $users, 'countOfArrived' => $coA,
            'countOfSent' => $coS));
    }

    /* Viesti luetuksi */
    public static function read($viestiid) {
        Viesti::read($viestiid);
        Redirect::to('/mailbox');
    }

    /* Tallennetaan uusi viesti */
    public static function store($location) {
        $params = $_POST;

        $message = new Viesti(array(
            'lahettaja' => $params['lahettaja'],
            'vastaanottaja' => $params['vastaanottaja'],
            'teksti' => $params['teksti']
        ));

        $message->save();

        if ($location == '/userpage/') {
            Redirect::to($location . $params['vastaanottaja']);
        } else {
            Redirect::to($location);
        }
    }

    /* Muokataan viestiä */
    public static function update() {
        $params = $_POST;

        $message = new Viesti(array(
            'viestiid' => $params['viestiid'],
            'vastaanottaja' => $params['vastaanottaja'],
            'teksti' => $params['teksti']
        ));

        $message->update();

        Redirect::to('/mailbox');
    }
    
    /* Poistetaan viesti */
    public static function destroy() {
        $params = $_POST;
        $message = new Viesti(array(
            'viestiid' => $params['viestiid']
        ));

        $message->destroy();
        Redirect::to('/mailbox');
    }
    
    /* Poistetaan kaikki saapuneet/lähetetyt viestit */
    public static function destroyAll() {
        $params = $_POST;

        if ($params['tyyppi'] === 'arrived') {
            Viesti::destroyAllArrived($params['kayttajaid']);
        } elseif ($params['tyyppi'] === 'sent') {
             Viesti::destroyAllSent($params['kayttajaid']);
        }

        Redirect::to('/mailbox');
    }

}
