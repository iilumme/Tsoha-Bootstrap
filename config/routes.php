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
//Rekisteröityminen
$routes->get('/register', function() {
    UserController::register();
});
$routes->post('/register', function() {
    UserController::store();
});

//Sisäänkirjautuminen
$routes->get('/login', function() {
    UserController::login();
});
$routes->post('/login', function() {
    UserController::handleLogin();
});

//Uloskirjautuminen
$routes->post('/logout', function() {
    UserController::logout();
});

//Oma sivu
$routes->get('/mypage', 'check_logged_in', function() {
    if (BaseController::isAdministrator() == FALSE) {
        UserController::myPage();
    } else {
        UserController::administratorPage();
    }
});
//Oman sivun muokkaus
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
//Käyttäjä sivu
$routes->get('/userpage/:id', 'check_logged_in', function($id) {
    UserController::userPage($id);
});

//Viestipostisivut
$routes->post('/viestipostisivu', function() {
    MessageController::store('/userpage/');
});
$routes->post('/viestiposti', function() {
    MessageController::store('/mailbox');
});

$routes->post('/viestipoisto', function() {
    MessageController::destroy();
});

$routes->post('/viestipoistokaikki', function() {
    MessageController::destroyAll();
});

$routes->post('/viestipaivityssivu', function() {
    MessageController::update();
});

//Postilaatikko
$routes->get('/mailbox', function() {
    MessageController::mailbox();
});
$routes->post('/luettu/:id', function($id) {
    MessageController::read($id);
});

//Listat
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
//Listojen muokkaus
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

//Listoille lisäys elokuvan esittelysivulta
$routes->post('/suosikkilisays/:id', function($id) {
    UserController::addFavourite($id);
});
$routes->post('/katsottulisays/:id', function($id) {
    UserController::addWatchedMovie($id);
});
$routes->post('/mastardelisays/:id', function($id) {
    UserController::addMastardeMovie($id);
});
$routes->post('/dvdlisays/:id', function($id) {
    UserController::addDVDMovie($id);
});


//ELOKUVA
$routes->get('/movie/:id', function($id) {
    MovieController::showOne($id);
});
//Elokuvan muokkaus
$routes->get('/movie/edit/:id', 'check_logged_in', function($id) {
    MovieController::movieEditPage($id);
});
$routes->post('/movieeditpage/:id', 'check_logged_in', function($id) {
    if (BaseController::isAdministrator() == TRUE) {
        MovieController::administratorUpdate($id);
        LaariController::administratorUpdate($id);
    } else {
        MovieController::updateSuggestion($id);
    }
});

//Elokuvan lisäys
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
//Elokuvalle tähtiä
$routes->post('/arviopostisivu/:id', function($id) {
    MovieController::addStar($id);
});
//Elokuvalta pois tähtiä
$routes->post('/arviopoistosivu/:id', function($id) {
    MovieController::deleteStar($id);
});
//Elokuvalle kommentti
$routes->post('/kommenttipostisivu/:id', function($id) {
    MovieController::addComment($id);
});
//Elokuvalta pois kommentti
$routes->post('/kommenttipoistosivu/:id', function($id) {
    MovieController::deleteComment($id);
});


//ARTISTI
$routes->get('/artist/:id', function($id) {
    ArtistController::showOne($id);
});
//Artistin muokkaus
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


//VALTIO
$routes->get('/country/:id', function($id) {
    ValtioController::showOne($id);
});
//Valtion muokkaus
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



/* LAARIT */
//Tekijät, sarjat ja genret elokuvalle
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
$routes->post('/muokkausuusigenre/:id', function($id) {
    if (BaseController::isAdministrator() == TRUE) {
        GenreController::administratorStore($id);
    } else {
        GenreController::storeSuggestionUpdate($id);
    }
});
$routes->post('/sarjapostisivu/:id', function($id) {
    if (BaseController::isAdministrator() == TRUE) {
        SarjaController::administratorStore($id);
    } else {
        SarjaController::storeSuggestion($id);
    }
});
$routes->post('/muokkausuusisarja/:id', function($id) {
    if (BaseController::isAdministrator() == TRUE) {
        SarjaController::administratorStore($id);
    } else {
        SarjaController::storeSuggestionWithLeffaID($id);
    }
});
$routes->post('/artistipostisivu/:id', function($id) {
    if (BaseController::isAdministrator() == TRUE) {
        ArtistController::administratorStore($id);
    } else {
        ArtistController::storeSuggestion($id);
    }
});
$routes->post('/artistipostisivumuokkaus/:id', function($id) {
    if (BaseController::isAdministrator() == TRUE) {
        ArtistController::administratorStore($id);
    } else {
        ArtistController::storeSuggestionUpdate($id);
    }
});


//HIEKKALAATIKKO
$routes->get('/hiekkalaatikko', function() {
    if (BaseController::isAdministrator() == TRUE) {
        BasisController::sandbox();
    } else {
        BasisController::firstPage();
    }
});



/* ADMINISTRATOR */


//Kyselyt
$routes->get('/querymaintenance', 'check_logged_in', function() {
    if (BaseController::isAdministrator() == TRUE) {
        QueryController::queryMaintenancePage();
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
$routes->get('/addquery', 'check_logged_in', function() {
    if (BaseController::isAdministrator() == TRUE) {
        QueryController::queryAddPage();
    } else {
        BasisController::firstPage();
    }
});
$routes->post('/queryadd', function() {
    QueryController::addQuery();
});


//MAINTENANCE
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
$routes->get('/seriemaintenance', 'check_logged_in', function() {
    if (BaseController::isAdministrator() == TRUE) {
        UserController::serieMaintenance();
    } else {
        BasisController::firstPage();
    }
});
$routes->get('/genremaintenance', 'check_logged_in', function() {
    if (BaseController::isAdministrator() == TRUE) {
        UserController::genreMaintenance();
    } else {
        BasisController::firstPage();
    }
});
$routes->get('/commentmaintenance', 'check_logged_in', function() {
    if (BaseController::isAdministrator() == TRUE) {
        UserController::commentMaintenance();
    } else {
        BasisController::firstPage();
    }
});

//DESTROY - MAINTENANCE
$routes->post('/movie/destroymaintenance/:id', function($id) {
    if (BaseController::isAdministrator() == TRUE) {
        MovieController::destroyMaintenance($id);
    }
});
$routes->post('/artist/destroymaintenance/:id', function($id) {
    if (BaseController::isAdministrator() == TRUE) {
        ArtistController::destroyMaintenance($id);
    }
});
$routes->post('/user/destroymaintenance/:id', function($id) {
    if (BaseController::isAdministrator() == TRUE) {
        UserController::destroyMaintenance($id);
    }
});
$routes->post('/serie/destroymaintenance/:id', function($id) {
    if (BaseController::isAdministrator() == TRUE) {
        SarjaController::destroyMaintenance($id);
    }
});
$routes->post('/genre/destroymaintenance/:id', function($id) {
    if (BaseController::isAdministrator() == TRUE) {
        GenreController::destroyMaintenance($id);
    }
});
$routes->post('/comment/destroymaintenance/:kayttajaid/:leffaid', function($kayttajaid, $leffaid) {
    if (BaseController::isAdministrator() == TRUE) {
        UserController::destroyCommentMaintenance($kayttajaid, $leffaid);
    }
});


//DESTROY
$routes->post('/movie/destroy/:id', 'check_logged_in', function($id) {
    if (BaseController::isAdministrator() == TRUE) {
        MovieController::destroy($id);
    }
});
$routes->post('/artist/destroy/:id', function($id) {
    if (BaseController::isAdministrator() == TRUE) {
        ArtistController::destroy($id);
    }
});
$routes->post('/userdestroy', function() {
    if (BaseController::isAdministrator() == TRUE) {
        UserController::administratorPage();
    } else {
        UserController::destroy(BaseController::get_user_logged_in()->kayttajaid);
    }
});
