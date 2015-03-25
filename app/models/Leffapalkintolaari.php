<?php

class Leffapalkintolaari extends BaseModel {

    public $palkintoid, $leffaid, $voitettu;

    public function __construct($attribuutit) {
        parent::__construct($attribuutit);
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM LeffaPalkintoLaari');
        $query->execute();
        $tulokset = $query->fetchAll();

        $leffapalkinnot = array();

        foreach ($tulokset as $tulos) {
            $leffapalkinnot[] = new Leffapalkintolaari(array(
                'palkintoid' => $tulos['palkintoid'],
                'leffaid' => $tulos['leffaid'],
                'voitettu' => $tulos['voitettu']
            ));
        }
        return $leffapalkinnot;
    }

    public static function findOne($pid, $lid) {
        $query = DB::connection()->prepare('SELECT * FROM LeffaPalkintoLaari WHERE palkintoid = :palkintoid AND leffaid = :leffaid LIMIT 1');
        $query->execute(array('palkintoid' => $pid, 'leffaid' => $lid));
        $tulos = $query->fetch();

        if ($tulos) {
            $palkinto = new Leffapalkintolaari(array(
                'palkintoid' => $tulos['palkintoid'],
                'leffaid' => $tulos['leffaid'],
                'voitettu' => $tulos['voitettu']
            ));
            return $palkinto;
        }

        return null;
    }

}
