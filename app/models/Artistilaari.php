<?php

/* Malli elokuvan tekijöiden tallentamiselle elokuvakohtaisesti */

class Artistilaari extends BaseModel {

    public $artistiid, $leffaid;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }
    
    /* Ehdotuksen tallentaminen */
    public function saveSuggestion($ryhmaid) {
        $query = ('INSERT INTO ArtistiLaari (artistiid, leffaid) '
                . 'VALUES (:artistiid, :leffaid) RETURNING artistiid');              
        $locations = array(":artistiid", ":leffaid");
        $params = array($this->artistiid, $this->leffaid);
        $newQuery = str_replace($locations, $params, $query);

        $querySuggestion = new Kyselyehdotus(array('kysely' => $newQuery));
        $querySuggestion->save();
        Kyselyryhma::saveToLaari($ryhmaid, $querySuggestion->kyselyid);
    } 
    
    /* Poistamisehdotus */
    public function destroySuggestion($ryhmaid) {
        $query = ('DELETE FROM ArtistiLaari '
                . 'WHERE artistiID = :artistiid AND leffaID = :leffaid');             
        $locations = array(":artistiid", ":leffaid");
        $params = array($this->artistiid, $this->leffaid);
        $newQuery = str_replace($locations, $params, $query);

        $querySuggestion = new Kyselyehdotus(array('kysely' => $newQuery));
        $querySuggestion->save();
        Kyselyryhma::saveToLaari($ryhmaid, $querySuggestion->kyselyid);        
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
    
    

}
