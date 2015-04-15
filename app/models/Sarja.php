<?php

class Sarja extends BaseModel {

    public $sarjaid, $sarjanimi;

    public function __construct($attribuutit) {
        parent::__construct($attribuutit);
    }

    private static function createSarja($tulos) {
        return new Sarja(array(
            'sarjaid' => $tulos['sarjaid'],
            'sarjanimi' => $tulos['sarjanimi']
        ));
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Sarja');
        $query->execute();
        $tulokset = $query->fetchAll();

        $sarjat = array();
        foreach ($tulokset as $tulos) {
            $sarjat[] = Sarja::createSarja($tulos);
        }
        return $sarjat;
    }

    public static function findOne($id) {
        $query = DB::connection()->prepare('SELECT * FROM Sarja WHERE sarjaid = :sarjaid LIMIT 1');
        $query->execute(array('sarjaid' => $id));
        $tulos = $query->fetch();

        if ($tulos) {
            $sarja = Sarja::createSarja($tulos);
            return $sarja;
        }

        return null;
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Sarja (sarjaNimi) '
                . 'VALUES (:sarjanimi) RETURNING sarjaid;');
        $query->execute(array(
            'sarjanimi' => $this->sarjanimi
        ));

        $tulos = $query->fetch();
        $this->sarjaid = $tulos['sarjaid'];
        return $this->sarjaid;
    }

}
