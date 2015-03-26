<?php

class Arviolaari extends BaseModel {

    public $kayttajaid, $kayttajatunnus, $leffaid, $tahti, $lisatty;

    public function __construct($attribuutit) {
        parent::__construct($attribuutit);
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT A.kayttajaID, K.kayttajaTunnus, leffaID, tahti, A.lisatty FROM ArvioLaari A, Kayttaja K WHERE A.kayttajaID=K.kayttajaID');
        $query->execute();
        $tulokset = $query->fetchAll();

        $arviot = array();

        foreach ($tulokset as $tulos) {
            $arviot[] = new Arviolaari(array(
                'kayttajaid' => $tulos['kayttajaid'],
                'kayttajatunnus' => $tulos['kayttajatunnus'],
                'leffaid' => $tulos['leffaid'],
                'tahti' => $tulos['tahti'],
                'lisatty' => $tulos['lisatty']
            ));
        }
        return $arviot;
    }

    public static function findOne($id) {
        $query = DB::connection()->prepare('SELECT A.kayttajaID, K.kayttajaTunnus, leffaID, tahti FROM ArvioLaari A, Kayttaja K WHERE A.kayttajaID=K.kayttajaID AND leffaid = :leffaid');
        $query->execute(array('leffaid' => $id));
        $tulos = $query->fetch();

        if ($tulos) {
            $arvio = new Arviolaari(array(
                'kayttajaid' => $tulos['kayttajaid'],
                'kayttajatunnus' => $tulos['kayttajatunnus'],
                'leffaid' => $tulos['leffaid'],
                'tahti' => $tulos['tahti'],
                'lisatty' => $tulos['lisatty']
            ));
            return $arvio;
        }

        return null;
    }

}
