<?php

/* Malli elokuvan tekijöiden tallentamiselle elokuvakohtaisesti */

class Artistilaari extends BaseModel {

    public $artistiid, $leffaid;

    public function __construct($attribuutit) {
        parent::__construct($attribuutit);
    }
    
    /* Ehdotuksen tallentaminen */
    public function saveSuggestion($ryhmaid) {
        $query = ('INSERT INTO ArtistiLaari (artistiid, leffaid) '
                . 'VALUES (:artistiid, :leffaid) RETURNING artistiid');        
        
        $sijoituspaikat = array(":artistiid", ":leffaid");
        $parametrit = array($this->artistiid, $this->leffaid);

        $uusi = str_replace($sijoituspaikat, $parametrit, $query);

        $kysely = new Kyselyehdotus(array('kysely' => $uusi));
        $kysely->save();
        Kyselyryhma::saveToLaari($ryhmaid, $kysely->kyselyid);
    }    
    
    /* Tallentaminen */
    public function save() {
        $query = DB::connection()->prepare('INSERT INTO ArtistiLaari (artistiid, leffaid) '
                . 'VALUES (:artistiid, :leffaid) RETURNING artistiid');
        $query->execute(array(
            'artistiid' => $this->artistiid,
            'leffaid' => $this->leffaid
        ));
    }
    
    /* Poistaminen */
    public function destroy() {
        $query = DB::connection()->prepare('DELETE FROM ArtistiLaari '
                . 'WHERE artistiID = :artistiid AND leffaID = :leffaid');
        $query->execute(array(
            'artistiid' => $this->artistiid,
            'leffaid' => $this->leffaid
        ));
    }
    
    /* Poistamisehdotus */
    public function destroySuggestion($ryhmaid) {
        $query = ('DELETE FROM ArtistiLaari '
                . 'WHERE artistiID = :artistiid AND leffaID = :leffaid');       
        
        $sijoituspaikat = array(":artistiid", ":leffaid");
        $parametrit = array($this->artistiid, $this->leffaid);
        $uusi = str_replace($sijoituspaikat, $parametrit, $query);

        $kysely = new Kyselyehdotus(array('kysely' => $uusi));
        $kysely->save();
        Kyselyryhma::saveToLaari($ryhmaid, $kysely->kyselyid);
        
    }

}
