<?php

/* Malli käyttäjän antamalle arviolle */

class Arviolaari extends BaseModel {

    public $kayttajaid, $kayttajatunnus, $leffaid, $tahti, $lisatty;

    public function __construct($attribuutit) {
        parent::__construct($attribuutit);
    }

    /* Haetaan elokuvalle arviot */
    public static function findArviotForElokuva($leffaid) {
        $query = DB::connection()->prepare('SELECT A.kayttajaID, K.kayttajaTunnus, A.leffaID, A.tahti, A.lisatty '
                . 'FROM Elokuva E, ArvioLaari A, Kayttaja K '
                . 'WHERE E.leffaid = :leffaid AND E.leffaid=A.leffaid '
                . 'AND A.kayttajaID=K.kayttajaID ORDER BY A.lisatty');
        $query->execute(array('leffaid' => $leffaid));
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

    /* Lisätään arvio */
    public static function addStarForMovie($leffaid, $tahti) {
        $query = DB::connection()->prepare('INSERT INTO ArvioLaari (kayttajaID, leffaID, tahti, lisatty) '
                . 'VALUES (:kayttajaid, :leffaid, :tahti, NOW())');
        $query->execute(array('kayttajaid' => BaseController::get_user_logged_in()->kayttajaid,
            'leffaid' => $leffaid, 'tahti' => $tahti));
    }

    /* Poistetaan arvio */
    public static function deleteStarFromMovie($leffaid) {
        $query = DB::connection()->prepare('DELETE FROM ArvioLaari '
                . 'WHERE leffaID = :leffaid AND kayttajaID = :kayttajaid;');
        $query->execute(array('kayttajaid' => BaseController::get_user_logged_in()->kayttajaid,
            'leffaid' => $leffaid));
    }

    /* Onko jo arvioinut elokuvan? */
    public static function hasAddedStars($leffaid) {
        $query = DB::connection()->prepare('SELECT A.kayttajaID, K.kayttajaTunnus, leffaID, tahti, A.lisatty '
                . 'FROM ArvioLaari A, Kayttaja K WHERE A.kayttajaID=K.kayttajaID AND leffaid = :leffaid '
                . 'AND K.kayttajaID = :kayttajaid');
        $query->execute(array('leffaid' => $leffaid,
            'kayttajaid' => BaseController::get_user_logged_in()->kayttajaid));
        $tulos = $query->fetch();

        if ($tulos) {
            return $tulos['tahti'];
        }
        return 0;
    }

//    public static function findOne($id) {
//        $query = DB::connection()->prepare('SELECT A.kayttajaID, K.kayttajaTunnus, leffaID, tahti, A.lisatty FROM ArvioLaari A, Kayttaja K WHERE A.kayttajaID=K.kayttajaID AND leffaid = :leffaid');
//        $query->execute(array('leffaid' => $id));
//        $tulos = $query->fetch();
//
//        if ($tulos) {
//            $arvio = new Arviolaari(array(
//                'kayttajaid' => $tulos['kayttajaid'],
//                'kayttajatunnus' => $tulos['kayttajatunnus'],
//                'leffaid' => $tulos['leffaid'],
//                'tahti' => $tulos['tahti'],
//                'lisatty' => $tulos['lisatty']
//            ));
//            return $arvio;
//        }
//
//        return null;
//    }
//    public static function all() {
//        $query = DB::connection()->prepare('SELECT A.kayttajaID, K.kayttajaTunnus, leffaID, tahti, A.lisatty '
//                . 'FROM ArvioLaari A, Kayttaja K '
//                . 'WHERE A.kayttajaID=K.kayttajaID');
//        $query->execute();
//        $tulokset = $query->fetchAll();
//
//        $arviot = array();
//        foreach ($tulokset as $tulos) {
//            $arviot[] = new Arviolaari(array(
//                'kayttajaid' => $tulos['kayttajaid'],
//                'kayttajatunnus' => $tulos['kayttajatunnus'],
//                'leffaid' => $tulos['leffaid'],
//                'tahti' => $tulos['tahti'],
//                'lisatty' => $tulos['lisatty']
//            ));
//        }
//        return $arviot;
//    }
}
