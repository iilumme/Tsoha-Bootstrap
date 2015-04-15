<?php

class Sarjalaari extends BaseModel {

    public $sarjaid, $leffaid, $sarjanimi, $leffanimi;

    public function __construct($attribuutit) {
        parent::__construct($attribuutit);
    }

    private static function createSarjaLaari($tulos) {
        return new Sarjalaari(array(
            'sarjaid' => $tulos['sarjaid'],
            'leffaid' => $tulos['leffaid'],
            'sarjanimi' => $tulos['sarjanimi'],
            'leffanimi' => $tulos['leffanimi']
        ));
    }

    public static function findSarjanElokuvat($lid) {
        $query = DB::connection()->prepare('SELECT L.sarjaid, L.leffaid, S.sarjanimi, E.leffanimi '
                . 'FROM SarjaLaari L, Sarja S, Elokuva E '
                . 'WHERE L.sarjaid=S.sarjaid AND L.leffaid=E.leffaid '
                . 'AND L.sarjaid in (SELECT sarjaid FROM SarjaLaari WHERE leffaid= :leffaid) '
                . 'ORDER BY E.vuosi');
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
        $query = DB::connection()->prepare('INSERT INTO SarjaLaari (sarjaid, leffaid) '
                . 'VALUES (:sarjaid, :leffaid) RETURNING sarjaid');
        $query->execute(array(
            'sarjaid' => $this->sarjaid,
            'leffaid' => $this->leffaid
        ));
    }

}
