<?php

class Palkinto extends BaseModel {

    public $palkintoid, $palkintonimi;

    public function __construct($attribuutit) {
        parent::__construct($attribuutit);
    }

    private static function createPalkinto($tulos) {
        return new Palkinto(array(
            'palkintoid' => $tulos['palkintoid'],
            'palkintonimi' => $tulos['palkintonimi']
        ));
    }

    public static function findPalkinnotForElokuva($id) {
        $query = DB::connection()->prepare('SELECT P.palkintoID, P.palkintoNimi '
                . 'FROM Elokuva E, LeffaPalkintoLaari L, Palkinto P '
                . 'WHERE E.leffaid = :leffaid AND E.leffaid=L.leffaid AND L.palkintoID=P.palkintoID '
                . 'ORDER BY P.palkintonimi');
        $query->execute(array('leffaid' => $id));
        $tulokset = $query->fetchAll();

        $palkinnot = array();
        foreach ($tulokset as $tulos) {
            $palkinnot[] = Palkinto::createPalkinto($tulos);
        }
        return $palkinnot;
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Palkinto');
        $query->execute();
        $tulokset = $query->fetchAll();

        $palkinnot = array();

        foreach ($tulokset as $tulos) {
            $palkinnot[] = Palkinto::createPalkinto($tulos);
        }
        return $palkinnot;
    }

    public static function findOne($id) {
        $query = DB::connection()->prepare('SELECT * FROM Palkinto WHERE palkintoid = :palkintoid LIMIT 1');
        $query->execute(array('palkintoid' => $id));
        $tulos = $query->fetch();

        if ($tulos) {
            $palkinto = Palkinto::createPalkinto($tulos);
            return $palkinto;
        }

        return null;
    }

}
