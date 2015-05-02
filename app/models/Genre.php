<?php

/* Malli genrelle */

class Genre extends BaseModel {

    public $genreid, $genrenimi;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    private static function createGenre($row) {
        return new Genre(array(
            'genreid' => $row['genreid'],
            'genrenimi' => $row['genrenimi']
        ));
    }

    /* Haetaan kaikki genret */
    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Genre ORDER BY genrenimi');
        $query->execute();
        $rows = $query->fetchAll();

        $genret = array();
        foreach ($rows as $row) {
            $genret[] = Genre::createGenre($row);
        }
        return $genret;
    }
    
    /* Haetaan kaikki genret, jotka eivät kuulu annetuun elokuvaan */
    public static function findAllGenresNotInTheMovie($leffaid) {
        $query = DB::connection()->prepare('SELECT * FROM Genre '
                . 'WHERE genreID NOT IN (SELECT genreID FROM GenreLaari WHERE leffaID = :leffaid)'
                . ' ORDER BY genrenimi');
        $query->execute(array('leffaid' => $leffaid));
        $rows = $query->fetchAll();

        $genret = array();
        foreach ($rows as $row) {
            $genret[] = Genre::createGenre($row);
        }
        return $genret;
    }

    /* Haetaan tietty genre IDllä */
    public static function findOne($genreid) {
        $query = DB::connection()->prepare('SELECT * FROM Genre WHERE genreid = :genreid LIMIT 1');
        $query->execute(array('genreid' => $genreid));
        $row = $query->fetch();

        if ($row) {
            $genre = Genre::createGenre($row);
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
        $rows = $query->fetchAll();

        $genret = array();
        foreach ($rows as $row) {
            $genret[] = Genre::createGenre($row);
        }
        return $genret;
    }

    /* Tallennetaan uusi genre-ehdotus */
    public function saveSuggestion($ryhmaid) {
        $query = ('INSERT INTO Genre (genrenimi) '
                . 'VALUES (:genrenimi) RETURNING genreid;');

        $locations = array(":genrenimi");
        $params = array("'$this->genrenimi'");
        $newQuery = str_replace($locations, $params, $query);

        $queryGroup = new Kyselyryhma(array());
        $kysely = new Kyselyehdotus(array(
            'kysely' => $newQuery
        ));
        $kysely->save();
        Kyselyryhma::saveToLaari($ryhmaid, $kysely->kyselyid);
    }

    /* Tallennetaan uudsi genre-ehdotus */
    public function saveSuggestionOwnGroup() {
        $query = ('INSERT INTO Genre (genrenimi) '
                . 'VALUES (:genrenimi) RETURNING genreid;');

        $locations = array(":genrenimi");
        $params = array("'$this->genrenimi'");
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

    /* Tallennetaan uusi genre */
    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Genre (genrenimi) '
                . 'VALUES (:genrenimi) RETURNING genreid;');
        $query->execute(array(
            'genrenimi' => $this->genrenimi
        ));

        $row = $query->fetch();
        $this->genreid = $row['genreid'];
        return $this->genreid;
    }

    /* Genren poistaminen - ylläpitäjä tekee */
    public function destroy() {
        $query = DB::connection()->prepare('DELETE FROM Genre WHERE genreid = :genreid RETURNING genreid');
        $query->execute(array('genreid' => $this->genreid));
        $row = $query->fetch();

        if ($row) {
            return 1;
        }
        return 0;
    }

}
