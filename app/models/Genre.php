<?php

/* Malli genrelle */

class Genre extends BaseModel {

    public $genreid, $genrenimi;

    public function __construct($attribuutit) {
        parent::__construct($attribuutit);
    }

    private static function createGenre($tulos) {
        return new Genre(array(
            'genreid' => $tulos['genreid'],
            'genrenimi' => $tulos['genrenimi']
        ));
    }

    /* Haetaan kaikki genret */
    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Genre ORDER BY genrenimi');
        $query->execute();
        $tulokset = $query->fetchAll();

        $genret = array();
        foreach ($tulokset as $tulos) {
            $genret[] = Genre::createGenre($tulos);
        }
        return $genret;
    }

    /* Haetaan tietty genre IDllä */
    public static function findOne($genreid) {
        $query = DB::connection()->prepare('SELECT * FROM Genre WHERE genreid = :genreid LIMIT 1');
        $query->execute(array('genreid' => $genreid));
        $tulos = $query->fetch();

        if ($tulos) {
            $genre = Genre::createGenre($tulos);
            return $genre;
        }

        return null;
    }

    /* Haetaan genret elokuvalle */
    public static function findGenretForElokuva($leffaid) {
        $query = DB::connection()->prepare('SELECT G.genreID, G.genreNimi '
                . 'FROM Elokuva E, GenreLaari L, Genre G '
                . 'WHERE E.leffaid = :leffaid AND E.leffaid=L.leffaid AND L.genreID=G.genreID '
                . 'ORDER BY G.genrenimi');
        $query->execute(array('leffaid' => $leffaid));
        $tulokset = $query->fetchAll();

        $genret = array();
        foreach ($tulokset as $tulos) {
            $genret[] = Genre::createGenre($tulos);
        }
        return $genret;
    }

    /* Tallennetaan uusi genre-ehdotus */
    public function saveSuggestion($ryhmaid) {
        $query = ('INSERT INTO Genre (genrenimi) '
                . 'VALUES (:genrenimi) RETURNING genreid;');

        $sijoituspaikat = array(":genrenimi");
        $parametrit = array("'$this->genrenimi'");
        $uusi = str_replace($sijoituspaikat, $parametrit, $query);

        $kyselyryhma = new Kyselyryhma(array());
        $kysely = new Kyselyehdotus(array(
            'kysely' => $uusi
        ));
        $kysely->save();
        Kyselyryhma::saveToLaari($ryhmaid, $kysely->kyselyid);
    }

    /* Tallennetaan uudsi genre-ehdotus */
    public function saveSuggestionOwnGroup() {
        $query = ('INSERT INTO Genre (genrenimi) '
                . 'VALUES (:genrenimi) RETURNING genreid;');

        $sijoituspaikat = array(":genrenimi");
        $parametrit = array("'$this->genrenimi'");
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

    /* Tallennetaan uusi genre */
    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Genre (genrenimi) '
                . 'VALUES (:genrenimi) RETURNING genreid;');
        $query->execute(array(
            'genrenimi' => $this->genrenimi
        ));

        $tulos = $query->fetch();
        $this->genreid = $tulos['genreid'];
        return $this->genreid;
    }

    /* Genren poistaminen - ylläpitäjä tekee */
    public function destroy() {
        $query = DB::connection()->prepare('DELETE FROM Genre WHERE genreid = :genreid RETURNING genreid');
        $query->execute(array('genreid' => $this->genreid));
        $tulos = $query->fetch();

        if ($tulos) {
            return 1;
        }
        return 0;
    }

}
