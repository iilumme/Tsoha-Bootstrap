<?php

/* Eri -Laareihin liittyvien asioiden kontrollointi */

/* Varaudu pahimpaan :D */

class LaariController extends BaseController {


    /* REKISTERÖITYNEEN KÄYTTÄJÄN METODIT */


    /* UUSI ELOKUVA */

    /* Uuden elokuvan artistien, genrejen ja sarjojen ehdotusten tallentaminen */
    public static function storeSuggestion() {
        $params = $_POST;
        $ryhmaid = (int) $params['ryhmaid'];

        LaariController::artistilaariSaveSuggestion($params, $ryhmaid);
        LaariController::genrelaariSaveSuggestion($params, $ryhmaid);

        if (isset($params['sarjalista'])) {
            LaariController::sarjalaariSaveSuggestion($params, $ryhmaid);
        }

        Redirect::to('/', array('newMovieMessage' => "Ehdotus elokuvasta tekijöineen lähetetty ylläpitäjälle! :)"));
    }

    /* Uuden elokuvan artistiehdotusten tallentaminen */
    public static function artistilaariSaveSuggestion($params, $ryhmaid) {

        $input = $params['artistilista'];
        $output = explode(',', $input);

        foreach ($output as $artistiid) {
            if ($artistiid != 0) {
                $artistilaari = new Artistilaari(array(
                    'artistiid' => (int) $artistiid,
                    'leffaid' => ':leffaid'
                ));
                $artistilaari->saveSuggestion($ryhmaid);
            }
        }
    }

    /* Uuden elokuvan genreehdotusten tallentaminen */
    public static function genrelaariSaveSuggestion($params, $ryhmaid) {

        $input = $params['genrelista'];
        $output = explode(',', $input);

        foreach ($output as $genreid) {
            if ($genreid != 0) {
                $genrelaari = new Genrelaari(array(
                    'genreid' => (int) $genreid,
                    'leffaid' => ':leffaid'
                ));
                $genrelaari->saveSuggestion($ryhmaid);
            }
        }
    }

    /* Uuden elokuvan sarjaehdotusten tallentaminen */
    public static function sarjalaariSaveSuggestion($params, $ryhmaid) {

        $input = $params['sarjalista'];
        $output = explode(',', $input);

        foreach ($output as $sarjaid) {
            if ($sarjaid != 0) {
                $sarjalaari = new Sarjalaari(array(
                    'sarjaid' => (int) $sarjaid,
                    'leffaid' => ':leffaid'
                ));
                $sarjalaari->saveSuggestion($ryhmaid);
            }
        }
    }

    /* Uuden elokuvan uusien artistiehdotusten tallentaminen */
    public static function artistilaariSaveSuggestionWithoutArtistiID($ryhmaid) {

        $artistilaari = new Artistilaari(array(
            'artistiid' => ':artistiid',
            'leffaid' => ':leffaid'
        ));
        $artistilaari->saveSuggestion($ryhmaid);
    }

    /* Uuden elokuvan uusien genreehdotusten tallentaminen */
    public static function genrelaariSaveSuggestionWithoutGenreID($ryhmaid) {

        $genrelaari = new Genrelaari(array(
            'genreid' => ':genreid',
            'leffaid' => ':leffaid'
        ));
        $genrelaari->saveSuggestion($ryhmaid);
    }

    /* Uuden elokuvan uusien sarjaehdotusten tallentaminen */
    public static function sarjalaariSaveSuggestionWithoutSarjaID($ryhmaid) {

        $sarjalaari = new Sarjalaari(array(
            'sarjaid' => ':sarjaid',
            'leffaid' => ':leffaid'
        ));
        $sarjalaari->saveSuggestion($ryhmaid);
    }

    
    /* ELOKUVAN MUOKKAUS */


    /* Elokuvan artistien, genrejen ja sarjojen muokkausehdotusten tallentaminen */
    public static function updateSuggestion($leffaid, $ryhmaid) {
        $params = $_POST;

        LaariController::artistilaariDeleteOnUpdateSuggestion($params, $leffaid, $ryhmaid);
        LaariController::genrelaariDeleteOnUpdateSuggestion($params, $leffaid, $ryhmaid);
        LaariController::sarjalaariDeleteOnUpdateSuggestion($params, $leffaid, $ryhmaid);

        LaariController::artistilaariSaveOnUpdateSuggestion($params, $leffaid, $ryhmaid);
        LaariController::genrelaariSaveOnUpdateSuggestion($params, $leffaid, $ryhmaid);
        LaariController::sarjalaariSaveOnUpdateSuggestion($params, $leffaid, $ryhmaid);

        Redirect::to('/movie/' . $leffaid, array('editMessage' => "Ehdotus muokkauksesta lähetetty ylläpitäjälle! :) "));
    }

    /* Elokuvan artistiehdotusten tallentaminen - MUOKKAUS */
    public static function artistilaariDeleteOnUpdateSuggestion($params, $leffaid, $ryhmaid) {

        $input = $params['poistettavatartistit'];
        $output = explode(',', $input);

        foreach ($output as $artistiid) {
            if ($artistiid != 0) {
                $artistilaari = new Artistilaari(array(
                    'artistiid' => (int) $artistiid,
                    'leffaid' => $leffaid
                ));
                $artistilaari->destroySuggestion($ryhmaid);
            }
        }
    }

    /* Elokuvan genreehdotusten tallentaminen - MUOKKAUS */
    public static function genrelaariDeleteOnUpdateSuggestion($params, $leffaid, $ryhmaid) {

        $input = $params['poistettavatgenret'];
        $output = explode(',', $input);

        foreach ($output as $genreid) {
            if ($genreid != 0) {
                $genrelaari = new Genrelaari(array(
                    'genreid' => (int) $genreid,
                    'leffaid' => $leffaid
                ));
                $genrelaari->destroySuggestion($ryhmaid);
            }
        }
    }

    /* Elokuvan genreehdotusten tallentaminen - MUOKKAUS */
    public static function sarjalaariDeleteOnUpdateSuggestion($params, $leffaid, $ryhmaid) {

        $input = $params['poistettavatsarjat'];
        $output = explode(',', $input);

        foreach ($output as $sarjaid) {
            if ($sarjaid != 0) {
                $sarjalaari = new Sarjalaari(array(
                    'sarjaid' => (int) $sarjaid,
                    'leffaid' => $leffaid
                ));
                $sarjalaari->destroySuggestion($ryhmaid);
            }
        }
    }

    /* Elokuvan artistiehdotusten tallentaminen */
    public static function artistilaariSaveOnUpdateSuggestion($params, $leffaid, $ryhmaid) {

        $input = $params['artistilista'];
        $output = explode(',', $input);

        foreach ($output as $artistiid) {
            if ($artistiid != 0) {
                $artistilaari = new Artistilaari(array(
                    'artistiid' => (int) $artistiid,
                    'leffaid' => $leffaid
                ));
                $artistilaari->saveSuggestion($ryhmaid);
            }
        }
    }

    /* Elokuvan genreehdotusten tallentaminen */
    public static function genrelaariSaveOnUpdateSuggestion($params, $leffaid, $ryhmaid) {

        $input = $params['genrelista'];
        $output = explode(',', $input);

        foreach ($output as $genreid) {
            if ($genreid != 0) {
                $genrelaari = new Genrelaari(array(
                    'genreid' => (int) $genreid,
                    'leffaid' => $leffaid
                ));
                $genrelaari->saveSuggestion($ryhmaid);
            }
        }
    }

    /* Elokuvan sarjaehdotusten tallentaminen */
    public static function sarjalaariSaveOnUpdateSuggestion($params, $leffaid, $ryhmaid) {

        $input = $params['sarjalista'];
        $output = explode(',', $input);

        foreach ($output as $sarjaid) {
            if ($sarjaid != 0) {
                $sarjalaari = new Sarjalaari(array(
                    'sarjaid' => (int) $sarjaid,
                    'leffaid' => $leffaid
                ));
                $sarjalaari->saveSuggestion($ryhmaid);
            }
        }
    }

    /* Elokuvan uusien artistiehdotusten tallentaminen - muokkaus */
    public static function artistilaariSaveSuggestionWithoutArtistiIDWithLeffaID($leffaid, $ryhmaid) {

        $artistilaari = new Artistilaari(array(
            'artistiid' => ':artistiid',
            'leffaid' => $leffaid
        ));
        $artistilaari->saveSuggestion($ryhmaid);
    }

    /* Elokuvan uusien genreehdotusten tallentaminen - muokkaus */
    public static function genrelaariSaveSuggestionWithoutGenreIDWithLeffaid($leffaid, $ryhmaid) {

        $genrelaari = new Genrelaari(array(
            'genreid' => ':genreid',
            'leffaid' => $leffaid
        ));

        $genrelaari->saveSuggestion($ryhmaid);
    }

    /* Elokuvan uusien sarjaehdotusten tallentaminen - muokkaus */
    public static function sarjalaariSaveSuggestionWithoutSarjaIDWithLeffaID($leffaid, $ryhmaid) {

        $sarjalaari = new Sarjalaari(array(
            'sarjaid' => ':sarjaid',
            'leffaid' => $leffaid
        ));
        $sarjalaari->saveSuggestion($ryhmaid);
    }

    /* Artistin elokuvaehdotusten tallentaminen */
    public static function artistilaariUpdateMoviesSuggestion($params, $artistiid, $ryhmaid) {

        $input = $params['poistettavatelokuvat'];
        $output = explode(',', $input);

        foreach ($output as $leffaid) {
            if ($leffaid != 0) {
                $artistilaari = new Artistilaari(array(
                    'artistiid' => $artistiid,
                    'leffaid' => (int) $leffaid));
                $artistilaari->destroySuggestion($ryhmaid);
            }
        }

        $in = $params['leffalista'];
        $out = explode(',', $in);

        foreach ($out as $leffaid) {
            if ($leffaid != 0) {
                $artistilaari = new Artistilaari(array(
                    'artistiid' => $artistiid,
                    'leffaid' => (int) $leffaid));
                $artistilaari->saveSuggestion($ryhmaid);
            }
        }
    }

    
    /* YLLÄPITÄJÄN METODIT */


    /* Uuden elokuvan artistien, genrejen ja sarjojen tallentaminen - ylläpitäjä tekee */
    public static function administratorStore() {
        $params = $_POST;
        $leffaid = (int) $params['leffaid'];

        LaariController::artistilaariSaveAdministrator($params, $leffaid);
        LaariController::genrelaariSaveAdministrator($params, $leffaid);

        if (isset($params['sarjalista'])) {
            LaariController::sarjalaariSaveAdministrator($params, $leffaid);
        }

        Redirect::to('/movie/' . $leffaid, array('newMovieMessage' => "Elokuva kokonaisuudessaan lisätty! :)"));
    }

    /* Uuden elokuvan artistien tallentaminen - ylläpitäjä tekee */
    public static function artistilaariSaveAdministrator($params, $leffaid) {

        $input = $params['artistilista'];
        $output = explode(',', $input);

        foreach ($output as $artistiid) {
            $artistilaari = new Artistilaari(array(
                'artistiid' => (int) $artistiid,
                'leffaid' => $leffaid
            ));
            $artistilaari->save();
        }
    }

    /* Uuden elokuvan genrejen tallentaminen - ylläpitäjä tekee */
    public static function genrelaariSaveAdministrator($params, $leffaid) {

        $input = $params['genrelista'];
        $output = explode(',', $input);

        foreach ($output as $genreid) {
            $genrelaari = new Genrelaari(array(
                'genreid' => (int) $genreid,
                'leffaid' => $leffaid
            ));
            $genrelaari->save();
        }
    }

    /* Uuden elokuvan sarjojen tallentaminen - ylläpitäjä tekee */
    public static function sarjalaariSaveAdministrator($params, $leffaid) {

        $input = $params['sarjalista'];
        $output = explode(',', $input);

        foreach ($output as $sarjaid) {
            $sarjalaari = new Sarjalaari(array(
                'sarjaid' => (int) $sarjaid,
                'leffaid' => $leffaid
            ));
            $sarjalaari->save();
        }
    }

    /* Elokuvan artistien, genrejen ja sarjojen muokkaaminen - ylläpitäjä tekee */
    public static function administratorUpdate($leffaid) {
        $params = $_POST;

        LaariController::artistilaariDeleteAdministrator($params, $leffaid);
        LaariController::genrelaariDeleteAdministrator($params, $leffaid);
        LaariController::sarjalaariDeleteAdministrator($params, $leffaid);

        LaariController::artistilaariSaveAdministrator($params, $leffaid);
        LaariController::genrelaariSaveAdministrator($params, $leffaid);
        LaariController::sarjalaariSaveAdministrator($params, $leffaid);

        Redirect::to('/movie/' . $leffaid, array('newMovieMessage' => "Elokuvan muokkaaminen onnistui! :) "));
    }

    /* Elokuvan artistien muokkaaminen - ylläpitäjä tekee */
    public static function artistilaariDeleteAdministrator($params, $leffaid) {

        $input = $params['poistettavatartistit'];
        $output = explode(',', $input);

        foreach ($output as $artistiid) {
            $artistilaari = new Artistilaari(array(
                'artistiid' => (int) $artistiid,
                'leffaid' => $leffaid
            ));
            $artistilaari->destroy();
        }
    }

    /* Elokuvan genrejen muokkaaminen - ylläpitäjä tekee */
    public static function genrelaariDeleteAdministrator($params, $leffaid) {

        $input = $params['poistettavatgenret'];
        $output = explode(',', $input);

        foreach ($output as $genreid) {
            $genrelaari = new Genrelaari(array(
                'genreid' => (int) $genreid,
                'leffaid' => $leffaid
            ));
            $genrelaari->destroy();
        }
    }

    /* Elokuvan genrejen muokkaaminen - ylläpitäjä tekee */
    public static function sarjalaariDeleteAdministrator($params, $leffaid) {

        $input = $params['poistettavatsarjat'];
        $output = explode(',', $input);

        foreach ($output as $sarjaid) {
            $sarjalaari = new Sarjalaari(array(
                'sarjaid' => (int) $sarjaid,
                'leffaid' => $leffaid
            ));
            $sarjalaari->destroy();
        }
    }

    /* Artistin elokuvien tallentaminen */
    public static function artistilaariUpdateMoviesAdministrator($params, $artistiid) {

        $input = $params['poistettavatelokuvat'];
        $output = explode(',', $input);

        foreach ($output as $leffaid) {
            if ($leffaid != 0) {
                $artistilaari = new Artistilaari(array(
                    'artistiid' => $artistiid,
                    'leffaid' => (int) $leffaid));
                $artistilaari->destroy();
            }
        }

        $in = $params['leffalista'];
        $out = explode(',', $in);

        foreach ($out as $leffaid) {
            if ($leffaid != 0) {
                $artistilaari = new Artistilaari(array(
                    'artistiid' => $artistiid,
                    'leffaid' => (int) $leffaid));
                $artistilaari->save();
            }
        }
    }

}
