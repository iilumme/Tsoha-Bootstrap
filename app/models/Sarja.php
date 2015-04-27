<?php

/* Malli sarjalle */

class Sarja extends BaseModel {

    public $sarjaid, $sarjanimi;

    public function __construct($attribuutit) {
        parent::__construct($attribuutit);
    }

    private static function createSarja($tulos) {
        return new Sarja(array(
            'sarjaid' => $tulos['sarjaid'],
            'sarjanimi' => $tulos['sarjanimi']
        ));
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Sarja');
        $query->execute();
        $tulokset = $query->fetchAll();

        $sarjat = array();
        foreach ($tulokset as $tulos) {
            $sarjat[] = Sarja::createSarja($tulos);
        }
        return $sarjat;
    }

    public static function findOne($sarjaid) {
        $query = DB::connection()->prepare('SELECT * FROM Sarja WHERE sarjaid = :sarjaid LIMIT 1');
        $query->execute(array('sarjaid' => $sarjaid));
        $tulos = $query->fetch();

        if ($tulos) {
            $sarja = Sarja::createSarja($tulos);
            return $sarja;
        }

        return null;
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Sarja (sarjaNimi) '
                . 'VALUES (:sarjanimi) RETURNING sarjaid;');
        $query->execute(array('sarjanimi' => $this->sarjanimi));

        $tulos = $query->fetch();
        $this->sarjaid = $tulos['sarjaid'];
        return $this->sarjaid;
    }

    /* Tallennetaan uusi sarjaehdotus */
    public function saveSuggestion($ryhmaid) {
        $query = ('INSERT INTO Sarja (sarjaNimi) '
                . 'VALUES (:sarjanimi) RETURNING sarjaid;');

        $sijoituspaikat = array(":sarjanimi");
        $parametrit = array("'$this->sarjanimi'");
        $uusi = str_replace($sijoituspaikat, $parametrit, $query);

        $kysely = new Kyselyehdotus(array('kysely' => $uusi));
        $kysely->save();
        Kyselyryhma::saveToLaari($ryhmaid, $kysely->kyselyid);
    }
    
    
    /* Tallennetaan uusi sarja-ehdotus */
    public function saveSuggestionOwnGroup() {
        $query = ('INSERT INTO Sarja (sarjaNimi) '
                . 'VALUES (:sarjanimi) RETURNING sarjaid;');

        $sijoituspaikat = array(":sarjanimi");
        $parametrit = array("'$this->sarjanimi'");
        $uusi = str_replace($sijoituspaikat, $parametrit, $query);


        $kyselyryhma = new Kyselyryhma(array());
        $ryhmaid = $kyselyryhma->save();
        $kysely = new Kyselyehdotus(array(
            'kysely' => $uusi
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
