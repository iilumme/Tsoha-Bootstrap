<?php

class DVDlista extends BaseModel {

    public $kayttajaid, $leffaid;

    public function __construct($attribuutit) {
        parent::__construct($attribuutit);
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM DVDLista');
        $query->execute();
        $tulokset = $query->fetchAll();

        $listat = array();

        foreach ($tulokset as $tulos) {
            $listat[] = new DVDlista(array(
                'kayttajaid' => $tulos['kayttajaid'],
                'leffaid' => $tulos['leffaid']
            ));
        }
        return $listat;
    }

    public static function findOne($kid, $lid) {
        $query = DB::connection()->prepare('SELECT * FROM DVDLista WHERE kayttajaid = :kayttajaid AND leffaid = :leffaid LIMIT 1');
        $query->execute(array('kayttajaid' => $kid, 'leffaid' => $lid));
        $tulos = $query->fetch();

        if ($tulos) {
            $lista = new DVDlista(array(
                'kayttajaid' => $tulos['kayttajaid'],
                'leffaid' => $tulos['leffaid']
            ));
            return $lista;
        }

        return null;
    }

}
