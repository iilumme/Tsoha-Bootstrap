<?php

class Genre extends BaseModel {

    public $genreid, $genrenimi;

    public function __construct($attribuutit) {
        parent::__construct($attribuutit);
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Genre');
        $query->execute();
        $tulokset = $query->fetchAll();

        $genret = array();

        foreach ($tulokset as $tulos) {
            $genret[] = new Genre(array(
                'genreid' => $tulos['genreid'],
                'genrenimi' => $tulos['genrenimi']
            ));
        }
        return $genret;
    }

    public static function findOne($id) {
        $query = DB::connection()->prepare('SELECT * FROM Genre WHERE genreid = :genreid LIMIT 1');
        $query->execute(array('genreid' => $id));
        $tulos = $query->fetch();

        if ($tulos) {
            $genre = new Genre(array(
                'genreid' => $tulos['genreid'],
                'genrenimi' => $tulos['genrenimi']
            ));
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
            $genret[] = new Genre(array(
                'genreid' => $tulos['genreid'],
                'genrenimi' => $tulos['genrenimi']
            ));
        }
        return $genret;
    }

}
