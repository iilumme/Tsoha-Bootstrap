<?php

/* Malli käyttäjän antamalle arviolle */

class Arviolaari extends BaseModel {

    public $kayttajaid, $kayttajatunnus, $leffaid, $tahti, $lisatty;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    /* Haetaan elokuvalle arviot */
    public static function findStarsForMovie($leffaid) {
        $query = DB::connection()->prepare('SELECT A.kayttajaID, K.kayttajaTunnus, A.leffaID, A.tahti, A.lisatty '
                . 'FROM Elokuva E, ArvioLaari A, Kayttaja K '
                . 'WHERE E.leffaid = :leffaid AND E.leffaid=A.leffaid '
                . 'AND A.kayttajaID=K.kayttajaID ORDER BY A.lisatty');
        $query->execute(array('leffaid' => $leffaid));
        $rows = $query->fetchAll();

        $stars = array();
        foreach ($rows as $row) {
            $stars[] = new Arviolaari(array(
                'kayttajaid' => $row['kayttajaid'],
                'kayttajatunnus' => $row['kayttajatunnus'],
                'leffaid' => $row['leffaid'],
                'tahti' => $row['tahti'],
                'lisatty' => $row['lisatty']
            ));
        }
        return $stars;
    }

    /* Lisätään arvio */
    public static function addStarForMovie($leffaid, $star) {
        $query = DB::connection()->prepare('INSERT INTO ArvioLaari (kayttajaID, leffaID, tahti, lisatty) '
                . 'VALUES (:kayttajaid, :leffaid, :tahti, NOW())');
        $query->execute(array('kayttajaid' => BaseController::get_user_logged_in()->kayttajaid,
            'leffaid' => $leffaid, 'tahti' => $star));
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
        $row = $query->fetch();

        if ($row) {
            return $row['tahti'];
        }
        return 0;
    }

    /* Elokuvan arvioiden keskiarvo */
    public static function averageStar($leffaid) {
        $stars = Arviolaari::findStarsForMovie($leffaid);

        if ($stars != NULL) {
            $sum = 0.0;

            foreach ($stars as $star) {
                $sum+= $star->tahti;
            }
            return $sum / sizeof($stars);
        }
        
        return null;
    }

}
