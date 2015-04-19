<?php

/* Malli elokuvalle */

class Elokuva extends BaseModel {

    public $leffaid, $leffanimi, $vuosi, $valtio, $kieli,
            $synopsis, $traileriurl, $lisatty, $viimeksimuutettu;

    public function __construct($attribuutit) {
        parent::__construct($attribuutit);
        $this->validators = array('validateName', 'validateYear', 'validateLanguage');
    }

    private static function createElokuva($tulos) {
        return new Elokuva(array(
            'leffaid' => $tulos['leffaid'],
            'leffanimi' => $tulos['leffanimi'],
            'vuosi' => $tulos['vuosi'],
            'valtio' => $tulos['valtio'],
            'kieli' => $tulos['kieli'],
            'synopsis' => $tulos['synopsis'],
            'traileriurl' => $tulos['traileriurl'],
            'lisatty' => $tulos['lisatty'],
            'viimeksimuutettu' => $tulos['viimeksimuutettu']
        ));
    }

    
    /* Haetaan kaikki elokuvat ja listoille elokuvat */
    
    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Elokuva ORDER BY leffanimi');
        $query->execute();
        $tulokset = $query->fetchAll();

        $elokuvat = array();
        foreach ($tulokset as $tulos) {
            $elokuvat[] = Elokuva::createElokuva($tulos);
        }
        return $elokuvat;
    }

    public static function allNotFavourites($kayttajaid) {
        $query = DB::connection()->prepare('SELECT * FROM Elokuva E '
                . 'WHERE leffaID NOT IN (SELECT leffaID FROM Suosikkilista WHERE kayttajaID = :kayttajaid) '
                . 'ORDER BY leffanimi');
        $query->execute(array('kayttajaid' => $kayttajaid));
        $tulokset = $query->fetchAll();

        $elokuvat = array();
        foreach ($tulokset as $tulos) {
            $elokuvat[] = Elokuva::createElokuva($tulos);
        }
        return $elokuvat;
    }

    public static function allNotWatched($kayttajaid) {
        $query = DB::connection()->prepare('SELECT * FROM Elokuva E '
                . 'WHERE leffaID NOT IN (SELECT leffaID FROM Katsotutlista WHERE kayttajaID = :kayttajaid) '
                . 'ORDER BY leffanimi');
        $query->execute(array('kayttajaid' => $kayttajaid));
        $tulokset = $query->fetchAll();

        $elokuvat = array();
        foreach ($tulokset as $tulos) {
            $elokuvat[] = Elokuva::createElokuva($tulos);
        }
        return $elokuvat;
    }

    public static function allNotToBeWatched($kayttajaid) {
        $query = DB::connection()->prepare('SELECT * FROM Elokuva E '
                . 'WHERE leffaID NOT IN (SELECT leffaID FROM MasTardeLista WHERE kayttajaID = :kayttajaid)'
                . ' ORDER BY leffanimi');
        $query->execute(array('kayttajaid' => $kayttajaid));
        $tulokset = $query->fetchAll();

        $elokuvat = array();
        foreach ($tulokset as $tulos) {
            $elokuvat[] = Elokuva::createElokuva($tulos);
        }
        return $elokuvat;
    }

    public static function allNotDVD($kayttajaid) {
        $query = DB::connection()->prepare('SELECT * FROM Elokuva E '
                . 'WHERE leffaID NOT IN (SELECT leffaID FROM DVDLista WHERE kayttajaID = :kayttajaid)'
                . ' ORDER BY leffanimi');
        $query->execute(array('kayttajaid' => $kayttajaid));
        $tulokset = $query->fetchAll();

        $elokuvat = array();
        foreach ($tulokset as $tulos) {
            $elokuvat[] = Elokuva::createElokuva($tulos);
        }
        return $elokuvat;
    }

    /* Haetaan IDllä elokuva */
    public static function findOne($leffaid) {
        $query = DB::connection()->prepare('SELECT * FROM Elokuva WHERE leffaid = :leffaid LIMIT 1');
        $query->execute(array('leffaid' => $leffaid));
        $tulos = $query->fetch();

        if ($tulos) {
            $elokuva = Elokuva::createElokuva($tulos);
            return $elokuva;
        }

        return null;
    }

    /* Haetaan elokuvat artistille */
    public static function findElokuvatForArtisti($artistiid) {
        $query = DB::connection()->prepare('SELECT E.leffaid, leffaNimi '
                . 'FROM ArtistiLaari A, Elokuva E '
                . 'WHERE A.leffaID=E.leffaID AND A.artistiID= :artistiid');
        $query->execute(array('artistiid' => $artistiid));
        $tulokset = $query->fetchAll();

        $elokuvat = array();
        foreach ($tulokset as $tulos) {
            $elokuvat[] = new Elokuva(array(
                'leffaid' => $tulos['leffaid'],
                'leffanimi' => $tulos['leffanimi']
            ));
        }
        return $elokuvat;
    }

    /* Haetaan elokuvat valtiolle */
    public static function findElokuvatForValtiot($valtioid) {
        $query = DB::connection()->prepare('SELECT * FROM Elokuva WHERE valtio= :valtio ORDER BY leffanimi');
        $query->execute(array('valtio' => $valtioid));
        $tulokset = $query->fetchAll();

        $elokuvat = array();

        foreach ($tulokset as $tulos) {
            $elokuvat[] = Elokuva::createElokuva($tulos);
        }
        return $elokuvat;
    }

    /* Haetaan elokuvat listoille */
    
    public static function findSuosikkiElokuvat($kid) {
        $query = DB::connection()->prepare('SELECT * FROM Suosikkilista S, Elokuva E '
                . 'WHERE kayttajaID= :kayttajaid AND S.leffaID=E.leffaID '
                . 'ORDER BY E.leffanimi');
        $query->execute(array('kayttajaid' => $kid));
        $tulokset = $query->fetchAll();

        $elokuvat = array();

        foreach ($tulokset as $tulos) {
            $elokuvat[] = Elokuva::createElokuva($tulos);
        }
        return $elokuvat;
    }

    public static function findKatsotutElokuvat($kid) {
        $query = DB::connection()->prepare('SELECT * FROM Katsotutlista K, Elokuva E '
                . 'WHERE kayttajaID= :kayttajaid AND K.leffaID=E.leffaID'
                . ' ORDER BY E.leffanimi');
        $query->execute(array('kayttajaid' => $kid));
        $tulokset = $query->fetchAll();

        $elokuvat = array();
        foreach ($tulokset as $tulos) {
            $elokuvat[] = Elokuva::createElokuva($tulos);
        }
        return $elokuvat;
    }

    public static function findMasTardeElokuvat($kid) {
        $query = DB::connection()->prepare('SELECT * FROM MasTardeLista M, Elokuva E '
                . 'WHERE kayttajaID= :kayttajaid AND M.leffaID=E.leffaID'
                . ' ORDER BY E.leffanimi');
        $query->execute(array('kayttajaid' => $kid));
        $tulokset = $query->fetchAll();

        $elokuvat = array();

        foreach ($tulokset as $tulos) {
            $elokuvat[] = Elokuva::createElokuva($tulos);
        }
        return $elokuvat;
    }

    public static function findDVDTForKayttaja($kid) {
        $query = DB::connection()->prepare('SELECT * FROM DVDLista D, Elokuva E '
                . 'WHERE kayttajaID= :kayttajaid AND D.leffaID=E.leffaID'
                . ' ORDER BY E.leffanimi');
        $query->execute(array('kayttajaid' => $kid));
        $tulokset = $query->fetchAll();

        $elokuvat = array();

        foreach ($tulokset as $tulos) {
            $elokuvat[] = Elokuva::createElokuva($tulos);
        }
        return $elokuvat;
    }
    
    /* Uuden elokuvaehdotuksen tallentaminen */
    public function saveSuggestion() {
        $query = ('INSERT INTO Elokuva '
                . '(leffanimi, vuosi, valtio, kieli, synopsis, traileriurl, lisatty, viimeksiMuutettu) '
                . 'VALUES (:leffanimi, :vuosi, :valtio, :kieli, :synopsis, :traileriurl, NOW(), NOW()) '
                . 'RETURNING leffaid');

        $sijoituspaikat = array(":leffanimi", ":vuosi", ":valtio", ":kieli", ":synopsis", ":traileriurl");
        $parametrit = array("'$this->leffanimi'", $this->vuosi, $this->valtio,
            "'$this->kieli'", "'$this->synopsis'", "'$this->traileriurl'");
        $uusi = str_replace($sijoituspaikat, $parametrit, $query);

        $kyselyryhma = new Kyselyryhma(array());
        $ryhmaid = $kyselyryhma->save();
        $kysely = new Kyselyehdotus(array(
            'kysely' => $uusi
        ));
        $kysely->save();
        $kyselyryhma->saveToLaari($ryhmaid, $kysely->kyselyid);

        return $ryhmaid;
    }
    
    /* Elokuvan muokkausehdotuksen tallentaminen */
    public function updateSuggestion() {
        $query = ('UPDATE Elokuva '
                . 'SET leffanimi = :leffanimi, vuosi = :vuosi, valtio = :valtio, kieli = :kieli, '
                . 'synopsis = :synopsis, traileriurl= :traileriurl, viimeksimuutettu=NOW() '
                . 'WHERE leffaid = :leffaid RETURNING leffaid');

        $sijoituspaikat = array(":leffaid", ":leffanimi", ":vuosi",
            ":valtio", ":kieli", ":synopsis", ":traileriurl");
        $parametrit = array($this->leffaid, "'$this->leffanimi'", $this->vuosi, $this->valtio,
            "'$this->kieli'", "'$this->synopsis'", "'$this->traileriurl'");

        $uusi = str_replace($sijoituspaikat, $parametrit, $query);

        $kyselyryhma = new Kyselyryhma(array());
        $ryhmaid = $kyselyryhma->save();

        $kysely = new Kyselyehdotus(array(
            'kysely' => $uusi
        ));
        $kysely->save();

        $kyselyryhma->saveToLaari($ryhmaid, $kysely->kyselyid);
    }

    /* Uuden elokuvan tallentaminen - ylläpitäjä tekee */
    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Elokuva '
                . '(leffanimi, vuosi, valtio, kieli, synopsis, traileriurl, lisatty, viimeksiMuutettu) '
                . 'VALUES (:leffanimi, :vuosi, :valtio, :kieli, :synopsis, :traileriurl, NOW(), NOW()) '
                . 'RETURNING leffaid');
        $query->execute(array(
            'leffanimi' => $this->leffanimi,
            'vuosi' => $this->vuosi,
            'valtio' => $this->valtio,
            'kieli' => $this->kieli,
            'synopsis' => $this->synopsis,
            'traileriurl' => $this->traileriurl
        ));

        $tulos = $query->fetch();

        return $tulos['leffaid'];
    }

    /* Elokuvan muokkaaminen - ylläpitäjä tekee */
    public function update() {
        $query = DB::connection()->prepare('UPDATE Elokuva '
                . 'SET leffanimi = :leffanimi, vuosi = :vuosi, valtio = :valtio, kieli = :kieli, '
                . 'synopsis = :synopsis, traileriurl= :traileriurl, viimeksimuutettu=NOW() '
                . 'WHERE leffaid = :leffaid RETURNING leffaid');
        $query->execute(array(
            'leffaid' => $this->leffaid,
            'leffanimi' => $this->leffanimi,
            'vuosi' => $this->vuosi,
            'valtio' => $this->valtio,
            'kieli' => $this->kieli,
            'synopsis' => $this->synopsis,
            'traileriurl' => $this->traileriurl
        ));

        $tulos = $query->fetch();
        return $tulos['leffaid'];
    }

    /* Elokuvan poistaminen - ylläpitäjä tekee */
    public static function destroy() {
        $query = DB::connection()->prepare('DELETE FROM Elokuva WHERE leffaid = :leffaid');
        $query->execute(array('leffaid' => $this->leffaid));
    }

    /* Haku */
    public static function search($valinnat) {
        $query = 'SELECT DISTINCT E.leffaID, E.leffaNimi '
                . 'FROM Elokuva E, ArtistiLaari A, GenreLaari G, LeffaPalkintoLaari L, SarjaLaari S '
                . 'WHERE ';

        $first = TRUE;
        $valinta = array();

        $vaihto = array('Ñ' => 'N', 'ñ' => 'n', 'Á' => 'A', 'á' => 'a', 'É' => 'e',
            'é' => 'e', 'Í' => 'I', 'í' => 'i', 'Ó' => 'O', 'ó' => 'o', 'Ú' => 'U',
            'ú' => 'u', 'Ü' => 'U', 'ü' => 'u', 'Ä' => 'A', 'ä' => 'a', 'Ö' => 'O',
            'ö' => 'o', 'Å' => 'A', 'å' => 'a', '.' => '', ',' => '', '/' => '',
            '(' => '', ')' => '', '?' => '', '!' => '', '-' => ''
        );

        if (isset($valinnat['nayttelijalista'])) {

            $tyypit = $valinnat['nayttelijalista'];
            $monesko = 0;

            foreach ($tyypit as $n) {
                $hakusana = str_replace(' ', '', strtolower($valinnat['nayttelijalista'][$monesko]));
                $haku = strtr($hakusana, $vaihto);

                if ($first) {
                    $first = FALSE;
                    $query .= " :hassu$haku IN (SELECT lower(A.etuNimi || '' || replace(A.sukuNimi, ' ', '')) AS NIMI "
                            . "FROM ArtistiLaari L, Artisti A WHERE L.artistiID = A.artistiID "
                            . "AND leffaID = E.leffaID  AND A.artistiTyyppi='Näyttelijä') ";
                } else {
                    $query .= " AND :hassu$haku IN (SELECT lower(A.etuNimi || '' || replace(A.sukuNimi, ' ', '')) AS NIMI "
                            . "FROM ArtistiLaari L, Artisti A WHERE L.artistiID = A.artistiID "
                            . "AND leffaID = E.leffaID  AND A.artistiTyyppi='Näyttelijä') ";
                }

                $valinta['hassu' . $haku] = $hakusana;
                $monesko++;
            }
        }
        if (isset($valinnat['ohjaajalista'])) {
            $tyypit = $valinnat['ohjaajalista'];
            $monesko = 0;

            foreach ($tyypit as $n) {
                $hakusana = str_replace(' ', '', strtolower($valinnat['ohjaajalista'][$monesko]));
                $haku = strtr($hakusana, $vaihto);

                if ($first) {
                    $first = FALSE;
                    $query .= " :hassu$haku IN (SELECT lower(A.etuNimi || '' || replace(A.sukuNimi, ' ', '')) AS NIMI "
                            . "FROM ArtistiLaari L, Artisti A WHERE L.artistiID = A.artistiID "
                            . "AND leffaID = E.leffaID  AND A.artistiTyyppi='Ohjaaja') ";
                } else {
                    $query .= " AND :hassu$haku IN (SELECT lower(A.etuNimi || '' || replace(A.sukuNimi, ' ', '')) AS NIMI "
                            . "FROM ArtistiLaari L, Artisti A WHERE L.artistiID = A.artistiID "
                            . "AND leffaID = E.leffaID  AND A.artistiTyyppi='Ohjaaja') ";
                }

                $valinta['hassu' . $haku] = $hakusana;
                $monesko++;
            }
        }
        if (isset($valinnat['kuvaajalista'])) {
            $tyypit = $valinnat['kuvaajalista'];
            $monesko = 0;

            foreach ($tyypit as $n) {
                $hakusana = str_replace(' ', '', strtolower($valinnat['kuvaajalista'][$monesko]));
                $haku = strtr($hakusana, $vaihto);

                if ($first) {
                    $first = FALSE;
                    $query .= " :hassu$haku IN (SELECT lower(A.etuNimi || '' || replace(A.sukuNimi, ' ', '')) AS NIMI "
                            . "FROM ArtistiLaari L, Artisti A WHERE L.artistiID = A.artistiID "
                            . "AND leffaID = E.leffaID  AND A.artistiTyyppi='Kuvaaja') ";
                } else {
                    $query .= " AND :hassu$haku IN (SELECT lower(A.etuNimi || '' || replace(A.sukuNimi, ' ', '')) AS NIMI "
                            . "FROM ArtistiLaari L, Artisti A WHERE L.artistiID = A.artistiID "
                            . "AND leffaID = E.leffaID  AND A.artistiTyyppi='Kuvaaja') ";
                }

                $valinta['hassu' . $haku] = $hakusana;
                $monesko++;
            }
        }
        if (isset($valinnat['kasikirjoittajalista'])) {
            $tyypit = $valinnat['kasikirjoittajalista'];
            $monesko = 0;

            foreach ($tyypit as $n) {
                $hakusana = str_replace(' ', '', strtolower($valinnat['kasikirjoittajalista'][$monesko]));
                $haku = strtr($hakusana, $vaihto);

                if ($first) {
                    $first = FALSE;
                    $query .= " :hassu$haku IN (SELECT lower(A.etuNimi || '' || replace(A.sukuNimi, ' ', '')) AS NIMI "
                            . "FROM ArtistiLaari L, Artisti A WHERE L.artistiID = A.artistiID "
                            . "AND leffaID = E.leffaID  AND A.artistiTyyppi='Käsikirjoittaja') ";
                } else {
                    $query .= " AND :hassu$haku IN (SELECT lower(A.etuNimi || '' || replace(A.sukuNimi, ' ', '')) AS NIMI "
                            . "FROM ArtistiLaari L, Artisti A WHERE L.artistiID = A.artistiID "
                            . "AND leffaID = E.leffaID  AND A.artistiTyyppi='Käsikirjoittaja') ";
                }

                $valinta['hassu' . $haku] = $hakusana;
                $monesko++;
            }
        }
        if (isset($valinnat['valtio'])) {
            if ($first) {
                $first = FALSE;
                $query .= ' E.valtio = :valtio ';
            } else {
                $query .= ' AND E.valtio = :valtio ';
            }

            $valinta['valtio'] = $valinnat['valtio'];
        }

        if (isset($valinnat['alkuvuosi']) && isset($valinnat['loppuvuosi'])) {
            if ($first) {
                $first = FALSE;
                $query .= ' vuosi BETWEEN :alkuvuosi AND :loppuvuosi ';
            } else {
                $query .= ' AND vuosi BETWEEN :alkuvuosi AND :loppuvuosi ';
            }

            $valinta['alkuvuosi'] = $valinnat['alkuvuosi'];
            $valinta['loppuvuosi'] = $valinnat['loppuvuosi'];
        } else if (isset($valinnat['alkuvuosi'])) {

            if ($first) {
                $first = FALSE;
                $query .= ' vuosi >= :alkuvuosi ';
            } else {
                $query .= ' AND vuosi >= :alkuvuosi ';
            }
            $valinta['alkuvuosi'] = $valinnat['alkuvuosi'];
        } else if (isset($valinnat['loppuvuosi'])) {

            if ($first) {
                $first = FALSE;
                $query .= ' vuosi <= :loppuvuosi ';
            } else {
                $query .= ' AND vuosi <= :loppuvuosi ';
            }

            $valinta['loppuvuosi'] = $valinnat['loppuvuosi'];
        }



        if (isset($valinnat['kieli'])) {
            if ($first) {
                $first = FALSE;
                $query .= ' kieli LIKE :kieli ';
            } else {
                $query .= ' AND kieli LIKE :kieli ';
            }
            $kieli = strtolower($valinnat['kieli']);
            $valinta['kieli'] = $kieli;
        }
        if (isset($valinnat['genre'])) {
            if ($first) {
                $first = FALSE;
                $query .= ' :genre IN (SELECT genreid FROM GenreLaari WHERE leffaID = E.leffaID) ';
            } else {
                $query .= ' AND :genre IN (SELECT genreid FROM GenreLaari WHERE leffaID = E.leffaID) ';
            }

            $valinta['genre'] = $valinnat['genre'];
        }
        if (isset($valinnat['palkinto'])) {
            if ($first) {
                $first = FALSE;
                $query .= ' :palkinto IN (SELECT palkintoid FROM LeffaPalkintoLaari WHERE leffaID = E.leffaID) ';
            } else {
                $query .= ' AND :palkinto IN (SELECT palkintoid FROM LeffaPalkintoLaari WHERE leffaID = E.leffaID) ';
            }

            $valinta['palkinto'] = $valinnat['palkinto'];
        }
        if (isset($valinnat['sarja'])) {
            if ($first) {
                $first = FALSE;
                $query .= ' :sarja IN (SELECT sarjaid FROM SarjaLaari WHERE leffaID = E.leffaID) ';
            } else {
                $query .= ' AND :sarja IN (SELECT sarjaid FROM SarjaLaari WHERE leffaID = E.leffaID) ';
            }

            $valinta['sarja'] = $valinnat['sarja'];
        }

        $query .= ' ORDER BY E.leffanimi ';


        $perfectquery = DB::connection()->prepare($query);
        $perfectquery->execute($valinta);

        $rivit = $perfectquery->fetchAll();
        $tulokset = array();

        foreach ($rivit as $rivi) {
            $tulokset[] = new Elokuva($rivi);
        }

        return $tulokset;
    }

}
