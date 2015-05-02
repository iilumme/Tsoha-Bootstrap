<?php

/* Malli katsotutlistalle */

class Katsotutlista extends BaseModel {

    public $kayttajaid, $leffaid;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    /* Tallennetaan käyttäjän listalle uusi elokuva */
    public function save($kayttajaid, $leffaid) {
        $query = DB::connection()->prepare('INSERT INTO Katsotutlista VALUES (:kayttajaid, :leffaid)');
        $query->execute(array('kayttajaid' => $kayttajaid, 'leffaid' => $leffaid));
    }

    /* Poistetaan käyttäjän listalta elokuva */
    public static function destroy($kayttajaid, $leffaid) {
        $query = DB::connection()->prepare('DELETE FROM Katsotutlista '
                . 'WHERE kayttajaID = :kayttajaid AND leffaID = :leffaid');
        $query->execute(array('kayttajaid' => $kayttajaid, 'leffaid' => $leffaid));
    }

    /* Onko elokuva jo katsotutlistassa? */
    public static function isWatched($leffaid) {
        $query = DB::connection()->prepare('SELECT * FROM Katsotutlista '
                . 'WHERE kayttajaID = :kayttajaid AND leffaID = :leffaid');
        $query->execute(array(
            'kayttajaid' => BaseController::get_user_logged_in()->kayttajaid,
            'leffaid' => $leffaid
        ));
        $row = $query->fetch();

        if ($row) {
            return 1;
        }

        return 0;
    }
}
