<?php

class Elokuva extends BaseModel {

    public $leffaID, $leffaNimi, $vuosi, $valtio, $kieli, $kuva, $synopsis, $traileriURL, $lisatty, $viimeksiMuutettu;

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
                'leffaID' => $tulos['leffaID'],
                'leffaNimi' => $tulos['leffaNimi'],
                'vuosi' => $tulos['vuosi'],
                'valtio' => $tulos['valtio'],
                'kieli' => $tulos['kieli'],
                'synopsis' => $tulos['synopsis'],
                'traileriURL' => $tulos['traileriURL'],
                'lisatty' => $tulos['lisatty'],
                'viimeksiMuutettu' => $tulos['viimeksiMuutettu']
                    )
            );
        }
        return $elokuvat;
    }

    public static function findOne($id) {
        $query = DB::connection()->prepare('SELECT * FROM Elokuva WHERE leffaID = :leffaID LIMIT 1');
        $query->execute(array('leffaID' => $id));
        $tulos = $query->fetch();

        if ($tulos) {
            $elokuva = new Elokuva(array(
                'leffaID' => $tulos['leffaID'],
                'leffaNimi' => $tulos['leffaNimi'],
                'vuosi' => $tulos['vuosi'],
                'valtio' => $tulos['valtio'],
                'kieli' => $tulos['kieli'],
                'synopsis' => $tulos['synopsis'],
                'traileriURL' => $tulos['traileriURL'],
                'lisatty' => $tulos['lisatty'],
                'viimeksiMuutettu' => $tulos['viimeksiMuutettu']
            ));
            return $elokuva;
        }

        return null;
    }

}
