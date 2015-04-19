<?php

class Artistilaari extends BaseModel {

    public $artistiid, $leffaid;

    public function __construct($attribuutit) {
        parent::__construct($attribuutit);
    }
    
    public function saveSuggestion($ryhmaid) {
        $query = ('INSERT INTO ArtistiLaari (artistiid, leffaid) '
                . 'VALUES (:artistiid, :leffaid) RETURNING artistiid');        
        
        $sijoituspaikat = array(":artistiid", ":leffaid");
        $parametrit = array($this->artistiid, $this->leffaid);

        $uusi = str_replace($sijoituspaikat, $parametrit, $query);

        $kyselyryhma = new Kyselyryhma(array());
        $kysely = new Kyselyehdotus(array(
            'kysely' => $uusi
        ));
        $kysely->save();
        $kyselyryhma->saveToLaari($ryhmaid, $kysely->kyselyid);
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO ArtistiLaari (artistiid, leffaid) '
                . 'VALUES (:artistiid, :leffaid) RETURNING artistiid');
        $query->execute(array(
            'artistiid' => $this->artistiid,
            'leffaid' => $this->leffaid
        ));
    }


}
