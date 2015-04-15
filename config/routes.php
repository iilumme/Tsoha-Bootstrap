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

$routes->get('/favourites', 'check_logged_in', function() {
    UserController::favourites();
});

$routes->get('/watched', 'check_logged_in', function() {
    UserController::seen();
});

$routes->get('/mastarde', 'check_logged_in', function() {
    UserController::later();
});
$routes->get('/dvds', 'check_logged_in', function() {
    UserController::dvds();
});

$routes->get('/mypage', 'check_logged_in', function() {
    UserController::mypage();
});

$routes->get('/mypage/edit', 'check_logged_in', function() {
    UserController::mypageedit();
});



//ELOKUVAN ETUSIVU
$routes->get('/movie/:id', function($id) {
    MovieController::showOne($id);
});

//ELOKUVAN LISAYSSIVU
$routes->get('/addmovie', 'check_logged_in', function() {
    MovieController::addmoviepage();
});

//ELOKUVAN MUOKKAUSSIVU
$routes->get('/movie/edit/:id', 'check_logged_in', function($id) {
    MovieController::movieeditpage($id);
});



//ARTISTIN ETUSIVU
$routes->get('/artist/:id', function($id) {
    ArtistController::showOne($id);
});

//ARTISTIEN LISAYSSIVU
$routes->get('/addmovie/addpeople', 'check_logged_in', function() {
    MovieController::addartistspage();
});

$routes->get('/artist/edit/:id', 'check_logged_in', function($id) {
    ArtistController::artisteditpage($id);
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

$routes->post('/artistipostisivu/:id', function($id) {
    ArtistController::store($id);
});

$routes->post('/genrepostisivu/:id', function($id) {
    GenreController::store($id);
});

$routes->post('/sarjapostisivu/:id', function($id) {
    SarjaController::store($id);
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

$routes->post('/usereditpage', function() {
    UserController::update(BaseController::get_user_logged_in()->kayttajaid);
});

$routes->post('/userdestroy', 'check_logged_in', function() {
    UserController::destroy(BaseController::get_user_logged_in()->kayttajaid);
});