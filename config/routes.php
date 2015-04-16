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
    UserController::mypage();
});
$routes->get('/mypage/edit', 'check_logged_in', function() {
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
    UserController::destroy(BaseController::get_user_logged_in()->kayttajaid);
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



//ELOKUVA
$routes->get('/movie/:id', function($id) {
    MovieController::showOne($id);
});

$routes->get('/movie/edit/:id', 'check_logged_in', function($id) {
    MovieController::movieeditpage($id);
});
$routes->post('/movieeditpage/:id', 'check_logged_in', function($id) {
    MovieController::update($id);
});
$routes->post('/movie/destroy/:id', 'check_logged_in', function($id) {
    MovieController::destroy($id);
});

$routes->get('/addmovie', 'check_logged_in', function() {
    MovieController::addmoviepage();
});
$routes->get('/addmovie/addpeople', 'check_logged_in', function() {
    MovieController::addartistspage();
});
$routes->post('/addmovie/addpeople', function() {
    MovieController::store();
});


//ARTISTI
$routes->get('/artist/:id', function($id) {
    ArtistController::showOne($id);
});

$routes->get('/artist/edit/:id', 'check_logged_in', function($id) {
    ArtistController::artisteditpage($id);
});
$routes->post('/artisteditpage/:id', function($id) {
    ArtistController::update($id);
});

$routes->post('/artist/destroy/:id', function($id) {
    ArtistController::destroy($id);
});


//VALTIO
$routes->get('/country/:id', function($id) {
    ValtioController::showOne($id);
});

$routes->get('/country/edit/:id', 'check_logged_in', function($id) {
    ValtioController::countryEdit($id);
});
$routes->post('/countryeditpage/:id', function($id) {
    ValtioController::update($id);
});



//
$routes->post('/testisivu', function() {
    LaariController::store();
});
$routes->post('/genrepostisivu/:id', function($id) {
    GenreController::store($id);
});
$routes->post('/sarjapostisivu/:id', function($id) {
    SarjaController::store($id);
});
$routes->post('/artistipostisivu/:id', function($id) {
    ArtistController::store($id);
});


//HIEKKALAATIKKO
$routes->get('/hiekkalaatikko', function() {
    BasisController::sandbox();
});