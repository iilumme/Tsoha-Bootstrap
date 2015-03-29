<?php

class Artisti extends BaseModel {

    public $artistiid, $artistityyppi, $etunimi, $sukunimi, $bio,
            $kuva, $syntymavuosi, $valtio, $lisatty, $viimeksimuutettu;

    public function __construct($attribuutit) {
        parent::__construct($attribuutit);
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Artisti');
        $query->execute();
        $tulokset = $query->fetchAll();

        $artistit = array();

        foreach ($tulokset as $tulos) {
            $artistit[] = Artisti::createArtisti($tulos);
        }
        return $artistit;
    }

    public static function findOne($id) {
        $query = DB::connection()->prepare('SELECT * FROM Artisti WHERE artistiid = :artistiid LIMIT 1');
        $query->execute(array('artistiid' => $id));
        $tulos = $query->fetch();

        if ($tulos) {
            $artisti = Artisti::createArtisti($tulos);
            return $artisti;
        }

        return null;
    }

    public static function findAllArtistit($n) {
        $query = DB::connection()->prepare('SELECT * FROM Artisti R '
                . 'WHERE R.artistityyppi= :n ORDER BY R.sukunimi');
        $query->execute(array('n' => $n));
        $tulokset = $query->fetchAll();

        $artistit = array();

        foreach ($tulokset as $tulos) {
            $artistit[] = Artisti::createArtisti($tulos);
        }
        return $artistit;
    }

    public static function findArtistitForElokuva($id, $n) {
        $query = DB::connection()->prepare('SELECT R.artistiID, R.artistityyppi, R.etunimi, R.sukunimi, R.bio, R.kuva, R.syntymavuosi, R.valtio, R.lisatty, R.viimeksimuutettu '
                . 'FROM Elokuva E, ArtistiLaari A, Artisti R '
                . 'WHERE E.leffaid = :leffaid AND E.leffaid=A.leffaid AND A.artistiID=R.artistiID AND R.artistityyppi= :n ORDER BY R.sukunimi');
        $query->execute(array('leffaid' => $id, 'n' => $n));
        $tulokset = $query->fetchAll();

        $artistit = array();

        foreach ($tulokset as $tulos) {
            $artistit[] = Artisti::createArtisti($tulos);
        }
        return $artistit;
    }

    private static function createArtisti($tulos) {
        return new Artisti(array(
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
    
    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Artisti '
                . '(artistiTyyppi, etuNimi, sukuNimi, bio, syntymavuosi, valtio, lisatty, viimeksiMuutettu) '
                . 'VALUES  (:artistityyppi, :etunimi, :sukunimi, :bio, :syntymavuosi, :valtio, NOW(), NOW()) '
                . 'RETURNING artistiid');
        $query->execute(array(
            'artistityyppi' => $this->artistityyppi,
            'etunimi' => $this->etunimi,
            'sukunimi' => $this->sukunimi,
            'bio' => $this->bio,
            'syntymavuosi' => $this->syntymavuosi,
            'valtio' => $this->valtio           
        ));

        $tulos = $query->fetch();
        $this->artistiid = $tulos['artistiid'];      
    }

}
