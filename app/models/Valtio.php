<?php

class Valtio extends BaseModel {

    public $valtioid, $valtionimi, $valtiobio, $lippu;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    private static function createValtio($tulos) {
        return new Valtio(array(
            'valtioid' => $tulos['valtioid'],
            'valtionimi' => $tulos['valtionimi'],
            'valtiobio' => $tulos['valtiobio'],
            'lippu' => $tulos['lippu']
        ));
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Valtiot ORDER BY valtionimi');
        $query->execute();
        $tulokset = $query->fetchAll();

        $valtiot = array();
        foreach ($tulokset as $tulos) {
            $valtiot[] = Valtio::createValtio($tulos);
        }

        return $valtiot;
    }

    public static function findOne($id) {
        $query = DB::connection()->prepare('SELECT * FROM Valtiot WHERE valtioid = :valtioid LIMIT 1');
        $query->execute(array('valtioid' => $id));
        $tulos = $query->fetch();

        if ($tulos) {
            $valtio = Valtio::createValtio($tulos);
            return $valtio;
        }

        return null;
    }

    public static function findValtioForElokuva($leffaid) {
        $query = DB::connection()->prepare('SELECT valtioid, valtionimi, valtiobio, lippu '
                . 'FROM Valtiot, Elokuva '
                . 'WHERE Elokuva.leffaid = :leffaid and Elokuva.valtio = Valtiot.valtioid LIMIT 1');
        $query->execute(array('leffaid' => $leffaid));
        $tulos = $query->fetch();

        if ($tulos) {
            $valtio = Valtio::createValtio($tulos);
            return $valtio;
        }

        return null;
    }

    public static function findValtioForArtisti($id) {
        $query = DB::connection()->prepare('SELECT valtioid, valtionimi, valtiobio, lippu '
                . 'FROM Valtiot, Artisti '
                . 'WHERE Artisti.artistiid = :artistiid and Artisti.valtio = Valtiot.valtioid LIMIT 1');
        $query->execute(array('artistiid' => $id));
        $tulos = $query->fetch();

        if ($tulos) {
            $valtio = Valtio::createValtio($tulos);
            return $valtio;
        }

        return null;
    }

    public function update() {
        $query = DB::connection()->prepare('UPDATE Valtiot '
                . 'SET valtiobio = :valtiobio '
                . 'WHERE valtioid = :valtioid RETURNING valtioid;');
        $query->execute(array(
            'valtioid' => $this->valtioid,
            'valtiobio' => $this->valtiobio
        ));

        $tulos = $query->fetch();
        return $tulos['valtioid'];
    }

}
