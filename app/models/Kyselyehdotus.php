<?php

/* Malli käyttäjän ehdotukselle */

class Kyselyehdotus extends BaseModel {

    public $kyselyid, $kysely, $lisatty;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    /* Haetaan ryhmän kyselyt */
    public static function allGroup_s_queries($ryhmaid) {
        $query = DB::connection()->prepare('SELECT * FROM KyselyryhmaLaari L, Kyselyehdotus E '
                . 'WHERE L.kyselyID=E.kyselyID AND ryhmaID = :ryhmaid ORDER BY E.kyselyid');
        $query->execute(array('ryhmaid' => $ryhmaid));
        $rows = $query->fetchAll();

        $kyselyt = array();

        foreach ($rows as $row) {
            $kyselyt[] = new Kyselyehdotus(array(
                'kyselyid' => $row['kyselyid'],
                'kysely' => $row['kysely'],
                'lisatty' => $row['lisatty']
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

        $row = $query->fetch();
        $this->kyselyid = $row['kyselyid'];
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
//        $rows = $query->fetchAll();
//
//        $kyselyt = array();
//
//        foreach ($rows as $row) {
//            $kyselyt[] = new Kyselyehdotus(array(
//                'kyselyid' => $row['kyselyid'],
//                'kysely' => $row['kysely'],
//                'lisatty' => $row['lisatty']
//            ));
//        }
//        return $kyselyt;
//    }
//    public static function findOne($ryhmaid, $id) {
//        $query = DB::connection()->prepare('SELECT * FROM Kyselyehdotus WHERE kyselyID = :kyselyid LIMIT 1');
//        $query->execute(array('kyselyid' => $id));
//        $row = $query->fetch();
//
//        if ($row) {
//            $kysely = new Kyselyehdotus(array(
//                'kyselyid' => $row['kyselyid'],
//                'kysely' => $row['kysely'],
//                'lisatty' => $row['lisatty']
//            ));
//            return $kysely;
//        }
//
//        return null;
//    }
}
