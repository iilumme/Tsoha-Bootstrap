<?php

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

    public static function findOne($id) {
        $query = DB::connection()->prepare('SELECT * FROM Genre WHERE genreid = :genreid LIMIT 1');
        $query->execute(array('genreid' => $id));
        $tulos = $query->fetch();

        if ($tulos) {
            $genre = Genre::createGenre($tulos);
            return $genre;
        }

        return null;
    }

    public static function findGenretForElokuva($id) {
        $query = DB::connection()->prepare('SELECT G.genreID, G.genreNimi FROM Elokuva E, GenreLaari L, Genre G WHERE E.leffaid = :leffaid AND E.leffaid=L.leffaid AND L.genreID=G.genreID ORDER BY G.genrenimi');
        $query->execute(array('leffaid' => $id));
        $tulokset = $query->fetchAll();

        $genret = array();
        foreach ($tulokset as $tulos) {
            $genret[] = Genre::createGenre($tulos);
        }
        return $genret;
    }

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

}
