<?php

class Valtio extends BaseModel {

    public $valtioid, $valtionimi, $valtiobio, $lippu;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Valtiot');
        $query->execute();
        $tulokset = $query->fetchAll();

        $valtiot = array();

        foreach ($tulokset as $tulos) {
            $valtiot[] = new Valtio(array(
                'valtioid' => $tulos['valtioid'],
                'valtionimi' => $tulos['valtionimi'],
                'valtiobio' => $tulos['valtiobio'],
                'lippu' => $tulos['lippu']
            ));
        }
        
        return $valtiot;
    }

    public static function findOne($id) {
        $query = DB::connection()->prepare('SELECT * FROM Valtiot WHERE valtioid = :valtioid LIMIT 1');
        $query->execute(array('valtioid' => $id));
        $tulos = $query->fetch();

        if ($tulos) {
            $valtio = new Valtio(array(
                'valtioid' => $tulos['valtioid'],
                'valtionimi' => $tulos['valtionimi'],
                'valtiobio' => $tulos['valtiobio'],
                'lippu' => $tulos['lippu']
            ));
        }

        return $valtio;
    }

}
