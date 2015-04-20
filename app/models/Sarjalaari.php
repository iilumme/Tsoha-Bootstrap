<?php

/* Malli elokuvan sarjojen tallentamiselle elokuvakohtaisesti */

class Sarjalaari extends BaseModel {

    public $sarjaid, $leffaid;

    public function __construct($attribuutit) {
        parent::__construct($attribuutit);
    }

    /* Haetaan elokuvalle sarjat */
    public static function findSarjatForElokuva($leffaid) {
        $query = DB::connection()->prepare('SELECT S.sarjaID, sarjaNimi '
                . 'FROM Sarja S, SarjaLaari L '
                . 'WHERE S.sarjaID=L.sarjaID AND L.leffaID = :leffaid');
        $query->execute(array('leffaid' => $leffaid));
        $tulokset = $query->fetchAll();

        $sarjat = array();
        foreach ($tulokset as $tulos) {
            $sarjat[] = new Sarja(array(
                'sarjaid' => $tulos['sarjaid'],
                'sarjanimi' => $tulos['sarjanimi']
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
        $tulokset = $query->fetchAll();

        $sarjanelokuvat = array();
        foreach ($tulokset as $tulos) {
            $sarjanelokuvat[] = new Elokuva(array(
                'leffaid' => $tulos['leffaid'],
                'leffanimi' => $tulos['leffanimi']
            ));
        }
        return $sarjanelokuvat;
    }

    /* Tallennetaan uusi ehdotus */
    public function saveSuggestion($ryhmaid) {
        $query = ('INSERT INTO SarjaLaari (sarjaid, leffaid) '
                . 'VALUES (:sarjaid, :leffaid) RETURNING sarjaid');
        $sijoituspaikat = array(":sarjaid", ":leffaid");
        $parametrit = array($this->sarjaid, $this->leffaid);
        $uusi = str_replace($sijoituspaikat, $parametrit, $query);

        $kyselyryhma = new Kyselyryhma(array());
        $kysely = new Kyselyehdotus(array(
            'kysely' => $uusi
        ));
        $kysely->save();
        $kyselyryhma->saveToLaari($ryhmaid, $kysely->kyselyid);
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO SarjaLaari (sarjaid, leffaid) '
                . 'VALUES (:sarjaid, :leffaid) RETURNING sarjaid');
        $query->execute(array(
            'sarjaid' => $this->sarjaid,
            'leffaid' => $this->leffaid
        ));
    }

}
