<?php

/* Malli käyttäjän antamalle kommentille */

class Kommentti extends BaseModel {

    public $kayttajaid, $kayttajatunnus, $leffaid, $teksti, $lisatty;

    public function __construct($attribuutit) {
        parent::__construct($attribuutit);
    }

    private static function createKommentti($tulos) {
        return new Kommentti(array(
            'kayttajaid' => $tulos['kayttajaid'],
            'kayttajatunnus' => $tulos['kayttajatunnus'],
            'leffaid' => $tulos['leffaid'],
            'teksti' => $tulos['teksti'],
            'lisatty' => $tulos['lisatty']
        ));
    }

    /* Etsitään elokuvalle kommentit */
    public static function findKommentitForElokuva($leffaid) {
        $query = DB::connection()->prepare('SELECT K.leffaid, K.kayttajaid, K.lisatty, K.teksti, T.kayttajatunnus '
                . 'FROM Kommentti K, Kayttaja T, Elokuva E '
                . 'WHERE K.kayttajaid=T.kayttajaid AND K.leffaid=E.leffaid AND E.leffaid= :leffaid');
        $query->execute(array('leffaid' => $leffaid));
        $tulokset = $query->fetchAll();

        $kommentit = array();
        foreach ($tulokset as $tulos) {
            $kommentit[] = Kommentti::createKommentti($tulos);
        }
        return $kommentit;
    }

    /* Etsitään tietty kommentti */
    public static function findOne($kayttajaid, $leffaid) {
        $query = DB::connection()->prepare('SELECT K.leffaid, K.kayttajaid, K.lisatty, K.teksti, T.kayttajatunnus '
                . 'FROM Kommentti K, Kayttaja T '
                . 'WHERE K.kayttajaid=T.kayttajaid AND K.leffaid=E.leffaid '
                . 'AND E.leffaid= :leffaid AND K.kayttajaid= :kayttajaid LIMIT 1');
        $query->execute(array('kayttajaid' => $kayttajaid, 'leffaid' => $leffaid));
        $tulos = $query->fetch();

        if ($tulos) {
            $kommentti = Kommentti::createKommentti($tulos);
            return $kommentti;
        }

        return null;
    }
    
    /* Lisätään kommentti */
    public static function addCommentForMovie($leffaid, $kommentti) {
        $query = DB::connection()->prepare('INSERT INTO Kommentti (kayttajaID, leffaID, teksti, lisatty) '
                . 'VALUES (:kayttajaid, :leffaid, :kommentti, NOW())');
        $query->execute(array('kayttajaid' => BaseController::get_user_logged_in()->kayttajaid,
            'leffaid' => $leffaid, 'kommentti' => $kommentti));
    }

    /* Poistetaan kommentti */
    public static function deleteCommentFromMovie($leffaid) {
        $query = DB::connection()->prepare('DELETE FROM Kommentti '
                . 'WHERE leffaID = :leffaid AND kayttajaID = :kayttajaid');
        $query->execute(array('kayttajaid' => BaseController::get_user_logged_in()->kayttajaid,
            'leffaid' => $leffaid));
    }

    /* Onko jo kommentoinut elokuvaa? */
    public static function hasCommented($leffaid) {
        $query = DB::connection()->prepare('SELECT K.kayttajaID, K.kayttajaTunnus, leffaID, teksti, O.lisatty '
                . 'FROM Kommentti O, Kayttaja K '
                . 'WHERE O.kayttajaID = K.kayttajaID AND leffaid = :leffaid AND K.kayttajaID = :kayttajaid');
        $query->execute(array('leffaid' => $leffaid,
            'kayttajaid' => BaseController::get_user_logged_in()->kayttajaid));
        $tulos = $query->fetch();

        if ($tulos) {
            return $tulos['teksti'];
        }
        return 0;
    }

}
