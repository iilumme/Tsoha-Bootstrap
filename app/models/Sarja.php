<?php

/* Malli sarjalle */

class Sarja extends BaseModel {

    public $sarjaid, $sarjanimi;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    private static function createSarja($row) {
        return new Sarja(array(
            'sarjaid' => $row['sarjaid'],
            'sarjanimi' => $row['sarjanimi']
        ));
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Sarja');
        $query->execute();
        $rows = $query->fetchAll();

        $sarjat = array();
        foreach ($rows as $row) {
            $sarjat[] = Sarja::createSarja($row);
        }
        return $sarjat;
    }
    
    /* Haetaan kaikki sarjat, joissa ei ole annettua elokuvaa */
    public static function findAllSeriesNotInTheMovie($leffaid) {
        $query = DB::connection()->prepare('SELECT * FROM Sarja '
                . 'WHERE sarjaID NOT IN (SELECT sarjaID FROM SarjaLaari WHERE leffaID = :leffaid)  '
                . 'ORDER BY sarjaNimi');
        $query->execute(array('leffaid' => $leffaid));
        $rows = $query->fetchAll();

        $sarjat = array();
        foreach ($rows as $row) {
            $sarjat[] = Sarja::createSarja($row);
        }
        return $sarjat;
    }

    public static function findOne($sarjaid) {
        $query = DB::connection()->prepare('SELECT * FROM Sarja WHERE sarjaid = :sarjaid LIMIT 1');
        $query->execute(array('sarjaid' => $sarjaid));
        $row = $query->fetch();

        if ($row) {
            $sarja = Sarja::createSarja($row);
            return $sarja;
        }

        return null;
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Sarja (sarjaNimi) '
                . 'VALUES (:sarjanimi) RETURNING sarjaid;');
        $query->execute(array('sarjanimi' => $this->sarjanimi));

        $row = $query->fetch();
        $this->sarjaid = $row['sarjaid'];
        return $this->sarjaid;
    }

    /* Tallennetaan uusi sarjaehdotus */
    public function saveSuggestion($ryhmaid) {
        $query = ('INSERT INTO Sarja (sarjaNimi) '
                . 'VALUES (:sarjanimi) RETURNING sarjaid;');

        $locations = array(":sarjanimi");
        $params = array("'$this->sarjanimi'");
        $newQuery = str_replace($locations, $params, $query);

        $kysely = new Kyselyehdotus(array('kysely' => $newQuery));
        $kysely->save();
        Kyselyryhma::saveToLaari($ryhmaid, $kysely->kyselyid);
    }
    
    
    /* Tallennetaan uusi sarja-ehdotus */
    public function saveSuggestionOwnGroup() {
        $query = ('INSERT INTO Sarja (sarjaNimi) '
                . 'VALUES (:sarjanimi) RETURNING sarjaid;');

        $locations = array(":sarjanimi");
        $params = array("'$this->sarjanimi'");
        $newQuery = str_replace($locations, $params, $query);


        $queryGroup = new Kyselyryhma(array());
        $ryhmaid = $queryGroup->save();
        $kysely = new Kyselyehdotus(array(
            'kysely' => $newQuery
        ));
        $kysely->save();
        Kyselyryhma::saveToLaari($ryhmaid, $kysely->kyselyid);

        return $ryhmaid;
    }


    /* Sarjan poistaminen - ylläpitäjä tekee */
    public function destroy() {
        $query = DB::connection()->prepare('DELETE FROM Sarja WHERE sarjaid = :sarjaid');
        $query->execute(array('sarjaid' => $this->sarjaid));
    }

}
