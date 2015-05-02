<?php

/* Malli käyttäjälle */

class Kayttaja extends BaseModel {

    public $kayttajaid, $kayttajatunnus, $nimi, $salasana,
            $lempigenre, $rekisteroitynyt, $viimeksimuutettu;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validateNameForUser', 'validateUsername', 'validatePassword');
    }

    private static function createKayttaja($row) {
        return new Kayttaja(array(
            'kayttajaid' => $row['kayttajaid'],
            'kayttajatunnus' => $row['kayttajatunnus'],
            'nimi' => $row['nimi'],
            'salasana' => $row['salasana'],
            'lempigenre' => $row['lempigenre'],
            'rekisteroitynyt' => $row['rekisteroitynyt'],
            'viimeksimuutettu' => $row['viimeksimuutettu']
        ));
    }

    /* Haetaan kaikki rekisteröityneet käyttäjät */
    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Kayttaja');
        $query->execute();
        $rows = $query->fetchAll();

        $kayttajat = array();

        foreach ($rows as $row) {
            $kayttajat[] = Kayttaja::createKayttaja($row);
        }
        return $kayttajat;
    }

    /* Haetaan IDllä tietty käyttäjä */
    public static function findOne($kayttajaid) {
        $query = DB::connection()->prepare('SELECT * FROM Kayttaja WHERE kayttajaid = :kayttajaid LIMIT 1');
        $query->execute(array('kayttajaid' => $kayttajaid));
        $row = $query->fetch();

        if ($row) {
            $kayttaja = Kayttaja::createKayttaja($row);
            return $kayttaja;
        }

        return null;
    }

    /* Tarkistetaan onko käyttäjää olemassa/onko salasana ja tunnus oikein */
    public static function authenticate($kayttajatunnus, $salasana) {
        $query = DB::connection()->prepare('SELECT * FROM Kayttaja WHERE kayttajaTunnus = :kayttajatunnus AND salasana = :salasana LIMIT 1;');
        $query->execute(array('kayttajatunnus' => $kayttajatunnus, 'salasana' => $salasana));
        $row = $query->fetch();

        if ($row) {
            $kayttaja = Kayttaja::createKayttaja($row);
            return $kayttaja;
        }

        return null;
    }

    /* Tallennetaan uusi käyttäjä */
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

        $row = $query->fetch();
        $this->kayttajaid = $row['kayttajaid'];
    }

    /* Päivitetään käyttäjän tietoja */
    public function update() {
        $query = DB::connection()->prepare('UPDATE Kayttaja '
                . 'SET kayttajaTunnus = :kayttajatunnus, nimi = :nimi, '
                . 'salasana = :salasana, lempiGenre = :lempigenre, viimeksiMuutettu = now() '
                . 'WHERE kayttajaID = :kayttajaid RETURNING kayttajaID');
        $query->execute(array(
            'kayttajaid' => $this->kayttajaid,
            'kayttajatunnus' => $this->kayttajatunnus,
            'nimi' => $this->nimi,
            'salasana' => $this->salasana,
            'lempigenre' => $this->lempigenre
        ));

        $row = $query->fetch();
        return $row['kayttajaid'];
    }

    /* Poistetaan käyttäjä */
    public function destroy() {
        $query = DB::connection()->prepare('DELETE FROM Kayttaja WHERE kayttajaid = :kayttajaid');
        $query->execute(array('kayttajaid' => $this->kayttajaid));
    }

}
