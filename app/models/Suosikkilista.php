<?php

/* Malli suosikkilistalle */

class Suosikkilista extends BaseModel {

    public $kayttajaid, $leffaid;

    public function __construct($attribuutit) {
        parent::__construct($attribuutit);
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
