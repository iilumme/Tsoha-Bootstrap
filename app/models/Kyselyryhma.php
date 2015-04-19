<?php

class Kyselyryhma extends BaseModel {

    public $ryhmaid;

    public function __construct($attribuutit) {
        parent::__construct($attribuutit);
    }

    public static function findOneGroup($ryhmaid) {
        $query = DB::connection()->prepare('SELECT * '
                . 'FROM Kyselyryhma '
                . 'WHERE ryhmaID = :ryhmaid '
                . 'ORDER BY ryhmaid');
        $query->execute(array('ryhmaid' => $ryhmaid));

        $tulos = $query->fetch();

        if ($tulos) {
            $ryhma = new Kyselyryhma(array(
                'ryhmaid' => $tulos['ryhmaid']
            ));
            return $ryhma;
        }

        return null;
    }

    public static function allGroups() {
        $query = DB::connection()->prepare('SELECT * FROM Kyselyryhma ORDER BY ryhmaid');
        $query->execute();
        $tulokset = $query->fetchAll();

        $ryhmat = array();

        foreach ($tulokset as $tulos) {
            $ryhmat[] = new Kyselyryhma(array(
                'ryhmaid' => $tulos['ryhmaid']
            ));
        }
        return $ryhmat;
    }
    
    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Kyselyryhma VALUES (DEFAULT) RETURNING ryhmaID');
        $query->execute();

        $tulos = $query->fetch();
        $this->ryhmaid = $tulos['ryhmaid'];

        return $this->ryhmaid;
    }

    public function saveToLaari($ryhmaid, $kyselyid) {
        $query = DB::connection()->prepare('INSERT INTO KyselyryhmaLaari (ryhmaID, kyselyID) VALUES (:ryhmaid, :kyselyid) RETURNING ryhmaID');
        $query->execute(array('ryhmaid' => $ryhmaid, 'kyselyid' => $kyselyid));

        return $ryhmaid;
    }

}
