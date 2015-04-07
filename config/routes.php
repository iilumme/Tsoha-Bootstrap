<?php

function check_logged_in() {
    BaseController::check_logged_in();
}

//ETUSIVU
$routes->get('/', function() {
    BasisController::first_page();
});

$routes->get('/hiekkalaatikko', function() {
    BasisController::sandbox();
});


//HAKU
$routes->get('/search', function() {
    SearchController::searchpage();
});


//KÄYTTÄJÄ
$routes->get('/register', function() {
    UserController::register();
});

$routes->get('/login', function() {
    UserController::login();
});

$routes->get('/lists', 'check_logged_in', function() {
    UserController::lists();
});

$routes->get('/mypage', 'check_logged_in', function() {
    UserController::mypage();
});



//ELOKUVAN ETUSIVU
$routes->get('/movie/:id', function($id) {
    MovieController::showOne($id);
});

//ELOKUVAN LISAYSSIVU
$routes->get('/addmovie', 'check_logged_in', function() {
    MovieController::add_movie();
});

//ELOKUVAN MUOKKAUSSIVU
$routes->get('/movie/edit/:id', 'check_logged_in', function($id) {
    MovieController::movieEdit($id);
});



//ARTISTIN ETUSIVU
$routes->get('/artist/:id', function($id) {
    ArtistController::showOne($id);
});

//ARTISTIEN LISAYSSIVU
$routes->get('/addmovie/addpeople', 'check_logged_in', function() {
    MovieController::add_artistit();
});

$routes->get('/artist/edit/:id', 'check_logged_in', function($id) {
    ArtistController::artistEdit($id);
});


$routes->get('/artist', function() {
    BasisController::artist();
});


//TESTISIVUT
$routes->get('/testisivu', 'check_logged_in', function() {
    BasisController::test();
});

$routes->get('/artistitestisivu', 'check_logged_in', function() {
    BasisController::test();
});


//VALTIOSIVU
$routes->get('/country/:id', function($id) {
    ValtioController::showOne($id);
});

$routes->get('/country/edit/:id', 'check_logged_in', function($id) {
    ValtioController::countryEdit($id);
});

$routes->get('/allobjects', function() {
    BasisController::all();
});



//POST
$routes->post('/testisivu', function() {
    LaariController::store();
});

$routes->post('/artistipostisivu', function() {
    ArtistController::store();
});

$routes->post('/genrepostisivu', function() {
    GenreController::store();
});

$routes->post('/sarjapostisivu', function() {
    SarjaController::store();
});

$routes->post('/addmovie/addpeople', function() {
    MovieController::store();
});

$routes->post('/movieeditpage/:id', 'check_logged_in', function($id) {
    MovieController::update($id);
});

$routes->post('/artisteditpage/:id', function($id) {
    ArtistController::update($id);
});

$routes->post('/countryeditpage/:id', function($id) {
    ValtioController::update($id);
});

$routes->post('/artist/destroy/:id', 'check_logged_in', function($id) {
    ArtistController::destroy($id);
});

$routes->post('/movie/destroy/:id', 'check_logged_in', function($id) {
    MovieController::destroy($id);
});

$routes->post('/login', function() {
    UserController::handle_login();
});

$routes->post('/logout', function() {
    UserController::logout();
});

$routes->post('/register', function() {
    UserController::store();
});

$routes->post('/search', function() {
    SearchController::search();
});

