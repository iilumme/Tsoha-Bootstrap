<?php

class GenreController extends BaseController {

    public static function store($ryhmaid) {
        $param = $_POST;
        $genre = new Genre(array('genrenimi' => $param['genrenimi']));

        $genre->saveSuggestion($ryhmaid);
        LaariController::genrelaariSaveWithoutID($ryhmaid);
    }
    
    public static function adminStore($leffaid) {
        $param = $_POST;
        $genre = new Genre(array('genrenimi' => $param['genrenimi']));

        $id = $genre->save();
        $param['genrelista'] = $id;
        LaariController::genrelaariSave($param, $leffaid);
    }

}
