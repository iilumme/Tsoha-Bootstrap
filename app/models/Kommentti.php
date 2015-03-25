<?php

class Kommentti extends BaseModel {

    public $kayttajaid, $leffaid, $teksti, $lisatty;

    public function __construct($attribuutit) {
        parent::__construct($attribuutit);
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Kommentti');
        $query->execute();
        $tulokset = $query->fetchAll();

        $kommentit = array();

        foreach ($tulokset as $tulos) {
            $kommentit[] = new Kommentti(array(
                'kayttajaid' => $tulos['kayttajaid'],
                'leffaid' => $tulos['leffaid'],
                'teksti' => $tulos['teksti'],
                'lisatty' => $tulos['lisatty']
            ));
        }
        return $kommentit;
    }

    public static function findOne($kid, $lid) {
        $query = DB::connection()->prepare('SELECT * FROM Kommentti WHERE kayttajaid = :kayttajaid AND leffaid = :leffaid LIMIT 1');
        $query->execute(array('kayttajaid' => $kid, 'leffaid' => $lid));
        $tulos = $query->fetch();

        if ($tulos) {
            $kommentti = new Kommentti(array(
                'kayttajaid' => $tulos['kayttajaid'],
                'leffaid' => $tulos['leffaid'],
                'teksti' => $tulos['teksti'],
                'lisatty' => $tulos['lisatty']
            ));
            return $kommentti;
        }

        return null;
    }

}
