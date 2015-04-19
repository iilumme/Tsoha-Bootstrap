<?php

function check_logged_in() {
    BaseController::check_logged_in();
}

//ETUSIVU
$routes->get('/', function() {
    BasisController::first_page();
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
    UserController::handle_login();
});


$routes->post('/logout', function() {
    UserController::logout();
});


$routes->get('/mypage', 'check_logged_in', function() {
    if (BaseController::isAdministrator() == FALSE) {
        UserController::mypage();
    } else {
        UserController::adminpage();
    }
});
$routes->get('/mypage/edit', 'check_logged_in', function() {
    if (BaseController::isAdministrator() == FALSE) {
        UserController::mypageedit();
    } else {
        UserController::adminpageedit();
    }
    UserController::mypageedit();
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
        UserController::adminpage();
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
        BasisController::first_page();
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
        UserController::moviemaintenance();
    } else {
        BasisController::first_page();
    }
});
$routes->get('/artistmaintenance', 'check_logged_in', function() {
    if (BaseController::isAdministrator() == TRUE) {
        UserController::artistmaintenance();
    } else {
        BasisController::first_page();
    }
});
$routes->get('/usermaintenance', 'check_logged_in', function() {
    if (BaseController::isAdministrator() == TRUE) {
        UserController::usermaintenance();
    } else {
        BasisController::first_page();
    }
});

//ELOKUVA
$routes->get('/movie/:id', function($id) {
    MovieController::showOne($id);
});

$routes->get('/movie/edit/:id', 'check_logged_in', function($id) {
    MovieController::movieeditpage($id);
});
$routes->post('/movieeditpage/:id', 'check_logged_in', function($id) {
    if (BaseController::isAdministrator() == TRUE) {
        MovieController::adminUpdate($id);
    } else {
        MovieController::update($id);
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
    MovieController::addmoviepage();
});
$routes->get('/addmovie/addpeople', 'check_logged_in', function() {
    MovieController::addartistspage();
});
$routes->post('/addmovie/addpeople', 'check_logged_in', function() {
    if (BaseController::isAdministrator() == TRUE) {
        MovieController::adminStore();
    } else {
        MovieController::store();
    }
});


//ARTISTI
$routes->get('/artist/:id', function($id) {
    ArtistController::showOne($id);
});

$routes->get('/artist/edit/:id', 'check_logged_in', function($id) {
    ArtistController::artisteditpage($id);
});
$routes->post('/artisteditpage/:id', 'check_logged_in', function($id) {
    if (BaseController::isAdministrator() == TRUE) {
        ArtistController::adminUpdate($id);
    } else {
        ArtistController::update($id);
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
        ValtioController::adminUpdate($id);
    } else {
        ValtioController::update($id);
    }
});



//LAARIT
$routes->post('/testisivu', function() {
    if (BaseController::isAdministrator() == TRUE) {
        LaariController::adminStore();
    } else {
        LaariController::store();
    }
});
$routes->post('/genrepostisivu/:id', function($id) {
    if (BaseController::isAdministrator() == TRUE) {
        GenreController::adminStore($id);
    } else {
        GenreController::store($id);
    }
});
$routes->post('/sarjapostisivu/:id', function($id) {
    if (BaseController::isAdministrator() == TRUE) {
        SarjaController::adminStore($id);
    } else {
        SarjaController::store($id);
    }
});
$routes->post('/artistipostisivu/:id', function($id) {
    if (BaseController::isAdministrator() == TRUE) {
        ArtistController::adminStore($id);
    } else {
        ArtistController::store($id);
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
        BasisController::first_page();
    }
});
