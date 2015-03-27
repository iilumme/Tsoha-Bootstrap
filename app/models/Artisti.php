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

    public static function findValtio($id) {
        $query = DB::connection()->prepare('SELECT valtioid, valtionimi, valtiobio, lippu FROM Valtiot, Artisti WHERE Artisti.artistiid = :artistiid and Artisti.valtio = Valtiot.valtioid LIMIT 1');
        $query->execute(array('artistiid' => $id));
        $tulos = $query->fetch();

        if ($tulos) {
            $valtio = new Valtio(array(
                'valtioid' => $tulos['valtioid'],
                'valtionimi' => $tulos['valtionimi'],
                'valtiobio' => $tulos['valtiobio'],
                'lippu' => $tulos['lippu']
            ));
            return $valtio;
        }

        return null;
    }
   
    public static function findElokuvat($id) {
        $query = DB::connection()->prepare('SELECT E.leffaid, leffaNimi FROM ArtistiLaari A, Elokuva E WHERE A.leffaID=E.leffaID AND A.artistiID= :artistiid');
        $query->execute(array('artistiid' => $id));
        $tulokset = $query->fetchAll();

        $elokuvat = array();

        foreach ($tulokset as $tulos) {
            $elokuvat[] = new Elokuva(array(
                'leffaid' => $tulos['leffaid'],
                'leffanimi' => $tulos['leffanimi']
            ));
        }
        return $elokuvat;
    }
    
    public static function findAllArtistit($n) {
        $query = DB::connection()->prepare('SELECT R.artistiID, R.artistityyppi, R.etunimi, R.sukunimi, R.bio, R.kuva, R.syntymavuosi, R.valtio, R.lisatty, R.viimeksimuutettu FROM Artisti R WHERE R.artistityyppi= :n ORDER BY R.sukunimi');
        $query->execute(array('n' => $n));
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
    
    public static function findArtistitForElokuva($id, $n) {
        $query = DB::connection()->prepare('SELECT R.artistiID, R.artistityyppi, R.etunimi, R.sukunimi, R.bio, R.kuva, R.syntymavuosi, R.valtio, R.lisatty, R.viimeksimuutettu FROM Elokuva E, ArtistiLaari A, Artisti R WHERE E.leffaid = :leffaid AND E.leffaid=A.leffaid AND A.artistiID=R.artistiID AND R.artistityyppi= :n ORDER BY R.sukunimi');
        $query->execute(array('leffaid' => $id, 'n' => $n));
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

}
