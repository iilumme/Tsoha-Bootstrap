<?php

/* Malli käyttäjän ehdotukselle */

class Kyselyehdotus extends BaseModel {

    public $kyselyid, $kysely, $lisatty;

    public function __construct($attribuutit) {
        parent::__construct($attribuutit);
    }

    /* Haetaan ryhmän kyselyt */
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

    /* Tallennetaan kyselyehdotus */
    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Kyselyehdotus (kysely, lisatty) '
                . 'VALUES (:kysely ,NOW()) RETURNING kyselyID');
        $query->execute(array(
            'kysely' => $this->kysely
        ));

        $tulos = $query->fetch();
        $this->kyselyid = $tulos['kyselyid'];
    }

    /* Poistetaan kysely */
    public static function destroy($kyselyid) {
        $query = DB::connection()->prepare('DELETE FROM Kyselyehdotus '
                . 'WHERE kyselyID = :kyselyid');
        $query->execute(array('kyselyid' => $kyselyid));
    }

    
    
    

//    public static function all() {
//        $query = DB::connection()->prepare('SELECT * FROM Kyselyehdotus ORDER BY lisatty');
//        $query->execute();
//        $tulokset = $query->fetchAll();
//
//        $kyselyt = array();
//
//        foreach ($tulokset as $tulos) {
//            $kyselyt[] = new Kyselyehdotus(array(
//                'kyselyid' => $tulos['kyselyid'],
//                'kysely' => $tulos['kysely'],
//                'lisatty' => $tulos['lisatty']
//            ));
//        }
//        return $kyselyt;
//    }
//    public static function findOne($ryhmaid, $id) {
//        $query = DB::connection()->prepare('SELECT * FROM Kyselyehdotus WHERE kyselyID = :kyselyid LIMIT 1');
//        $query->execute(array('kyselyid' => $id));
//        $tulos = $query->fetch();
//
//        if ($tulos) {
//            $kysely = new Kyselyehdotus(array(
//                'kyselyid' => $tulos['kyselyid'],
//                'kysely' => $tulos['kysely'],
//                'lisatty' => $tulos['lisatty']
//            ));
//            return $kysely;
//        }
//
//        return null;
//    }
}
