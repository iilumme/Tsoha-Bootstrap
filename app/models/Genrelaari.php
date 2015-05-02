<?php

/* Malli elokuvan genrejen tallentamiselle elokuvakohtaisesti */

class Genrelaari extends BaseModel {

    public $genreid, $leffaid;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    /* Tallennetaan uusi ehdotus */
    public function saveSuggestion($ryhmaid) {
        $query = ('INSERT INTO GenreLaari (genreid, leffaid) '
                . 'VALUES (:genreid, :leffaid) RETURNING genreid');
        $locations = array(":genreid", ":leffaid");
        $params = array($this->genreid, $this->leffaid);
        $newQuery = str_replace($locations, $params, $query);

        $kysely = new Kyselyehdotus(array('kysely' => $newQuery));
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

        $locations = array(":genreid", ":leffaid");
        $params = array($this->genreid, $this->leffaid);
        $newQuery = str_replace($locations, $params, $query);

        $kysely = new Kyselyehdotus(array('kysely' => $newQuery));
        $kysely->save();
        Kyselyryhma::saveToLaari($ryhmaid, $kysely->kyselyid);
    }

}
