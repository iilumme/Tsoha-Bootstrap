<?php

class Kyselyehdotus extends BaseModel {

    public $kyselyid, $kysely, $lisatty;

    public function __construct($attribuutit) {
        parent::__construct($attribuutit);
    }

    public static function findOne($ryhmaid, $id) {
        $query = DB::connection()->prepare('SELECT * FROM Kyselyehdotus WHERE kyselyID = :kyselyid LIMIT 1');
        $query->execute(array('kyselyid' => $id));
        $tulos = $query->fetch();

        if ($tulos) {
            $kysely = new Kyselyehdotus(array(
                'kyselyid' => $tulos['kyselyid'],
                'kysely' => $tulos['kysely'],
                'lisatty' => $tulos['lisatty']
            ));
            return $kysely;
        }

        return null;
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Kyselyehdotus ORDER BY lisatty');
        $query->execute();
        $tulokset = $query->fetchAll();

        $kyselyt = array();

        foreach ($tulokset as $tulos) {
            $kyselyt[] = new Kyselyehdotus(array(
                'kyselyid' => $tulos['kyselyid'],
                'kysely' => $tulos['kysely'],
                'lisatty' => $tulos['lisatty']
            ));
        }
        return $kyselyt;
    }

    public static function allGroup_s_queries($ryhmaid) {
        $query = DB::connection()->prepare('SELECT * FROM KyselyryhmaLaari L, Kyselyehdotus E '
                . 'WHERE L.kyselyID=E.kyselyID AND ryhmaID = :ryhmaid ORDER BY E.kyselyid');
        $query->execute(array('ryhmaid' => $ryhmaid));
        $tulokset = $query->fetchAll();

        $kyselyt = array();

        foreach ($tulokset as $tulos) {
            $kyselyt[] = new Kyselyehdotus(array(
                'kyselyid' => $tulos['kyselyid'],
                'kysely' => $tulos['kysely'],
                'lisatty' => $tulos['lisatty']
            ));
        }
        return $kyselyt;
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Kyselyehdotus (kysely, lisatty) '
                . 'VALUES (:kysely ,NOW())  RETURNING kyselyID');
        $query->execute(array(
            'kysely' => $this->kysely
        ));

        $tulos = $query->fetch();
        $this->kyselyid = $tulos['kyselyid'];
    }

    public static function execute($ryhmaid) {

        $kyselyt = Kyselyehdotus::allGroup_s_queries($ryhmaid);
        $leffaid;
        $artistiid;
        $genreid;
        $sarjaid;

        foreach ($kyselyt as $kysely) {

            if (strpos($kysely->kysely, ':leffaid') && strpos($kysely->kysely, ':artistiid')) {
                
                $query = DB::connection()->prepare($kysely->kysely);
                $query->execute(array('leffaid' => $leffaid, 'artistiid' => $artistiid));
                
            } elseif (strpos($kysely->kysely, ':leffaid') && strpos($kysely->kysely, ':genreid')) {
                
                $query = DB::connection()->prepare($kysely->kysely);
                $query->execute(array('leffaid' => $leffaid, 'genreid' => $genreid));
                
            } elseif (strpos($kysely->kysely, ':leffaid') && strpos($kysely->kysely, ':sarjaid')) {
                
                $query = DB::connection()->prepare($kysely->kysely);
                $query->execute(array('leffaid' => $leffaid, 'sarjaid' => $sarjaid));
                
            } elseif (strpos($kysely->kysely, ':leffaid')) {
                
                $query = DB::connection()->prepare($kysely->kysely);
                $query->execute(array('leffaid' => $leffaid));
                
            } elseif (strpos($kysely->kysely, ':artistiid')) {
                
                $query = DB::connection()->prepare($kysely->kysely);
                $query->execute(array('artistiid' => $artistiid));
                
            } elseif (strpos($kysely->kysely, ':genreid')) {
                
                $query = DB::connection()->prepare($kysely->kysely);
                $query->execute(array('genreid' => $genreid));
                
            } elseif (strpos($kysely->kysely, ':sarjaid')) {
                
                $query = DB::connection()->prepare($kysely->kysely);
                $query->execute(array('sarjaid' => $sarjaid));
                
            } else {
                
                $query = DB::connection()->prepare($kysely->kysely);
                $query->execute();
                $tulos = $query->fetch();
                if (isset($tulos['leffaid'])) {
                    $leffaid = $tulos['leffaid'];
                }

                if (isset($tulos['artistiid'])) {
                    $artistiid = $tulos['artistiid'];
                }

                if (isset($tulos['genreid'])) {
                    $genreid = $tulos['genreid'];
                }

                if (isset($tulos['sarjaid'])) {
                    $sarjaid = $tulos['sarjaid'];
                }
            }
        }

        Kyselyehdotus::destroy($ryhmaid);
    }

    public static function destroy($ryhmaid) {

        $kyselyt = Kyselyehdotus::allGroup_s_queries($ryhmaid);
        $query = DB::connection()->prepare('DELETE FROM Kyselyryhma WHERE ryhmaID = :ryhmaid');
        $query->execute(array('ryhmaid' => $ryhmaid));

        foreach ($kyselyt as $k) {
            $query = DB::connection()->prepare('DELETE FROM Kyselyehdotus '
                    . 'WHERE kyselyID = :kyselyid');
            $query->execute(array('kyselyid' => $k->kyselyid));
        }
    }

}
