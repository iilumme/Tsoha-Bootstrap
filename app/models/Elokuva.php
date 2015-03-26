<?php

class Elokuva extends BaseModel {

    public $leffaid, $leffanimi, $vuosi, $valtio, $kieli, $kuva, $synopsis, $traileriurl, $lisatty, $viimeksimuutettu;

    public function __construct($attribuutit) {
        parent::__construct($attribuutit);
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Elokuva');
        $query->execute();
        $tulokset = $query->fetchAll();

        $elokuvat = array();

        foreach ($tulokset as $tulos) {
            $elokuvat[] = new Elokuva(array(
                'leffaid' => $tulos['leffaid'],
                'leffanimi' => $tulos['leffanimi'],
                'vuosi' => $tulos['vuosi'],
                'valtio' => $tulos['valtio'],
                'kieli' => $tulos['kieli'],
                'synopsis' => $tulos['synopsis'],
                'traileriurl' => $tulos['traileriurl'],
                'lisatty' => $tulos['lisatty'],
                'viimeksimuutettu' => $tulos['viimeksimuutettu']
            ));
        }
        return $elokuvat;
    }

    public static function findOne($id) {
        $query = DB::connection()->prepare('SELECT * FROM Elokuva WHERE leffaid = :leffaid LIMIT 1');
        $query->execute(array('leffaid' => $id));
        $tulos = $query->fetch();

        if ($tulos) {
            $elokuva = new Elokuva(array(
                'leffaid' => $tulos['leffaid'],
                'leffanimi' => $tulos['leffanimi'],
                'vuosi' => $tulos['vuosi'],
                'valtio' => $tulos['valtio'],
                'kieli' => $tulos['kieli'],
                'synopsis' => $tulos['synopsis'],
                'traileriurl' => $tulos['traileriurl'],
                'lisatty' => $tulos['lisatty'],
                'viimeksimuutettu' => $tulos['viimeksimuutettu']
            ));
            return $elokuva;
        }

        return null;
    }

    public static function findValtio($id) {
        $query = DB::connection()->prepare('SELECT valtioid, valtionimi, valtiobio, lippu FROM Valtiot, Elokuva WHERE Elokuva.leffaid = :leffaid and Elokuva.valtio = Valtiot.valtioid LIMIT 1');
        $query->execute(array('leffaid' => $id));
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

    public static function findArtistit($id, $n) {
        $query = DB::connection()->prepare('SELECT R.artistiID, R.artistityyppi, R.etunimi, R.sukunimi, R.bio, R.kuva, R.syntymavuosi, R.valtio, R.lisatty, R.viimeksimuutettu FROM Elokuva E, ArtistiLaari A, Artisti R WHERE E.leffaid = :leffaid AND E.leffaid=A.leffaid AND A.artistiID=R.artistiID AND R.artistityyppi= :n ORDER BY R.sukunimi');
        $query->execute(array('leffaid' => $id, 'n' => $n));
        $tulokset = $query->fetchAll();

        $nayttelijat = array();

        foreach ($tulokset as $tulos) {
            $nayttelijat[] = new Artisti(array(
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
        return $nayttelijat;
    }

    public static function findGenret($id) {
        $query = DB::connection()->prepare('SELECT G.genreID, G.genreNimi FROM Elokuva E, GenreLaari L, Genre G WHERE E.leffaid = :leffaid AND E.leffaid=L.leffaid AND L.genreID=G.genreID ORDER BY G.genrenimi');
        $query->execute(array('leffaid' => $id));
        $tulokset = $query->fetchAll();

        $genret = array();

        foreach ($tulokset as $tulos) {
            $genret[] = new Genre(array(
                'genreid' => $tulos['genreid'],
                'genrenimi' => $tulos['genrenimi']
            ));
        }
        return $genret;
    }
    
    public static function findPalkinnot($id) {
        $query = DB::connection()->prepare('SELECT P.palkintoID, P.palkintoNimi FROM Elokuva E, LeffaPalkintoLaari L, Palkinto P WHERE E.leffaid = :leffaid AND E.leffaid=L.leffaid AND L.palkintoID=P.palkintoID ORDER BY P.palkintonimi');
        $query->execute(array('leffaid' => $id));
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
    
    public static function findArviot($id) {
        $query = DB::connection()->prepare('SELECT A.kayttajaID, K.kayttajaTunnus, A.leffaID, A.tahti, A.lisatty FROM Elokuva E, ArvioLaari A, Kayttaja K WHERE E.leffaid = :leffaid AND E.leffaid=A.leffaid AND A.kayttajaID=K.kayttajaID ORDER BY A.lisatty');
        $query->execute(array('leffaid' => $id));
        $tulokset = $query->fetchAll();

        $arviot = array();

        foreach ($tulokset as $tulos) {
            $arviot[] = new Arviolaari(array(
                'kayttajaid' => $tulos['kayttajaid'],
                'kayttajatunnus' => $tulos['kayttajatunnus'],
                'leffaid' => $tulos['leffaid'],
                'tahti' => $tulos['tahti'],
                'lisatty' => $tulos['lisatty']
            ));
        }
        return $arviot;
    }
    

}
