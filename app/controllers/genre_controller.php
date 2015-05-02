<?php

/* Genrejen kontrollointi */

class GenreController extends BaseController {
    
    /* Uuden genre-ehdotuksen tallentaminen */
    public static function storeSuggestion($ryhmaid) {
        $param = $_POST;
        $genre = new Genre(array('genrenimi' => $param['genrenimi']));

        $genre->saveSuggestion($ryhmaid);
        LaariController::genrelaariSaveSuggestionWithoutGenreID($ryhmaid);
    }
    
    /* Uuden genre-ehdotuksen tallentaminen */
    public static function storeSuggestionUpdate($leffaid) {
        $param = $_POST;
        $genre = new Genre(array('genrenimi' => $param['genrenimi']));

        $ryhmaid = $genre->saveSuggestionOwnGroup();
        LaariController::genrelaariSaveSuggestionWithoutGenreIDWithLeffaid($leffaid, $ryhmaid);
    }

    /* Uuden genren tallentaminen - ylläpitäjä tekee */
    public static function administratorStore($leffaid) {
        $param = $_POST;
        $genre = new Genre(array('genrenimi' => $param['genrenimi']));

        $id = $genre->save();
        $param['genrelista'] = $id;
        LaariController::genrelaariSaveAdministrator($param, $leffaid);
    }

    /* Genren poistaminen ylläpitosivulla */
    public static function destroyMaintenance($genreid) {
        $genre = new Genre(array('genreid' => $genreid));
        $onnistuiko = $genre->destroy();
        if ($onnistuiko == 1) {
            Redirect::to('/genremaintenance', array('deleteMessage' => 'Genren poistaminen onnistui! :)'));
        } else {
            Redirect::to('/genremaintenance', array('message' => 'Genren poistaminen ei onnistunut. Genre on jonkun käyttäjän lempigenre. :)'));
        }
        
    }
}
