<?php

class Arviolaari extends BaseModel {

    public $kayttajaid, $leffaid, $tahti;

    public function __construct($attribuutit) {
        parent::__construct($attribuutit);
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM ArvioLaari');
        $query->execute();
        $tulokset = $query->fetchAll();

        $arviot = array();

        foreach ($tulokset as $tulos) {
            $arviot[] = new Arviolaari(array(
                'kayttajaid' => $tulos['kayttajaid'],
                'leffaid' => $tulos['leffaid'],
                'tahti' => $tulos['tahti']
            ));
        }
        return $arviot;
    }

    public static function findOne($kid, $lid) {
        $query = DB::connection()->prepare('SELECT * FROM ArvioLaari WHERE kayttajaid = :kayttajaid AND leffaid = :leffaid LIMIT 1');
        $query->execute(array('kayttajaid' => $kid, 'leffaid' => $lid));
        $tulos = $query->fetch();

        if ($tulos) {
            $arvio = new Arviolaari(array(
                'kayttajaid' => $tulos['kayttajaid'],
                'leffaid' => $tulos['leffaid'],
                'tahti' => $tulos['tahti']
            ));
            return $arvio;
        }

        return null;
    }

}
