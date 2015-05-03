<?php

/* Viestien kontrollointi */

class MessageController extends BaseController {


    public static function mailbox() {
        $saapuneet = Viesti::arrived();
        $lahetetyt = Viesti::sent();
        $kayttajat = Kayttaja::all();
        $coA = Viesti::countOfArrived();
        $coS = Viesti::countOfSent();
        View::make('users/registered_user/postilaatikko.html', array(
            'saapuneet' => $saapuneet, 'lahetetyt' => $lahetetyt,
            'kayttajat' => $kayttajat, 'countOfArrived' => $coA,
            'countOfSent' => $coS));
    }

    public static function read($viestiid) {
        Viesti::read($viestiid);
        Redirect::to('/mailbox');
    }

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
    
    public static function destroy() {
        $params = $_POST;

        $message = new Viesti(array(
            'viestiid' => $params['viestiid']
        ));

        $message->destroy();

        Redirect::to('/mailbox');
    }
    
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
