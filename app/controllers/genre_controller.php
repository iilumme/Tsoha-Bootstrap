<?php

/* Genrejen kontrollointi */

class GenreController extends BaseController {
    
    /* Uusi ehdotus uudesta genrestä ja sen tallentaminen */
    public static function storeSuggestion($ryhmaid) {
        $params = $_POST;
        $genre = new Genre(array('genrenimi' => $params['genrenimi']));

        $genre->saveSuggestion($ryhmaid);
        LaariController::genrelaariSaveSuggestionWithoutGenreID($ryhmaid);
    }
    
    /* Uusi ehdotus uudesta genrestä, elokuvan päivittämisen yhteydessä */
    public static function storeSuggestionOnMovieUpdate($leffaid) {
        $params = $_POST;
        $genre = new Genre(array('genrenimi' => $params['genrenimi']));

        $ryhmaid = $genre->saveSuggestionOwnGroup();
        LaariController::genrelaariSaveSuggestionWithoutGenreIDWithLeffaid($leffaid, $ryhmaid);
    }

    /* Uuden genren tallentaminen - ylläpitäjä tekee */
    public static function administratorStore($leffaid) {
        $params = $_POST;
        $genre = new Genre(array('genrenimi' => $params['genrenimi']));

        $genreid = $genre->save();
        $params['genrelista'] = $genreid;
        LaariController::genrelaariSaveAdministrator($params, $leffaid);
    }

    /* Genren poistaminen ylläpitosivulla */
    public static function destroyMaintenance($genreid) {
        $genre = new Genre(array('genreid' => $genreid));
        $succeeded = $genre->destroy();
        if ($succeeded == 1) {
            Redirect::to('/genremaintenance', array('deleteMessage' => 'Genren poistaminen onnistui! :)'));
        } else {
            Redirect::to('/genremaintenance', array('message' => 'Genren poistaminen ei onnistunut. Genre on jonkun käyttäjän lempigenre. :)'));
        }
        
    }
}
