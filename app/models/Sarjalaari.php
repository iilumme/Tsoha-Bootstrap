<?php

class Sarjalaari extends BaseModel {

    public $sarjaid, $leffaid, $sarjanimi, $leffanimi;

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

    public static function findSarjanElokuvat($lid) {
        $query = DB::connection()->prepare('SELECT L.sarjaid, L.leffaid, S.sarjanimi, E.leffanimi FROM SarjaLaari L, Sarja S, Elokuva E WHERE L.sarjaid=S.sarjaid AND L.leffaid=E.leffaid AND L.sarjaid in (SELECT sarjaid FROM SarjaLaari WHERE leffaid= :leffaid) ORDER BY E.vuosi');
        $query->execute(array('leffaid' => $lid));
        $tulokset = $query->fetchAll();

        $sarjat = array();

        foreach ($tulokset as $tulos) {
            $sarjat[] = new Sarjalaari(array(
                'sarjaid' => $tulos['sarjaid'],
                'leffaid' => $tulos['leffaid'],
                'sarjanimi' => $tulos['sarjanimi'],
                'leffanimi' => $tulos['leffanimi']
            ));
        }
        return $sarjat;
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO SarjaLaari (sarjaid, leffaid) VALUES (:sarjaid, :leffaid) RETURNING sarjaid');
        $query->execute(array(
            'sarjaid' => $this->sarjaid,
            'leffaid' => $this->leffaid
        ));
    }

}
