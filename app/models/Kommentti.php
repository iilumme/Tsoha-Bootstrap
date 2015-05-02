<?php

/* Malli käyttäjän antamalle kommentille */

class Kommentti extends BaseModel {

    public $kayttajaid, $kayttajatunnus, $leffaid, $teksti, $lisatty;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    private static function createKommentti($row) {
        return new Kommentti(array(
            'kayttajaid' => $row['kayttajaid'],
            'kayttajatunnus' => $row['kayttajatunnus'],
            'leffaid' => $row['leffaid'],
            'teksti' => $row['teksti'],
            'lisatty' => $row['lisatty']
        ));
    }
    
    /* Haetaan kaikki kommentit */
    public static function all() {
        $query = DB::connection()->prepare('SELECT K.leffaid, K.kayttajaid, K.lisatty, K.teksti, T.kayttajatunnus '
                . 'FROM Kommentti K, Kayttaja T '
                . 'WHERE K.kayttajaid = T.kayttajaid');
        $query->execute();
        $rows = $query->fetchAll();

        $kommentit = array();

        foreach ($rows as $row) {
            $kommentit[] = Kommentti::createKommentti($row);
        }
        return $kommentit;
    }

    /* Etsitään elokuvalle kommentit */
    public static function findKommentitForElokuva($leffaid) {
        $query = DB::connection()->prepare('SELECT K.leffaid, K.kayttajaid, K.lisatty, K.teksti, T.kayttajatunnus '
                . 'FROM Kommentti K, Kayttaja T, Elokuva E '
                . 'WHERE K.kayttajaid=T.kayttajaid AND K.leffaid=E.leffaid AND E.leffaid= :leffaid');
        $query->execute(array('leffaid' => $leffaid));
        $rows = $query->fetchAll();

        $kommentit = array();
        foreach ($rows as $row) {
            $kommentit[] = Kommentti::createKommentti($row);
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
        $row = $query->fetch();

        if ($row) {
            $kommentti = Kommentti::createKommentti($row);
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
        $row = $query->fetch();

        if ($row) {
            return $row['teksti'];
        }
        return 0;
    }

    /* Kommentin poistaminen - ylläpitäjä tekee */
    public function destroy() {
        $query = DB::connection()->prepare('DELETE FROM Kommentti '
                . 'WHERE leffaid = :leffaid AND kayttajaid = :kayttajaid');
        $query->execute(array('leffaid' => $this->leffaid, 'kayttajaid' => $this->kayttajaid));
    }
}
