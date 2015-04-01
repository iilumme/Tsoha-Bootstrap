<?php

//ETUSIVU
$routes->get('/', function() {
    BasisController::first_page();
});

$routes->get('/hiekkalaatikko', function() {
    BasisController::sandbox();
});


//HAKU
$routes->get('/search', function() {
    SearchController::search();
});


//KÄYTTÄJÄ
$routes->get('/register', function() {
    UserController::register();
});

$routes->get('/login', function() {
    UserController::login();
});

$routes->get('/lists', function() {
    UserController::lists();
});

$routes->get('/mypage', function() {
    UserController::mypage();
});



//ELOKUVAN ETUSIVU
$routes->get('/movie/:id', function($id) {
    MovieController::showOne($id);
});

//ELOKUVAN LISAYSSIVU
$routes->get('/addmovie', function() {
    MovieController::add_movie();
});

//ELOKUVAN MUOKKAUSSIVU
$routes->get('/movie/edit/:id', function($id) {
    MovieController::movieEdit($id);
});



//ARTISTIN ETUSIVU
$routes->get('/artist/:id', function($id) {
    ArtistController::showOne($id);
});

//ARTISTIEN LISAYSSIVU
$routes->get('/addmovie/addpeople', function() {
    MovieController::add_artistit();
});

$routes->get('/artist/edit/:id', function($id) {
    ArtistController::artistEdit($id);
});


$routes->get('/artist', function() {
    BasisController::artist();
});


//TESTISIVUT
$routes->get('/testisivu', function() {
    BasisController::test();
});

$routes->get('/artistitestisivu', function() {
    BasisController::test();
});


//VALTIOSIVU
$routes->get('/country/:id', function($id) {
    ValtioController::showOne($id);
});


//POST
$routes->post('/testisivu', function() {
    $par = $_POST;
    Kint::dump($par);
    LaariController::store();
});

$routes->post('/artistipostisivu', function() {
    ArtistController::store();
});

$routes->post('/addmovie/addpeople', function() {
    MovieController::store();
});

