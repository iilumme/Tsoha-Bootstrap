<?php

class Artisti extends BaseModel {

    public $artistiid, $artistityyppi, $etunimi, $sukunimi, $bio,
            $kuva, $syntymavuosi, $valtio, $lisatty, $viimeksimuutettu;

    public function __construct($attribuutit) {
        parent::__construct($attribuutit);
        $this->validators = array('validateFirstName', 'validateLastName', 'validateBirthYear');
    }

    private static function createArtisti($tulos) {
        return new Artisti(array(
            'artistiid' => $tulos['artistiid'],
            'artistityyppi' => $tulos['artistityyppi'],
            'etunimi' => $tulos['etunimi'],
            'sukunimi' => $tulos['sukunimi'],
            'bio' => $tulos['bio'],
            'kuva' => $tulos['kuva'],
            'syntymavuosi' => $tulos['syntymavuosi'],
            'valtio' => $tulos['valtio'],
            'lisatty' => $tulos['lisatty'],
            'viimeksimuutettu' => $tulos['viimeksimuutettu']
        ));
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Artisti ORDER BY sukunimi');
        $query->execute();
        $tulokset = $query->fetchAll();

        $artistit = array();
        foreach ($tulokset as $tulos) {
            $artistit[] = Artisti::createArtisti($tulos);
        }
        return $artistit;
    }

    public static function findOne($id) {
        $query = DB::connection()->prepare('SELECT * FROM Artisti WHERE artistiid = :artistiid LIMIT 1');
        $query->execute(array('artistiid' => $id));
        $tulos = $query->fetch();

        if ($tulos) {
            $artisti = Artisti::createArtisti($tulos);
            return $artisti;
        }

        return null;
    }

    public static function findAllArtistit($tyyppi) {
        $query = DB::connection()->prepare('SELECT * FROM Artisti R '
                . 'WHERE R.artistityyppi= :tyyppi ORDER BY R.sukunimi');
        $query->execute(array('tyyppi' => $tyyppi));
        $tulokset = $query->fetchAll();

        $artistit = array();
        foreach ($tulokset as $tulos) {
            $artistit[] = Artisti::createArtisti($tulos);
        }
        return $artistit;
    }

    public static function findArtistitForElokuva($id, $tyyppi) {
        $query = DB::connection()->prepare('SELECT R.artistiID, R.artistityyppi, R.etunimi, R.sukunimi, R.bio, R.kuva, R.syntymavuosi, R.valtio, R.lisatty, R.viimeksimuutettu '
                . 'FROM Elokuva E, ArtistiLaari A, Artisti R '
                . 'WHERE E.leffaid = :leffaid AND E.leffaid=A.leffaid AND A.artistiID=R.artistiID AND R.artistityyppi= :tyyppi ORDER BY R.sukunimi');
        $query->execute(array('leffaid' => $id, 'tyyppi' => $tyyppi));
        $tulokset = $query->fetchAll();

        $artistit = array();
        foreach ($tulokset as $tulos) {
            $artistit[] = Artisti::createArtisti($tulos);
        }
        return $artistit;
    }

    public static function findArtistitForValtio($id, $tyyppi) {
        $query = DB::connection()->prepare('SELECT R.artistiID, R.artistityyppi, R.etunimi, R.sukunimi, R.bio, R.kuva, R.syntymavuosi, R.valtio, R.lisatty, R.viimeksimuutettu '
                . 'FROM Valtiot V, Artisti R '
                . 'WHERE V.valtioid = :valtio AND V.valtioid=R.valtio AND R.artistityyppi= :tyyppi ORDER BY R.sukunimi');
        $query->execute(array('valtio' => $id, 'tyyppi' => $tyyppi));
        $tulokset = $query->fetchAll();

        $artistit = array();
        foreach ($tulokset as $tulos) {
            $artistit[] = Artisti::createArtisti($tulos);
        }
        return $artistit;
    }

    public function saveSuggestion($ryhmaid) {
        $query = ('INSERT INTO Artisti '
                . '(artistiTyyppi, etuNimi, sukuNimi, bio, syntymavuosi, valtio, lisatty, viimeksiMuutettu) '
                . 'VALUES  (:artistityyppi, :etunimi, :sukunimi, :bio, :syntymavuosi, :valtio, NOW(), NOW()) '
                . 'RETURNING artistiid');

        $sijoituspaikat = array(":artistityyppi", ":etunimi", ":sukunimi", ":bio", ":syntymavuosi", ":valtio");
        $parametrit = array("'$this->artistityyppi'", "'$this->etunimi'", "'$this->sukunimi'",
            "'$this->bio'", $this->syntymavuosi, $this->valtio);
        $uusi = str_replace($sijoituspaikat, $parametrit, $query);
        
        $kyselyryhma = new Kyselyryhma(array());
        $kysely = new Kyselyehdotus(array(
            'kysely' => $uusi
        ));
        $kysely->save();
        $kyselyryhma->saveToLaari($ryhmaid, $kysely->kyselyid);
        
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Artisti '
                . '(artistiTyyppi, etuNimi, sukuNimi, bio, syntymavuosi, valtio, lisatty, viimeksiMuutettu) '
                . 'VALUES  (:artistityyppi, :etunimi, :sukunimi, :bio, :syntymavuosi, :valtio, NOW(), NOW()) '
                . 'RETURNING artistiid');
        $query->execute(array(
            'artistityyppi' => $this->artistityyppi,
            'etunimi' => $this->etunimi,
            'sukunimi' => $this->sukunimi,
            'bio' => $this->bio,
            'syntymavuosi' => $this->syntymavuosi,
            'valtio' => $this->valtio
        ));

        $tulos = $query->fetch();
        $this->artistiid = $tulos['artistiid'];
        return $this->artistiid;
    }

    public function updateSuggestion() {
        $query = ('UPDATE Artisti '
                . 'SET artistityyppi = :artistityyppi, etunimi = :etunimi, '
                . 'sukunimi = :sukunimi, bio = :bio, syntymavuosi = :syntymavuosi, '
                . 'valtio = :valtio, viimeksiMuutettu = NOW() '
                . 'WHERE artistiid = :artistiid RETURNING artistiid;');

        $sijoituspaikat = array(":artistiid", ":artistityyppi", ":etunimi",
            ":sukunimi", ":bio", ":syntymavuosi", ":valtio");
        $parametrit = array($this->artistiid, "'$this->artistityyppi'", "'$this->etunimi'",
            "'$this->sukunimi'", "'$this->bio'", $this->syntymavuosi, $this->valtio);
        $uusi = str_replace($sijoituspaikat, $parametrit, $query);
        
        $kyselyryhma = new Kyselyryhma(array());
        $ryhmaid = $kyselyryhma->save();
        $kysely = new Kyselyehdotus(array(
            'kysely' => $uusi
        ));               
        $kysely->save();
        $kyselyryhma->saveToLaari($ryhmaid, $kysely->kyselyid);
    }

    public function update() {
        $query = DB::connection()->prepare('UPDATE Artisti '
                . 'SET artistityyppi = :artistityyppi, etunimi = :etunimi, '
                . 'sukunimi = :sukunimi, bio = :bio, syntymavuosi = :syntymavuosi, '
                . 'valtio = :valtio, viimeksiMuutettu = NOW() '
                . 'WHERE artistiid = :artistiid RETURNING artistiid;');
        $query->execute(array(
            'artistiid' => $this->artistiid,
            'artistityyppi' => $this->artistityyppi,
            'etunimi' => $this->etunimi,
            'sukunimi' => $this->sukunimi,
            'syntymavuosi' => $this->syntymavuosi,
            'valtio' => $this->valtio,
            'bio' => $this->bio
        ));

        $tulos = $query->fetch();
        return $tulos['artistiid'];
    }

    public function destroy($id) {
        $query = DB::connection()->prepare('DELETE FROM Artisti WHERE artistiid = :artistiid');
        $query->execute(array('artistiid' => $id));
    }

}
