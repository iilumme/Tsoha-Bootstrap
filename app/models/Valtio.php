<?php

/* Malli valtiolle */

class Valtio extends BaseModel {

    public $valtioid, $valtionimi, $valtiobio, $lippu;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    private static function createValtio($row) {
        return new Valtio(array(
            'valtioid' => $row['valtioid'],
            'valtionimi' => $row['valtionimi'],
            'valtiobio' => $row['valtiobio'],
            'lippu' => $row['lippu']
        ));
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Valtiot ORDER BY valtionimi');
        $query->execute();
        $rows = $query->fetchAll();

        $valtiot = array();
        foreach ($rows as $row) {
            $valtiot[] = Valtio::createValtio($row);
        }

        return $valtiot;
    }

    public static function findOne($valtioid) {
        $query = DB::connection()->prepare('SELECT * FROM Valtiot WHERE valtioid = :valtioid LIMIT 1');
        $query->execute(array('valtioid' => $valtioid));
        $row = $query->fetch();

        if ($row) {
            $valtio = Valtio::createValtio($row);
            return $valtio;
        }

        return null;
    }

    /* Haetaan valtio elokuvalle */
    public static function findValtioForElokuva($leffaid) {
        $query = DB::connection()->prepare('SELECT valtioid, valtionimi, valtiobio, lippu '
                . 'FROM Valtiot, Elokuva '
                . 'WHERE Elokuva.leffaid = :leffaid and Elokuva.valtio = Valtiot.valtioid LIMIT 1');
        $query->execute(array('leffaid' => $leffaid));
        $row = $query->fetch();

        if ($row) {
            $valtio = Valtio::createValtio($row);
            return $valtio;
        }

        return null;
    }

    /* Haetaan valtio artistille */
    public static function findValtioForArtisti($artistiid) {
        $query = DB::connection()->prepare('SELECT valtioid, valtionimi, valtiobio, lippu '
                . 'FROM Valtiot, Artisti '
                . 'WHERE Artisti.artistiid = :artistiid and Artisti.valtio = Valtiot.valtioid LIMIT 1');
        $query->execute(array('artistiid' => $artistiid));
        $row = $query->fetch();

        if ($row) {
            $valtio = Valtio::createValtio($row);
            return $valtio;
        }

        return null;
    }

    /* Tallennetaan muokkausehdotus */
    public function updateSuggestion() {
        $query = ('UPDATE Valtiot '
                . 'SET valtiobio = :valtiobio '
                . 'WHERE valtioid = :valtioid RETURNING valtioid');

        $locations = array(":valtiobio", ":valtioid");
        $params = array("'$this->valtiobio'", $this->valtioid);
        $newQuery = str_replace($locations, $params, $query);

        $queryGroup = new Kyselyryhma(array());
        $ryhmaid = $queryGroup->save();
        $kysely = new Kyselyehdotus(array(
            'kysely' => $newQuery
        ));
        $kysely->save();
        Kyselyryhma::saveToLaari($ryhmaid, $kysely->kyselyid);
    }

    /* Tallennetaan muokkaus */
    public function update() {
        $query = DB::connection()->prepare('UPDATE Valtiot '
                . 'SET valtiobio = :valtiobio '
                . 'WHERE valtioid = :valtioid RETURNING valtioid;');
        $query->execute(array(
            'valtioid' => $this->valtioid,
            'valtiobio' => $this->valtiobio
        ));

        $row = $query->fetch();
        return $row['valtioid'];
    }

}
