<?php

class Suosikkilista extends BaseModel {

    public $kayttajaid, $leffaid;

    public function __construct($attribuutit) {
        parent::__construct($attribuutit);
    }
    
    public function save($kayttajaid, $leffaid) {
        $query = DB::connection()->prepare('INSERT INTO Suosikkilista VALUES (:kayttajaid, :leffaid)');
        $query->execute(array('kayttajaid' => $kayttajaid, 'leffaid' => $leffaid));
    }

    public static function destroy($kayttajaid, $leffaid) {
        $query = DB::connection()->prepare('DELETE FROM Suosikkilista '
                . 'WHERE kayttajaID = :kayttajaid AND leffaID = :leffaid');
        $query->execute(array('kayttajaid' => $kayttajaid, 'leffaid' => $leffaid));
    }

//    public static function all() {
//        $query = DB::connection()->prepare('SELECT * FROM SuosikkiLista');
//        $query->execute();
//        $tulokset = $query->fetchAll();
//
//        $listat = array();
//
//        foreach ($tulokset as $tulos) {
//            $listat[] = new Suosikkilista(array(
//                'kayttajaid' => $tulos['kayttajaid'],
//                'leffaid' => $tulos['leffaid']
//            ));
//        }
//        return $listat;
//    }
//
//    public static function findOne($kid, $lid) {
//        $query = DB::connection()->prepare('SELECT * FROM SuosikkiLista WHERE kayttajaid = :kayttajaid AND leffaid = :leffaid LIMIT 1');
//        $query->execute(array('kayttajaid' => $kid, 'leffaid' => $lid));
//        $tulos = $query->fetch();
//
//        if ($tulos) {
//            $lista = new Suosikkilista(array(
//                'kayttajaid' => $tulos['kayttajaid'],
//                'leffaid' => $tulos['leffaid']
//            ));
//            return $lista;
//        }
//
//        return null;
//    }
}
