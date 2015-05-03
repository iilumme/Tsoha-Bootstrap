<?php

/* Malli valtiolle */

class Viesti extends BaseModel {


    public $viestiid, $lahettaja, $vastaanottaja, $teksti, $luettu, $lahetetty;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    private static function createViesti($row) {
        return new Viesti(array(
            'viestiid' => $row['viestiid'],
            'lahettaja' => $row['lahettaja'],
            'vastaanottaja' => $row['vastaanottaja'],
            'teksti' => $row['teksti'],
            'luettu' => $row['luettu'],
            'lahetetty' => $row['sent']
        ));
    }

    public static function all() {
        $query = DB::connection()->prepare("SELECT viestiID, lahettaja, vastaanottaja, teksti, "
                . "luettu, to_char(lahetetty, 'DD.MM.YYYY HH24:MI') AS sent FROM Viesti ORDER BY lahetetty");
        $query->execute();
        $rows = $query->fetchAll();

        $viestit = array();
        foreach ($rows as $row) {
            $viestit[] = Viesti::createViesti($row);
        }

        return $viestit;
    }

    public static function arrived() {
        $query = DB::connection()->prepare("SELECT viestiID, lahettaja, vastaanottaja, teksti, "
                . "luettu, to_char(lahetetty, 'DD.MM.YYYY HH24:MI') AS sent FROM Viesti "
                . "WHERE vastaanottaja = :vastaanottaja ORDER BY lahetetty");
        $query->execute(array('vastaanottaja' => BaseController::get_user_logged_in()->kayttajaid));
        $rows = $query->fetchAll();

        $viestit = array();
        foreach ($rows as $row) {
            $viestit[] = Viesti::createViesti($row);
        }

        return $viestit;
    }

    public static function sent() {
        $query = DB::connection()->prepare("SELECT viestiID, lahettaja, vastaanottaja, teksti, "
                . "luettu, to_char(lahetetty, 'DD.MM.YYYY HH24:MI') AS sent FROM Viesti "
                . "WHERE lahettaja = :lahettaja ORDER BY lahetetty");
        $query->execute(array('lahettaja' => BaseController::get_user_logged_in()->kayttajaid));
        $rows = $query->fetchAll();

        $viestit = array();
        foreach ($rows as $row) {
            $viestit[] = Viesti::createViesti($row);
        }

        return $viestit;
    }

    public static function read($viestiid) {
        $query = DB::connection()->prepare('UPDATE Viesti SET luettu = TRUE WHERE viestiID = :viestiid');
        $query->execute(array('viestiid' => $viestiid));
    }

    public static function countOfArrived() {
        $query = DB::connection()->prepare("SELECT viestiID, lahettaja, vastaanottaja, teksti, "
                . "luettu, to_char(lahetetty, 'DD.MM.YYYY HH24:MI') AS sent "
                . "FROM Viesti WHERE vastaanottaja = :vastaanottaja AND luettu = FALSE "
                . "ORDER BY lahetetty");
        $query->execute(array('vastaanottaja' => BaseController::get_user_logged_in()->kayttajaid));
        $rows = $query->fetchAll();

        return count($rows);
    }

    public static function countOfSent() {
        $query = DB::connection()->prepare("SELECT viestiID, lahettaja, vastaanottaja, teksti, "
                . "luettu, to_char(lahetetty, 'DD.MM.YYYY HH24:MI') AS sent "
                . "FROM Viesti WHERE lahettaja = :lahettaja AND luettu = FALSE "
                . "ORDER BY lahetetty");
        $query->execute(array('lahettaja' => BaseController::get_user_logged_in()->kayttajaid));
        $rows = $query->fetchAll();

        return count($rows);
    }

    /* Tallennetaan uusi viesti */
    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Viesti (lahettaja, vastaanottaja, teksti, luettu, lahetetty) VALUES (:lahettaja, :vastaanottaja, :teksti, FALSE, NOW()) RETURNING viestiid');
        $query->execute(array(
            'lahettaja' => $this->lahettaja,
            'vastaanottaja' => $this->vastaanottaja,
            'teksti' => $this->teksti
        ));
    }

    /* Muokataan viestiä */
    public function update() {
        $query = DB::connection()->prepare('UPDATE Viesti '
                . 'SET vastaanottaja = :vastaanottaja, teksti = :teksti, lahetetty = NOW(), luettu = FALSE '
                . 'WHERE viestiID = :viestiid');
        $query->execute(array(
            'viestiid' => $this->viestiid,
            'vastaanottaja' => $this->vastaanottaja,
            'teksti' => $this->teksti
        ));
    }

    /* Poistetaan viesti */
    public function destroy() {
        $query = DB::connection()->prepare('DELETE FROM Viesti WHERE viestiID = :viestiid');
        $query->execute(array('viestiid' => $this->viestiid));
    }
    
    /* Poistetaan saapuneet */
    public static function destroyAllArrived($kayttajaid) {
        $query = DB::connection()->prepare('DELETE FROM Viesti WHERE vastaanottaja = :kayttajaid');
        $query->execute(array('kayttajaid' => $kayttajaid));
    }
    
    /* Poistetaan lähetetyt */
    public static function destroyAllSent($kayttajaid) {
        $query = DB::connection()->prepare('DELETE FROM Viesti WHERE lahettaja = :kayttajaid');
        $query->execute(array('kayttajaid' => $kayttajaid));
    }

}
