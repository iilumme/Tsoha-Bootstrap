<?php

function check_logged_in() {
    BaseController::check_logged_in();
}

//ETUSIVU
$routes->get('/', function() {
    BasisController::firstPage();
});


//HAKU
$routes->get('/search', function() {
    SearchController::searchpage();
});


//KAIKKI
$routes->get('/allobjects', function() {
    BasisController::all();
});


//KÄYTTÄJÄ
$routes->get('/register', function() {
    UserController::register();
});
$routes->post('/register', function() {
    UserController::store();
});


$routes->get('/login', function() {
    UserController::login();
});
$routes->post('/login', function() {
    UserController::handleLogin();
});


$routes->post('/logout', function() {
    UserController::logout();
});


$routes->get('/mypage', 'check_logged_in', function() {
    if (BaseController::isAdministrator() == FALSE) {
        UserController::myPage();
    } else {
        UserController::administratorPage();
    }
});
$routes->get('/mypage/edit', 'check_logged_in', function() {
    if (BaseController::isAdministrator() == FALSE) {
        UserController::profileEdit();
    } else {
        UserController::administratorEdit();
    }
});
$routes->post('/usereditpage', function() {
    UserController::update(BaseController::get_user_logged_in()->kayttajaid);
});


$routes->get('/favourites', 'check_logged_in', function() {
    UserController::favourites();
});
$routes->get('/watched', 'check_logged_in', function() {
    UserController::watchedMovies();
});
$routes->get('/mastarde', 'check_logged_in', function() {
    UserController::later();
});
$routes->get('/dvds', 'check_logged_in', function() {
    UserController::dvds();
});


$routes->post('/userdestroy', function() {
    if (BaseController::isAdministrator() == TRUE) {
        UserController::administratorPage();
    } else {
        UserController::destroy(BaseController::get_user_logged_in()->kayttajaid);
    }
});
$routes->post('/user/destroymaintenance/:id', function($id) {
    if (BaseController::isAdministrator() == TRUE) {
        UserController::destroyMaintenancey($id);
    }
});


$routes->post('/suosikkilisayssivu', function() {
    UserController::addFavourites();
});
$routes->post('/suosikkipoistosivu', function() {
    UserController::removeFavourites();
});

$routes->post('/dvdlisayssivu', function() {
    UserController::addDVDs();
});
$routes->post('/dvdpoistosivu', function() {
    UserController::removeDVDs();
});

$routes->post('/katsottulisayssivu', function() {
    UserController::addWatched();
});
$routes->post('/katsottupoistosivu', function() {
    UserController::removeWatched();
});

$routes->post('/mastardelisayssivu', function() {
    UserController::addMasTarde();
});
$routes->post('/mastardepoistosivu', function() {
    UserController::removeMasTarde();
});


$routes->post('/suosikkilisays/:id', function($id) {
    UserController::addFavourite($id);
});
$routes->post('/katsottulisays/:id', function($id) {
    UserController::addWatchedMovie($id);
});
$routes->post('/mastardelisays/:id', function($id) {
    UserController::addMastardeMovie($id);
});

//ADMINISTRATOR
$routes->get('/maintenance', 'check_logged_in', function() {
    if (BaseController::isAdministrator() == TRUE) {
        QueryController::maintenance();
    } else {
        BasisController::firstPage();
    }
});

$routes->post('/kyselylisays/:id', function($id) {
    QueryController::queryAccepted($id);
});
$routes->post('/kyselypoisto/:id', function($id) {
    QueryController::queryDenied($id);
});

$routes->get('/moviemaintenance', 'check_logged_in', function() {
    if (BaseController::isAdministrator() == TRUE) {
        UserController::movieMaintenance();
    } else {
        BasisController::firstPage();
    }
});
$routes->get('/artistmaintenance', 'check_logged_in', function() {
    if (BaseController::isAdministrator() == TRUE) {
        UserController::artistMaintenance();
    } else {
        BasisController::firstPage();
    }
});
$routes->get('/usermaintenance', 'check_logged_in', function() {
    if (BaseController::isAdministrator() == TRUE) {
        UserController::userMaintenance();
    } else {
        BasisController::firstPage();
    }
});

//ELOKUVA
$routes->get('/movie/:id', function($id) {
    MovieController::showOne($id);
});

$routes->get('/movie/edit/:id', 'check_logged_in', function($id) {
    MovieController::movieEditPage($id);
});
$routes->post('/movieeditpage/:id', 'check_logged_in', function($id) {
    if (BaseController::isAdministrator() == TRUE) {
        MovieController::administratorUpdate($id);
    } else {
        MovieController::updateSuggestion($id);
    }
});
$routes->post('/movie/destroy/:id', 'check_logged_in', function($id) {
    if (BaseController::isAdministrator() == TRUE) {
        MovieController::destroy($id);
    }
});
$routes->post('/movie/destroymaintenance/:id', 'check_logged_in', function($id) {
    if (BaseController::isAdministrator() == TRUE) {
        MovieController::destroyMaintenance($id);
    }
});

$routes->get('/addmovie', 'check_logged_in', function() {
    MovieController::addMoviePage();
});
$routes->get('/addmovie/addpeople', 'check_logged_in', function() {
    MovieController::addArtistsPage();
});
$routes->post('/addmovie/addpeople', 'check_logged_in', function() {
    if (BaseController::isAdministrator() == TRUE) {
        MovieController::administratorStore();
    } else {
        MovieController::storeSuggestion();
    }
});


//ARTISTI
$routes->get('/artist/:id', function($id) {
    ArtistController::showOne($id);
});

$routes->get('/artist/edit/:id', 'check_logged_in', function($id) {
    ArtistController::artistEditPage($id);
});
$routes->post('/artisteditpage/:id', 'check_logged_in', function($id) {
    if (BaseController::isAdministrator() == TRUE) {
        ArtistController::administratorUpdate($id);
    } else {
        ArtistController::updateSuggestion($id);
    }
});

$routes->post('/artist/destroy/:id', function($id) {
    if (BaseController::isAdministrator() == TRUE) {
        ArtistController::destroy($id);
    }
});
$routes->post('/artist/destroymaintenance/:id', function($id) {
    if (BaseController::isAdministrator() == TRUE) {
        ArtistController::destroyMaintenance($id);
    }
});


//VALTIO
$routes->get('/country/:id', function($id) {
    ValtioController::showOne($id);
});

$routes->get('/country/edit/:id', 'check_logged_in', function($id) {
    ValtioController::countryEdit($id);
});
$routes->post('/countryeditpage/:id', 'check_logged_in', function($id) {
    if (BaseController::isAdministrator() == TRUE) {
        ValtioController::administratorUpdate($id);
    } else {
        ValtioController::updateSuggestion($id);
    }
});



//LAARIT
$routes->post('/testisivu', function() {
    if (BaseController::isAdministrator() == TRUE) {
        LaariController::administratorStore();
    } else {
        LaariController::storeSuggestion();
    }
});
$routes->post('/genrepostisivu/:id', function($id) {
    if (BaseController::isAdministrator() == TRUE) {
        GenreController::administratorStore($id);
    } else {
        GenreController::storeSuggestion($id);
    }
});
$routes->post('/sarjapostisivu/:id', function($id) {
    if (BaseController::isAdministrator() == TRUE) {
        SarjaController::administratorStore($id);
    } else {
        SarjaController::storeSuggestion($id);
    }
});
$routes->post('/artistipostisivu/:id', function($id) {
    if (BaseController::isAdministrator() == TRUE) {
        ArtistController::administratorStore($id);
    } else {
        ArtistController::storeSuggestion($id);
    }
});

$routes->post('/arviopostisivu/:id', function($id) {
    MovieController::addStar($id);
});


//HIEKKALAATIKKO
$routes->get('/hiekkalaatikko', function() {
    if (BaseController::isAdministrator() == TRUE) {
        BasisController::sandbox();
    } else {
        BasisController::firstPage();
    }
});
