<?php

/* Malli elokuvan genrejen tallentamiselle elokuvakohtaisesti */

class Genrelaari extends BaseModel {

    public $genreid, $leffaid;

    public function __construct($attribuutit) {
        parent::__construct($attribuutit);
    }

    /* Tallennetaan uusi ehdotus */
    public function saveSuggestion($ryhmaid) {
        $query = ('INSERT INTO GenreLaari (genreid, leffaid) '
                . 'VALUES (:genreid, :leffaid) RETURNING genreid');
        $sijoituspaikat = array(":genreid", ":leffaid");
        $parametrit = array($this->genreid, $this->leffaid);
        $uusi = str_replace($sijoituspaikat, $parametrit, $query);

        $kysely = new Kyselyehdotus(array('kysely' => $uusi));
        $kysely->save();
        Kyselyryhma::saveToLaari($ryhmaid, $kysely->kyselyid);
    }

    /* Tallennetaan elokuvalle genre */
    public function save() {
        $query = DB::connection()->prepare('INSERT INTO GenreLaari (genreid, leffaid) '
                . 'VALUES (:genreid, :leffaid) RETURNING genreid');
        $query->execute(array(
            'genreid' => $this->genreid,
            'leffaid' => $this->leffaid
        ));
    }

    /* Poistaminen */
    public function destroy() {
        $query = DB::connection()->prepare('DELETE FROM GenreLaari '
                . 'WHERE genreid = :genreid AND leffaID = :leffaid');
        $query->execute(array(
            'genreid' => $this->genreid,
            'leffaid' => $this->leffaid
        ));
    }

    /* Poistamisehdotus */
    public function destroySuggestion($ryhmaid) {
        $query = ('DELETE FROM GenreLaari '
                . 'WHERE genreid = :genreid AND leffaID = :leffaid');

        $sijoituspaikat = array(":genreid", ":leffaid");
        $parametrit = array($this->genreid, $this->leffaid);
        $uusi = str_replace($sijoituspaikat, $parametrit, $query);

        $kysely = new Kyselyehdotus(array('kysely' => $uusi));
        $kysely->save();
        Kyselyryhma::saveToLaari($ryhmaid, $kysely->kyselyid);
    }

}
