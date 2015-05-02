<?php

/* Malli elokuvan sarjojen tallentamiselle elokuvakohtaisesti */

class Sarjalaari extends BaseModel {

    public $sarjaid, $leffaid;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    /* Haetaan elokuvalle sarjat */
    public static function findSarjatForElokuva($leffaid) {
        $query = DB::connection()->prepare('SELECT S.sarjaID, sarjaNimi '
                . 'FROM Sarja S, SarjaLaari L '
                . 'WHERE S.sarjaID=L.sarjaID AND L.leffaID = :leffaid');
        $query->execute(array('leffaid' => $leffaid));
        $rows = $query->fetchAll();

        $sarjat = array();
        foreach ($rows as $row) {
            $sarjat[] = new Sarja(array(
                'sarjaid' => $row['sarjaid'],
                'sarjanimi' => $row['sarjanimi']
            ));
        }
        return $sarjat;
    }

    /* Haetaan elokuvat sarjalle */
    public static function findSarjanElokuvat($sarjaid) {
        $query = DB::connection()->prepare('SELECT L.sarjaid, L.leffaid, E.leffanimi '
                . 'FROM SarjaLaari L, Elokuva E '
                . 'WHERE L.leffaID=E.leffaID AND sarjaID = :sarjaid '
                . 'ORDER BY E.vuosi');
        $query->execute(array('sarjaid' => $sarjaid));
        $rows = $query->fetchAll();

        $sarjanelokuvat = array();
        foreach ($rows as $row) {
            $sarjanelokuvat[] = new Elokuva(array(
                'leffaid' => $row['leffaid'],
                'leffanimi' => $row['leffanimi']
            ));
        }
        return $sarjanelokuvat;
    }

    /* Tallennetaan uusi ehdotus */
    public function saveSuggestion($ryhmaid) {
        $query = ('INSERT INTO SarjaLaari (sarjaid, leffaid) '
                . 'VALUES (:sarjaid, :leffaid) RETURNING sarjaid');
        $locations = array(":sarjaid", ":leffaid");
        $params = array($this->sarjaid, $this->leffaid);
        $newQuery = str_replace($locations, $params, $query);

        $kysely = new Kyselyehdotus(array('kysely' => $newQuery));
        $kysely->save();
        Kyselyryhma::saveToLaari($ryhmaid, $kysely->kyselyid);
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO SarjaLaari (sarjaid, leffaid) '
                . 'VALUES (:sarjaid, :leffaid) RETURNING sarjaid');
        $query->execute(array(
            'sarjaid' => $this->sarjaid,
            'leffaid' => $this->leffaid
        ));
    }
    
    /* Poistamisehdotus */
    public function destroySuggestion($ryhmaid) {
        $query = ('DELETE FROM SarjaLaari '
                . 'WHERE sarjaid = :sarjaid AND leffaID = :leffaid');

        $locations = array(":sarjaid", ":leffaid");
        $params = array($this->sarjaid, $this->leffaid);
        $newQuery = str_replace($locations, $params, $query);

        $kysely = new Kyselyehdotus(array('kysely' => $newQuery));
        $kysely->save();
        Kyselyryhma::saveToLaari($ryhmaid, $kysely->kyselyid);
    }

    /* Poistaminen */
    public function destroy() {
        $query = DB::connection()->prepare('DELETE FROM SarjaLaari '
                . 'WHERE sarjaid = :sarjaid AND leffaID = :leffaid');
        $query->execute(array(
            'sarjaid' => $this->sarjaid,
            'leffaid' => $this->leffaid
        ));
    }
}
