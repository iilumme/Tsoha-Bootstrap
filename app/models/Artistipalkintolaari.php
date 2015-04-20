<?php

//EI VIELÄ KÄYTÖSSÄ :)

class Artistipalkintolaari extends BaseModel {

    public $palkintoid, $artistiid, $voitettu;

    public function __construct($attribuutit) {
        parent::__construct($attribuutit);
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM ArtistiPalkintoLaari');
        $query->execute();
        $tulokset = $query->fetchAll();

        $artistipalkinnot = array();

        foreach ($tulokset as $tulos) {
            $artistipalkinnot[] = new Artistipalkintolaari(array(
                'palkintoid' => $tulos['palkintoid'],
                'artistiid' => $tulos['artistiid'],
                'voitettu' => $tulos['voitettu']
            ));
        }
        return $artistipalkinnot;
    }

    public static function findOne($pid, $aid) {
        $query = DB::connection()->prepare('SELECT * FROM ArtistiPalkintoLaari WHERE palkintoid = :palkintoid AND artistiid = :artistiid LIMIT 1');
        $query->execute(array('palkintoid' => $pid, 'artistiid' => $aid));
        $tulos = $query->fetch();

        if ($tulos) {
            $palkinto = new Artistipalkintolaari(array(
                'palkintoid' => $tulos['palkintoid'],
                'artistiid' => $tulos['artistiid'],
                'voitettu' => $tulos['voitettu']
            ));
            return $palkinto;
        }

        return null;
    }

}
