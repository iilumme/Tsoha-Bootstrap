<?php

/* Malli kyselyryhmälle */

class Kyselyryhma extends BaseModel {

    public $ryhmaid;

    public function __construct($attribuutit) {
        parent::__construct($attribuutit);
    }

    /* Haetaan kaikki kyselyryhmät */
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

    /* Tallennetaan kyselyryhmä */
    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Kyselyryhma VALUES (DEFAULT) RETURNING ryhmaID');
        $query->execute();

        $tulos = $query->fetch();
        $this->ryhmaid = $tulos['ryhmaid'];

        return $this->ryhmaid;
    }

    /* Tallennetaan kysely kyselyryhmään */
    public function saveToLaari($ryhmaid, $kyselyid) {
        $query = DB::connection()->prepare('INSERT INTO KyselyryhmaLaari (ryhmaID, kyselyID) '
                . 'VALUES (:ryhmaid, :kyselyid) RETURNING ryhmaID');
        $query->execute(array('ryhmaid' => $ryhmaid, 'kyselyid' => $kyselyid));

        return $ryhmaid;
    }

    /* Poistetaan kyselyjä */
    public static function destroy($ryhmaid) {

        $kyselyt = Kyselyehdotus::allGroup_s_queries($ryhmaid);
        $query = DB::connection()->prepare('DELETE FROM Kyselyryhma WHERE ryhmaID = :ryhmaid');
        $query->execute(array('ryhmaid' => $ryhmaid));

        foreach ($kyselyt as $kysely) {
            Kyselyehdotus::destroy($kysely->kyselyid);
        }
    }

    /* Suoritetaan kyselyt */
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

        Kyselyryhma::destroy($ryhmaid);
    }

}
