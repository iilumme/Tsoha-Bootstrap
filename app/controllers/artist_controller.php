<?php

class ArtistController extends BaseController {

    public static function showOne($id) {
        $artistit = array();
        $artisti = Artisti::findOne($id);
        $artistit[] = $artisti;

        $valtiot = array();
        $valtio = Valtio::findValtioForArtisti($id);
        $valtiot[] = $valtio;

        $leffat = Elokuva::findElokuvatForArtisti($id);
        
        View::make('artist/artistietusivu.html', array(
            'artistit' => $artistit,
            'valtiot' => $valtiot,
            'elokuvat' => $leffat
        ));
    }
    
    public static function store() {
        $parametrit = $_POST;

        $artisti = new Artisti(array(
            'artistityyppi' => $parametrit['artistityyppi'],
            'etunimi' => $parametrit['etunimi'],
            'sukunimi' => $parametrit['sukunimi'],
            'bio' => $parametrit['bio'],
            'syntymavuosi' => (int) $parametrit['syntymavuosi'],
            'valtio' => (int) $parametrit['valtio']
        ));          

        $artisti->save();

        //Redirect::to('/addmovie/addpeople' , array('message' => $artisti->artistiid));
    }
}
