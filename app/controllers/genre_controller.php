<?php

class GenreController extends BaseController {

    public static function store($leffaid) {
        $param = $_POST;

        $genre = new Genre(array(
            'genrenimi' => $param['genrenimi']
        ));

        $id = $genre->save();
        $param['genrelista'] = $id;
        LaariController::genrelaariSave($param, $leffaid);
    }

}
