<?php

class Artisti extends BaseModel {

    public $artistiid, $artistityyppi, $etunimi, $sukunimi, $bio, $kuva, $syntymavuosi, $valtio, $lisatty, $viimeksimuutettu;

    public function __construct($attribuutit) {
        parent::__construct($attribuutit);
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Artisti');
        $query->execute();
        $tulokset = $query->fetchAll();

        $artistit = array();

        foreach ($tulokset as $tulos) {
            $artistit[] = new Artisti(array(
                'artistiid' => $tulos['artistiid'],
                'artistityyppi' => $tulos['artistityyppi'],
                'etunimi' => $tulos['etunimi'],
                'sukunimi' => $tulos['sukunimi'],
                'bio' => $tulos['bio'],
                'kuva' => $tulos['kuva'],
                'syntymavuosi' => $tulos['syntymavuosi'],
                'valtio' => $tulos['valtio'],
                'lisatty' => $tulos['lisatty'],
                'viimeksimuutettu' => $tulos['viimeksimuutettu']
            ));
        }
        return $artistit;
    }

    public static function findOne($id) {
        $query = DB::connection()->prepare('SELECT * FROM Artisti WHERE artistiid = :artistiid LIMIT 1');
        $query->execute(array('artistiid' => $id));
        $tulos = $query->fetch();

        if ($tulos) {
            $artisti = new Artisti(array(
                'artistiid' => $tulos['artistiid'],
                'artistityyppi' => $tulos['artistityyppi'],
                'etunimi' => $tulos['etunimi'],
                'sukunimi' => $tulos['sukunimi'],
                'bio' => $tulos['bio'],
                'kuva' => $tulos['kuva'],
                'syntymavuosi' => $tulos['syntymavuosi'],
                'valtio' => $tulos['valtio'],
                'lisatty' => $tulos['lisatty'],
                'viimeksimuutettu' => $tulos['viimeksimuutettu']
            ));
            return $artisti;
        }

        return null;
    }

}
