<?php

class Kayttaja extends BaseModel {

    public $kayttajaid, $kayttajatunnus, $nimi, $salasana,
            $lempigenre, $rekisteroitynyt, $viimeksimuutettu;

    public function __construct($attribuutit) {
        parent::__construct($attribuutit);
        $this->validators = array('validateNameForUser', 'validateUsername', 'validatePassword');
    }

    private static function createKayttaja($tulos) {
        return new Kayttaja(array(
            'kayttajaid' => $tulos['kayttajaid'],
            'kayttajatunnus' => $tulos['kayttajatunnus'],
            'nimi' => $tulos['nimi'],
            'salasana' => $tulos['salasana'],
            'lempigenre' => $tulos['lempigenre'],
            'rekisteroitynyt' => $tulos['rekisteroitynyt'],
            'viimeksimuutettu' => $tulos['viimeksimuutettu']
        ));
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Kayttaja');
        $query->execute();
        $tulokset = $query->fetchAll();

        $kayttajat = array();

        foreach ($tulokset as $tulos) {
            $kayttajat[] = Kayttaja::createKayttaja($tulos);
        }
        return $kayttajat;
    }

    public static function findOne($id) {
        $query = DB::connection()->prepare('SELECT * FROM Kayttaja WHERE kayttajaid = :kayttajaid LIMIT 1');
        $query->execute(array('kayttajaid' => $id));
        $tulos = $query->fetch();

        if ($tulos) {
            $kayttaja = Kayttaja::createKayttaja($tulos);
            return $kayttaja;
        }

        return null;
    }

    public static function authenticate($kayttajatunnus, $salasana) {
        $query = DB::connection()->prepare('SELECT * FROM Kayttaja WHERE kayttajaTunnus = :kayttajatunnus AND salasana = :salasana LIMIT 1;');
        $query->execute(array('kayttajatunnus' => $kayttajatunnus, 'salasana' => $salasana));
        $tulos = $query->fetch();

        if ($tulos) {
            $kayttaja = Kayttaja::createKayttaja($tulos);
            return $kayttaja;
        }

        return null;
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Kayttaja 
            (kayttajaTunnus, nimi, salasana, lempiGenre, rekisteroitynyt, viimeksiMuutettu) 
            VALUES (:kayttajatunnus, :nimi, :salasana, :lempigenre, NOW(), NOW()) 
            RETURNING kayttajaid;');
        $query->execute(array(
            'kayttajatunnus' => $this->kayttajatunnus,
            'nimi' => $this->nimi,
            'salasana' => $this->salasana,
            'lempigenre' => $this->lempigenre
        ));

        $tulos = $query->fetch();
        $this->kayttajaid = $tulos['kayttajaid'];
    }

    public function update($id) {
        $query = DB::connection()->prepare('UPDATE Kayttaja '
                . 'SET kayttajaTunnus = :kayttajatunnus, nimi = :nimi, '
                . 'salasana = :salasana, lempiGenre = :lempigenre, viimeksiMuutettu = now() '
                . 'WHERE kayttajaID = :kayttajaid RETURNING kayttajaID');
        $query->execute(array(
            'kayttajaid' => $id,
            'kayttajatunnus' => $this->kayttajatunnus,
            'nimi' => $this->nimi,
            'salasana' => $this->salasana,
            'lempigenre' => $this->lempigenre
        ));

        $tulos = $query->fetch();
        return $tulos['kayttajaid'];
    }

    public function destroy($id) {
        $query = DB::connection()->prepare('DELETE FROM Kayttaja WHERE kayttajaid = :kayttajaid');
        $query->execute(array('kayttajaid' => $id));
    }

}
