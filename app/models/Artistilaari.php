<?php

class Artistilaari extends BaseModel {

    public $artistiid, $leffaid;

    public function __construct($attribuutit) {
        parent::__construct($attribuutit);
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM ArtistiLaari');
        $query->execute();
        $tulokset = $query->fetchAll();

        $listat = array();

        foreach ($tulokset as $tulos) {
            $listat[] = new Artistilaari(array(
                'artistiid' => $tulos['artistiid'],
                'leffaid' => $tulos['leffaid']
            ));
        }
        return $listat;
    }

    public static function findOne($kid, $lid) {
        $query = DB::connection()->prepare('SELECT * FROM ArtistiLaari WHERE artistiid = :artistiid AND leffaid = :leffaid LIMIT 1');
        $query->execute(array('artistiid' => $kid, 'leffaid' => $lid));
        $tulos = $query->fetch();

        if ($tulos) {
            $lista = new Artistilaari(array(
                'artistiid' => $tulos['artistiid'],
                'leffaid' => $tulos['leffaid']
            ));
            return $lista;
        }

        return null;
    }

}


