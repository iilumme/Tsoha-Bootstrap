<?php

class Palkinto extends BaseModel {

    public $palkintoid, $palkintonimi;

    public function __construct($attribuutit) {
        parent::__construct($attribuutit);
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Palkinto');
        $query->execute();
        $tulokset = $query->fetchAll();

        $palkinnot = array();

        foreach ($tulokset as $tulos) {
            $palkinnot[] = new Palkinto(array(
                'palkintoid' => $tulos['palkintoid'],
                'palkintonimi' => $tulos['palkintonimi']
            ));
        }
        return $palkinnot;
    }

    public static function findOne($id) {
        $query = DB::connection()->prepare('SELECT * FROM Palkinto WHERE palkintoid = :palkintoid LIMIT 1');
        $query->execute(array('palkintoid' => $id));
        $tulos = $query->fetch();

        if ($tulos) {
            $palkinto = new Palkinto(array(
                'palkintoid' => $tulos['palkintoid'],
                'palkintonimi' => $tulos['palkintonimi']
            ));
            return $palkinto;
        }

        return null;
    }

}
