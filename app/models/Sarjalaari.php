<?php

class Sarjalaari extends BaseModel {

    public $sarjaid, $leffaid;

    public function __construct($attribuutit) {
        parent::__construct($attribuutit);
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM SarjaLaari');
        $query->execute();
        $tulokset = $query->fetchAll();

        $sarjat = array();

        foreach ($tulokset as $tulos) {
            $sarjat[] = new Sarjalaari(array(
                'sarjaid' => $tulos['sarjaid'],
                'leffaid' => $tulos['leffaid']
            ));
        }
        return $sarjat;
    }

    public static function findOne($kid, $lid) {
        $query = DB::connection()->prepare('SELECT * FROM SarjaLaari WHERE sarjaid = :sarjaid AND leffaid = :leffaid LIMIT 1');
        $query->execute(array('sarjaid' => $kid, 'leffaid' => $lid));
        $tulos = $query->fetch();

        if ($tulos) {
            $sarja = new Sarjalaari(array(
                'sarjaid' => $tulos['sarjaid'],
                'leffaid' => $tulos['leffaid']
            ));
            return $sarja;
        }

        return null;
    }

}


