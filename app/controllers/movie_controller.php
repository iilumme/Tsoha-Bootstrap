<?php

class MovieController extends BaseController{
    public static function index(){
        $elokuvat = Elokuva::all();
        View::make('movie/leffaetusivukokeilu.html', array('elokuvat'=>$elokuvat));
    }
    
}

