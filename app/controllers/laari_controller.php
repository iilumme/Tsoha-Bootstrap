<?php

/* Eri -Laareihin liittyvien asioiden kontrollointi */

class LaariController extends BaseController {
    /* REKISTERÖITYNEEN KÄYTTÄJÄN METODIT */


    /* Uuden elokuvan artistien, genrejen ja sarjojen ehdotusten tallentaminen */
    public static function storeSuggestion() {
        $param = $_POST;
        $ryhmaid = (int) $param['ryhmaid'];

        LaariController::artistilaariSaveSuggestion($param, $ryhmaid);
        LaariController::genrelaariSaveSuggestion($param, $ryhmaid);

        if (isset($param['sarjalista'])) {
            LaariController::sarjalaariSaveSuggestion($param, $ryhmaid);
        }

        Redirect::to('/', array('message' => "Ehdotus elokuvasta tekijöineen lähetetty ylläpitäjälle :)"));
    }

    /* Uuden elokuvan artistiehdotusten tallentaminen */
    public static function artistilaariSaveSuggestion($param, $ryhmaid) {

        $input = $param['artistilista'];
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
    public static function genrelaariSaveSuggestion($param, $ryhmaid) {

        $input = $param['genrelista'];
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

    /* Elokuvan artistiehdotusten tallentaminen */
    public static function artistilaariSaveSuggestionUpdate($param, $leffaid, $ryhmaid) {

        $input = $param['artistilista'];
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
    public static function genrelaariSaveSuggestionUpdate($param, $leffaid, $ryhmaid) {

        $input = $param['genrelista'];
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

    /* Uuden elokuvan sarjaehdotusten tallentaminen */
    public static function sarjalaariSaveSuggestion($param, $ryhmaid) {

        $input = $param['sarjalista'];
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

    /* Elokuvan uusien artistiehdotusten tallentaminen - muokkaus */
    public static function artistilaariSaveSuggestionWithoutArtistiIDWithLeffaID($leffaid, $ryhmaid) {

        $artistilaari = new Artistilaari(array(
            'artistiid' => ':artistiid',
            'leffaid' => $leffaid
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

    /* Elokuvan uusien genreehdotusten tallentaminen - muokkaus */
    public static function genrelaariSaveSuggestionWithoutGenreIDWithLeffaid($leffaid, $ryhmaid) {

        $genrelaari = new Genrelaari(array(
            'genreid' => ':genreid',
            'leffaid' => $leffaid
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
    
    /* Uuden elokuvan uusien sarjaehdotusten tallentaminen */
    public static function sarjalaariSaveSuggestionWithoutSarjaIDWithLeffaID($leffaid, $ryhmaid) {

        $sarjalaari = new Sarjalaari(array(
            'sarjaid' => ':sarjaid',
            'leffaid' => $leffaid
        ));
        $sarjalaari->saveSuggestion($ryhmaid);
    }

    /* Elokuvan artistien, genrejen ja sarjojen muokkausehdotusten tallentaminen */
    public static function updateSuggestion($leffaid, $ryhmaid) {
        $param = $_POST;

        LaariController::artistilaariUpdateSuggestion($param, $leffaid, $ryhmaid);
        LaariController::genrelaariUpdateSuggestion($param, $leffaid, $ryhmaid);
        LaariController::artistilaariSaveSuggestionUpdate($param, $leffaid, $ryhmaid);
        LaariController::genrelaariSaveSuggestionUpdate($param, $leffaid, $ryhmaid);

        Redirect::to('/movie/' . $leffaid, array('message' => "Ehdotus muokkauksesta lähetetty ylläpitäjälle :)"));
    }

    /* Uuden elokuvan artistiehdotusten tallentaminen */
    public static function artistilaariUpdateSuggestion($param, $leffaid, $ryhmaid) {

        $input = $param['poistettavatartistit'];
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

    /* Uuden elokuvan genreehdotusten tallentaminen */
    public static function genrelaariUpdateSuggestion($param, $leffaid, $ryhmaid) {

        $input = $param['poistettavatgenret'];
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
    
    /* Artistin elokuvaehdotusten tallentaminen */
    public static function artistilaariUpdateSuggestionMovies($param, $artistiid, $ryhmaid) {

        $input = $param['poistettavatelokuvat'];
        $output = explode(',', $input);

        foreach ($output as $leffaid) {
            if ($leffaid != 0) {
                $artistilaari = new Artistilaari(array(
                    'artistiid' => $artistiid,
                    'leffaid' => (int) $leffaid));
                $artistilaari->destroySuggestion($ryhmaid);
            }
        }
        
        $in = $param['leffalista'];
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
        $param = $_POST;
        $leffaid = (int) $param['leffaid'];

        LaariController::artistilaariSaveAdministrator($param, $leffaid);
        LaariController::genrelaariSaveAdministrator($param, $leffaid);

        if (isset($param['sarjalista'])) {
            LaariController::sarjalaariSaveAdministrator($param, $leffaid);
        }

        Redirect::to('/movie/' . $leffaid, array('message' => "Elokuva kokonaisuudessaan lisätty! :)"));
    }

    /* Uuden elokuvan artistien tallentaminen - ylläpitäjä tekee */
    public static function artistilaariSaveAdministrator($param, $leffaid) {

        $input = $param['artistilista'];
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
    public static function genrelaariSaveAdministrator($param, $leffaid) {

        $input = $param['genrelista'];
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
    public static function sarjalaariSaveAdministrator($param, $leffaid) {

        $input = $param['sarjalista'];
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
        $param = $_POST;

        LaariController::artistilaariUpdateAdministrator($param, $leffaid);
        LaariController::genrelaariUpdateAdministrator($param, $leffaid);
        LaariController::artistilaariSaveAdministrator($param, $leffaid);
        LaariController::genrelaariSaveAdministrator($param, $leffaid);

//        if (isset($param['sarjalista'])) {
//            LaariController::sarjalaariSaveAdministrator($param, $leffaid);
//        }

        Redirect::to('/movie/' . $leffaid, array('message' => "Elokuvan muokkaaminen onnistui! :)"));
    }

    /* Elokuvan artistien muokkaaminen - ylläpitäjä tekee */
    public static function artistilaariUpdateAdministrator($param, $leffaid) {

        $input = $param['poistettavatartistit'];
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
    public static function genrelaariUpdateAdministrator($param, $leffaid) {

        $input = $param['poistettavatgenret'];
        $output = explode(',', $input);

        foreach ($output as $genreid) {
            $genrelaari = new Genrelaari(array(
                'genreid' => (int) $genreid,
                'leffaid' => $leffaid
            ));
            $genrelaari->destroy();
        }
    }
    
    /* Artistin elokuvien tallentaminen */
    public static function artistilaariUpdateMoviesAdministrator($param, $artistiid) {

        $input = $param['poistettavatelokuvat'];
        $output = explode(',', $input);

        foreach ($output as $leffaid) {
            if ($leffaid != 0) {
                $artistilaari = new Artistilaari(array(
                    'artistiid' => $artistiid,
                    'leffaid' => (int) $leffaid));
                $artistilaari->destroy();
            }
        }
        
        $in = $param['leffalista'];
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
