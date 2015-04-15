<?php

class Artistilaari extends BaseModel {

    public $artistiid, $leffaid;

    public function __construct($attribuutit) {
        parent::__construct($attribuutit);
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO ArtistiLaari (artistiid, leffaid) '
                . 'VALUES (:artistiid, :leffaid) RETURNING artistiid');
        $query->execute(array(
            'artistiid' => $this->artistiid,
            'leffaid' => $this->leffaid
        ));
    }

//    public static function all() {
//        $query = DB::connection()->prepare('SELECT * FROM ArtistiLaari');
//        $query->execute();
//        $tulokset = $query->fetchAll();
//
//        $listat = array();
//
//        foreach ($tulokset as $tulos) {
//            $listat[] = new Artistilaari(array(
//                'artistiid' => $tulos['artistiid'],
//                'leffaid' => $tulos['leffaid']
//            ));
//        }
//        return $listat;
//    }
//
//    public static function findOne($kid, $lid) {
//        $query = DB::connection()->prepare('SELECT * FROM ArtistiLaari WHERE artistiid = :artistiid AND leffaid = :leffaid LIMIT 1');
//        $query->execute(array('artistiid' => $kid, 'leffaid' => $lid));
//        $tulos = $query->fetch();
//
//        if ($tulos) {
//            $lista = new Artistilaari(array(
//                'artistiid' => $tulos['artistiid'],
//                'leffaid' => $tulos['leffaid']
//            ));
//            return $lista;
//        }
//
//        return null;
//    }
}
