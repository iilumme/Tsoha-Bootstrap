<?php

class Kayttaja extends BaseModel {

    public $kayttajaid, $kayttajatunnus, $nimi, $salasana, $lempigenre, $rekisteroitynyt, $viimeksimuutettu;

    public function __construct($attribuutit) {
        parent::__construct($attribuutit);
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Kayttaja');
        $query->execute();
        $tulokset = $query->fetchAll();

        $kayttajat = array();

        foreach ($tulokset as $tulos) {
            $kayttajat[] = new Kayttaja(array(
                'kayttajaid' => $tulos['kayttajaid'],
                'kayttajatunnus' => $tulos['kayttajatunnus'],
                'nimi' => $tulos['nimi'],
                'salasana' => $tulos['salasana'],
                'lempigenre' => $tulos['lempigenre'],
                'rekisteroitynyt' => $tulos['rekisteroitynyt'],
                'viimeksimuutettu' => $tulos['viimeksimuutettu']
            ));
        }
        return $kayttajat;
    }

    public static function findOne($id) {
        $query = DB::connection()->prepare('SELECT * FROM Kayttaja WHERE kayttajaid = :kayttajaid LIMIT 1');
        $query->execute(array('kayttajaid' => $id));
        $tulos = $query->fetch();

        if ($tulos) {
            $kayttaja = new Kayttaja(array(
                'kayttajaid' => $tulos['kayttajaid'],
                'kayttajatunnus' => $tulos['kayttajatunnus'],
                'nimi' => $tulos['nimi'],
                'salasana' => $tulos['salasana'],
                'lempigenre' => $tulos['lempigenre'],
                'rekisteroitynyt' => $tulos['rekisteroitynyt'],
                'viimeksimuutettu' => $tulos['viimeksimuutettu']
            ));
            return $kayttaja;
        }

        return null;
    }

}
