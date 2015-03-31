<?php

class Kommentti extends BaseModel {

    public $kayttajaid, $kayttajatunnus, $leffaid, $teksti, $lisatty;

    public function __construct($attribuutit) {
        parent::__construct($attribuutit);
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT K.leffaid, K.kayttajaid, K.lisatty, K.teksti, T.kayttajatunnus FROM Kommentti K, Kayttaja T WHERE K.kayttajaid=T.kayttajaid');
        $query->execute();
        $tulokset = $query->fetchAll();

        $kommentit = array();

        foreach ($tulokset as $tulos) {
            $kommentit[] = new Kommentti(array(
                'kayttajaid' => $tulos['kayttajaid'],
                'kayttajatunnus' => $tulos['kayttajatunnus'],
                'leffaid' => $tulos['leffaid'],
                'teksti' => $tulos['teksti'],
                'lisatty' => $tulos['lisatty']
            ));
        }
        return $kommentit;
    }

    public static function findOne($kid, $lid) {
        $query = DB::connection()->prepare('SELECT K.leffaid, K.kayttajaid, K.lisatty, K.teksti, T.kayttajatunnus FROM Kommentti K, Kayttaja T WHERE K.kayttajaid=T.kayttajaid AND K.leffaid=E.leffaid AND E.leffaid= :leffaid AND K.kayttajaid= :kayttajaid LIMIT 1');
        $query->execute(array('kayttajaid' => $kid, 'leffaid' => $lid));
        $tulos = $query->fetch();

        if ($tulos) {
            $kommentti = new Kommentti(array(
                'kayttajaid' => $tulos['kayttajaid'],
                'kayttajatunnus' => $tulos['kayttajatunnus'],
                'leffaid' => $tulos['leffaid'],
                'teksti' => $tulos['teksti'],
                'lisatty' => $tulos['lisatty']
            ));
            return $kommentti;
        }

        return null;
    }

    public static function findKommentitForElokuva($lid) {
        $query = DB::connection()->prepare('SELECT K.leffaid, K.kayttajaid, K.lisatty, K.teksti, T.kayttajatunnus FROM Kommentti K, Kayttaja T, Elokuva E WHERE K.kayttajaid=T.kayttajaid AND K.leffaid=E.leffaid AND E.leffaid= :leffaid');
        $query->execute(array('leffaid' => $lid));
        $tulokset = $query->fetchAll();

        $kommentit = array();

        foreach ($tulokset as $tulos) {
            $kommentit[] = new Kommentti(array(
                'kayttajaid' => $tulos['kayttajaid'],
                'kayttajatunnus' => $tulos['kayttajatunnus'],
                'leffaid' => $tulos['leffaid'],
                'teksti' => $tulos['teksti'],
                'lisatty' => $tulos['lisatty']
            ));
        }
        return $kommentit;
    }

}
