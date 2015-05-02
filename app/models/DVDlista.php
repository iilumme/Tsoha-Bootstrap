<?php

/* Malli DVDListalle */

class DVDlista extends BaseModel {

    public $kayttajaid, $kayttajatunnus, $leffaid;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    /* Haetaan käyttäjät joilla on kyseisen elokuvan DVD */
    //ERI PAIKKAAN?
    //
    //

    public static function findDVDSForMovie($leffaid) {
        $query = DB::connection()->prepare('SELECT K.kayttajaTunnus '
                . 'FROM DVDLista D, Kayttaja K '
                . 'WHERE D.kayttajaID=K.kayttajaID AND leffaid = :leffaid '
                . 'ORDER BY K.kayttajatunnus');
        $query->execute(array('leffaid' => $leffaid));
        $rows = $query->fetchAll();

        $users = array();
        foreach ($rows as $row) {
            $users[] = new DVDlista(array(
                'kayttajatunnus' => $row['kayttajatunnus']
            ));
        }

        return $users;
    }

    /* Tallennetaan elokuva käyttäjän DVDListalle */
    public function save($kayttajaid, $leffaid) {
        $query = DB::connection()->prepare('INSERT INTO DVDLista VALUES (:kayttajaid, :leffaid)');
        $query->execute(array('kayttajaid' => $kayttajaid, 'leffaid' => $leffaid));
    }

    /* Poistetaan elokuva käyttäjän DVDListalta */
    public static function destroy($kayttajaid, $leffaid) {
        $query = DB::connection()->prepare('DELETE FROM DVDLista '
                . 'WHERE kayttajaID = :kayttajaid AND leffaID = :leffaid');
        $query->execute(array('kayttajaid' => $kayttajaid, 'leffaid' => $leffaid));
    }
    
    /* Onko elokuva jo DVDlistassa? */
    public static function hasDVD($leffaid) {
        $query = DB::connection()->prepare('SELECT * FROM DVDLista '
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
