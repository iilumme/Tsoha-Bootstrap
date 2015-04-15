<?php

class Genrelaari extends BaseModel {

    public $genreid, $leffaid;

    public function __construct($attribuutit) {
        parent::__construct($attribuutit);
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO GenreLaari (genreid, leffaid) '
                . 'VALUES (:genreid, :leffaid) RETURNING genreid');
        $query->execute(array(
            'genreid' => $this->genreid,
            'leffaid' => $this->leffaid
        ));
    }

//    public static function all() {
//        $query = DB::connection()->prepare('SELECT * FROM GenreLaari');
//        $query->execute();
//        $tulokset = $query->fetchAll();
//
//        $genret = array();
//
//        foreach ($tulokset as $tulos) {
//            $genret[] = new Genrelaari(array(
//                'genreid' => $tulos['genreid'],
//                'leffaid' => $tulos['leffaid']
//            ));
//        }
//        return $genret;
//    }
//
//    public static function findOne($gid, $lid) {
//        $query = DB::connection()->prepare('SELECT * FROM GenreLaari WHERE genreid = :genreid AND leffaid = :leffaid LIMIT 1');
//        $query->execute(array('genreid' => $gid, 'leffaid' => $lid));
//        $tulos = $query->fetch();
//
//        if ($tulos) {
//            $genre = new Genrelaari(array(
//                'genreid' => $tulos['genreid'],
//                'leffaid' => $tulos['leffaid']
//            ));
//            return $genre;
//        }
//
//        return null;
//    }
}
