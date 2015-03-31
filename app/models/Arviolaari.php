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
        $query = DB::connection()->prepare('SELECT A.kayttajaID, K.kayttajaTunnus, leffaID, tahti, A.lisatty FROM ArvioLaari A, Kayttaja K WHERE A.kayttajaID=K.kayttajaID AND leffaid = :leffaid');
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

    public static function findArviotForElokuva($id) {
        $query = DB::connection()->prepare('SELECT A.kayttajaID, K.kayttajaTunnus, A.leffaID, A.tahti, A.lisatty FROM Elokuva E, ArvioLaari A, Kayttaja K WHERE E.leffaid = :leffaid AND E.leffaid=A.leffaid AND A.kayttajaID=K.kayttajaID ORDER BY A.lisatty');
        $query->execute(array('leffaid' => $id));
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
}
