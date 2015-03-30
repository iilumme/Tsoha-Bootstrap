<?php

class Elokuva extends BaseModel {

    public $leffaid, $leffanimi, $vuosi, $valtio, $kieli,
            $kuva, $synopsis, $traileriurl, $lisatty, $viimeksimuutettu;

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

            $elokuvat = array();
            $elokuvat[] = $elokuva;
            return $elokuvat;
        }

        return null;
    }

    public static function findElokuvatForArtisti($id) {
        $query = DB::connection()->prepare('SELECT E.leffaid, leffaNimi '
                . 'FROM ArtistiLaari A, Elokuva E '
                . 'WHERE A.leffaID=E.leffaID AND A.artistiID= :artistiid');
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

    public static function findElokuvatForValtiot($id) {
        $query = DB::connection()->prepare('SELECT * FROM Elokuva WHERE valtio= :valtio');
        $query->execute(array('valtio' => $id));
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

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Elokuva '
                . '(leffanimi, vuosi, valtio, kieli, synopsis, traileriurl, lisatty, viimeksiMuutettu) '
                . 'VALUES (:leffanimi, :vuosi, :valtio, :kieli, :synopsis, :traileriurl, NOW(), NOW()) '
                . 'RETURNING leffaid');
        $query->execute(array(
            'leffanimi' => $this->leffanimi,
            'vuosi' => $this->vuosi,
            'valtio' => $this->valtio,
            'kieli' => $this->kieli,
            'synopsis' => $this->synopsis,
            'traileriurl' => $this->traileriurl
        ));

        $tulos = $query->fetch();
        $this->leffaid = $tulos['leffaid'];
    }

}
