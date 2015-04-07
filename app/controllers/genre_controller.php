<?php

class GenreController extends BaseController {

    public static function store() {
        $param = $_POST;

        $genre = new Genre(array(
            'genrenimi' => $param['genrenimi']
        ));

        $genre->save();
    }

}
