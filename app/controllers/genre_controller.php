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

    /* Uuden genren tallentaminen - ylläpitäjä tekee */
    public static function administratorStore($leffaid) {
        $param = $_POST;
        $genre = new Genre(array('genrenimi' => $param['genrenimi']));

        $id = $genre->save();
        $param['genrelista'] = $id;
        LaariController::genrelaariSaveAdministrator($param, $leffaid);
    }

}
