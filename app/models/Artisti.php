<?php

/* Malli elokuvan tekijöille */

class Artisti extends BaseModel {

    public $artistiid, $artistityyppi, $etunimi, $sukunimi, $bio,
            $kuva, $syntymavuosi, $valtio, $lisatty, $viimeksimuutettu;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validateFirstName', 'validateLastName', 'validateBirthYear');
    }

    private static function createArtisti($row) {
        return new Artisti(array(
            'artistiid' => $row['artistiid'],
            'artistityyppi' => $row['artistityyppi'],
            'etunimi' => $row['etunimi'],
            'sukunimi' => $row['sukunimi'],
            'bio' => $row['bio'],
            'kuva' => $row['kuva'],
            'syntymavuosi' => $row['syntymavuosi'],
            'valtio' => $row['valtio'],
            'lisatty' => $row['lisatty'],
            'viimeksimuutettu' => $row['viimeksimuutettu']
        ));
    }

    /* Kaikki artistit */
    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Artisti ORDER BY sukunimi');
        $query->execute();
        $rows = $query->fetchAll();

        $artists = array();
        foreach ($rows as $row) {
            $artists[] = Artisti::createArtisti($row);
        }
        return $artists;
    }

    /* Haetaan artisti IDllä */
    public static function findOne($artistiid) {
        $query = DB::connection()->prepare('SELECT * FROM Artisti WHERE artistiid = :artistiid LIMIT 1');
        $query->execute(array('artistiid' => $artistiid));
        $row = $query->fetch();

        if ($row) {
            $artist = Artisti::createArtisti($row);
            return $artist;
        }

        return null;
    }

    /* Haetaan kaikki artistit tyypeittäin */
    public static function findAllArtistsByType($type) {
        $query = DB::connection()->prepare('SELECT * FROM Artisti R '
                . 'WHERE R.artistityyppi= :tyyppi ORDER BY R.sukunimi');
        $query->execute(array('tyyppi' => $type));
        $rows = $query->fetchAll();

        $artists = array();
        foreach ($rows as $row) {
            $artists[] = Artisti::createArtisti($row);
        }
        return $artists;
    }
    
    /* Haetaan kaikki artistit, jotka eivät ole annetussa elokuvassa, tyypeittäin */
    public static function findAllArtistsNotInTheMovieByType($type, $leffaid) {
        $query = DB::connection()->prepare('SELECT * '
                . 'FROM Artisti WHERE artistityyppi= :tyyppi '
                . 'AND artistiID NOT IN (SELECT artistiID FROM ArtistiLaari WHERE leffaID = :leffaid) '
                . 'ORDER BY sukunimi;');
        $query->execute(array('tyyppi' => $type, 'leffaid' => $leffaid));
        $rows = $query->fetchAll();

        $artists = array();
        foreach ($rows as $row) {
            $artists[] = Artisti::createArtisti($row);
        }
        return $artists;
    }
    
    
    
    

    /* Haetaan elokuvalle artistit tyypeittäin */
    public static function findArtistsForMovie($leffaid, $type) {
        $query = DB::connection()->prepare('SELECT R.artistiID, R.artistityyppi, R.etunimi, R.sukunimi, R.bio, R.kuva, R.syntymavuosi, R.valtio, R.lisatty, R.viimeksimuutettu '
                . 'FROM Elokuva E, ArtistiLaari A, Artisti R '
                . 'WHERE E.leffaid = :leffaid AND E.leffaid=A.leffaid AND A.artistiID=R.artistiID AND R.artistityyppi= :tyyppi ORDER BY R.sukunimi');
        $query->execute(array('leffaid' => $leffaid, 'tyyppi' => $type));
        $rows = $query->fetchAll();

        $artists = array();
        foreach ($rows as $row) {
            $artists[] = Artisti::createArtisti($row);
        }
        return $artists;
    }
    
    /* Haetaan valtiolle artistit tyypeittäin */
    public static function findArtistsForCountry($valtioid, $type) {
        $query = DB::connection()->prepare('SELECT R.artistiID, R.artistityyppi, R.etunimi, R.sukunimi, R.bio, R.kuva, R.syntymavuosi, R.valtio, R.lisatty, R.viimeksimuutettu '
                . 'FROM Valtiot V, Artisti R '
                . 'WHERE V.valtioid = :valtio AND V.valtioid=R.valtio AND R.artistityyppi= :tyyppi ORDER BY R.sukunimi');
        $query->execute(array('valtio' => $valtioid, 'tyyppi' => $type));
        $rows = $query->fetchAll();

        $artists = array();
        foreach ($rows as $row) {
            $artists[] = Artisti::createArtisti($row);
        }
        return $artists;
    }

    
    
    /* Uuden artistiehdotuksen tallentaminen */
    public function saveSuggestion($ryhmaid) {
        $query = ('INSERT INTO Artisti '
                . '(artistiTyyppi, etuNimi, sukuNimi, bio, syntymavuosi, valtio, lisatty, viimeksiMuutettu) '
                . 'VALUES  (:artistityyppi, :etunimi, :sukunimi, :bio, :syntymavuosi, :valtio, NOW(), NOW()) '
                . 'RETURNING artistiid');

        $locations = array(":artistityyppi", ":etunimi", ":sukunimi", ":bio", ":syntymavuosi", ":valtio");
        $params = array("'$this->artistityyppi'", "'$this->etunimi'", "'$this->sukunimi'",
            "'$this->bio'", $this->syntymavuosi, $this->valtio);
        $newQuery = str_replace($locations, $params, $query);
        
        $querySuggestion = new Kyselyehdotus(array(
            'kysely' => $newQuery
        ));
        $querySuggestion->save();
        Kyselyryhma::saveToLaari($ryhmaid, $querySuggestion->kyselyid);       
    }
    
    /* Uuden artistiehdotuksen tallentaminen ilman elokuvaa */
    public function saveSuggestionOwnGroup() {
        $query = ('INSERT INTO Artisti '
                . '(artistiTyyppi, etuNimi, sukuNimi, bio, syntymavuosi, valtio, lisatty, viimeksiMuutettu) '
                . 'VALUES  (:artistityyppi, :etunimi, :sukunimi, :bio, :syntymavuosi, :valtio, NOW(), NOW()) '
                . 'RETURNING artistiid');

        $locations = array(":artistityyppi", ":etunimi", ":sukunimi", ":bio", ":syntymavuosi", ":valtio");
        $params = array("'$this->artistityyppi'", "'$this->etunimi'", "'$this->sukunimi'",
            "'$this->bio'", $this->syntymavuosi, $this->valtio);
        $newQuery = str_replace($locations, $params, $query);
        
        $queryGroup = new Kyselyryhma(array());
        $ryhmaid = $queryGroup->save();
        $querySuggestion = new Kyselyehdotus(array(
            'kysely' => $newQuery
        ));
        $querySuggestion->save();
        Kyselyryhma::saveToLaari($ryhmaid, $querySuggestion->kyselyid);

        return $ryhmaid;
    }

    /* Artistinmuokkausehdotuksen tallentaminen */
    public function updateSuggestion() {
        $query = ('UPDATE Artisti '
                . 'SET artistityyppi = :artistityyppi, etunimi = :etunimi, '
                . 'sukunimi = :sukunimi, bio = :bio, syntymavuosi = :syntymavuosi, '
                . 'valtio = :valtio, viimeksiMuutettu = NOW() '
                . 'WHERE artistiid = :artistiid RETURNING artistiid;');

        $locations = array(":artistiid", ":artistityyppi", ":etunimi",
            ":sukunimi", ":bio", ":syntymavuosi", ":valtio");
        $params = array($this->artistiid, "'$this->artistityyppi'", "'$this->etunimi'",
            "'$this->sukunimi'", "'$this->bio'", $this->syntymavuosi, $this->valtio);
        $newQuery = str_replace($locations, $params, $query);
        
        $queryGroup = new Kyselyryhma(array());
        $ryhmaid = $queryGroup->save();
        $querySuggestion = new Kyselyehdotus(array(
            'kysely' => $newQuery
        ));               
        $querySuggestion->save();
        Kyselyryhma::saveToLaari($ryhmaid, $querySuggestion->kyselyid);
        
        return $ryhmaid;
    }
    
    
    /* Uuden artistin tallentaminen - ylläpitäjä tekee */
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

        $row = $query->fetch();
        $this->artistiid = $row['artistiid'];
        return $this->artistiid;
    }

    /* Artistinmuokkauksen tallentaminen - ylläpitäjä tekee */
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

        $row = $query->fetch();
        return $row['artistiid'];
    }

    /* Artistin poistaminen - ylläpitäjä tekee */
    public function destroy() {
        $query = DB::connection()->prepare('DELETE FROM Artisti WHERE artistiid = :artistiid');
        $query->execute(array('artistiid' => $this->artistiid));
    }

}
