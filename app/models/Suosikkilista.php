<?php

/* Malli suosikkilistalle */

class Suosikkilista extends BaseModel {

    public $kayttajaid, $leffaid;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    /* Onko elokuva jo suosikkilistassa? */
    public static function isFavourite($leffaid) {
        $query = DB::connection()->prepare('SELECT * FROM Suosikkilista '
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

    /* Tallennetaan käyttäjän listalle uusi elokuva */
    public function save($kayttajaid, $leffaid) {
        $query = DB::connection()->prepare('INSERT INTO Suosikkilista VALUES (:kayttajaid, :leffaid)');
        $query->execute(array('kayttajaid' => $kayttajaid, 'leffaid' => $leffaid));
    }

    /* Poistetaan käyttäjän listalta elokuva */
    public static function destroy($kayttajaid, $leffaid) {
        $query = DB::connection()->prepare('DELETE FROM Suosikkilista '
                . 'WHERE kayttajaID = :kayttajaid AND leffaID = :leffaid');
        $query->execute(array('kayttajaid' => $kayttajaid, 'leffaid' => $leffaid));
    }

}
