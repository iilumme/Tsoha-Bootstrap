<?php

class Lista extends BaseModel {

    public $kayttajatunnus;

    public function __construct($attribuutit) {
        parent::__construct($attribuutit);
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT K.kayttajaTunnus FROM DVDLista D, Kayttaja K WHERE D.kayttajaID=K.kayttajaID AND leffaid = :leffaid ORDER BY K.kayttajatunnus');
        $query->execute(array('leffaid' => $id));
        $tulokset = $query->fetchAll();

        $kayttajat = array();

        foreach ($tulokset as $tulos) {
            $kayttajat[] = new Lista(array(
                'kayttajatunnus' => $tulos['kayttajatunnus']
            ));
        }

        return $kayttajat;
    }

}
