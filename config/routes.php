<?php

//ETUSIVU
$routes->get('/', function() {
    BasisController::first_page();
});

$routes->get('/hiekkalaatikko', function() {
    BasisController::sandbox();
});

$routes->get('/register', function() {
    BasisController::register();
});

$routes->get('/login', function() {
    BasisController::login();
});

$routes->get('/search', function() {
    BasisController::search();
});




//ELOKUVAN ETUSIVU
$routes->get('/movie/:id', function($id) {
    MovieController::showOne($id);
});

//ELOKUVAN LISAYS
$routes->get('/addmovie', function() {
    MovieController::add_movie();
});

//ARTISTIEN LISAYS
$routes->get('/addmovie/addpeople', function() {
    MovieController::add_artistit();
});

//ELOKUVAN MUOKKAUS
$routes->get('/edit', function() {
    BasisController::movieEdit();
});

$routes->get('/country/:id', function($id){
    ValtioController::showOne($id);
});


$routes->get('/lists', function() {
    BasisController::lists();
});

$routes->get('/mypage', function() {
    BasisController::mypage();
});

$routes->get('/artist/:id', function($id) {
    ArtistController::showOne($id);
});

$routes->get('/artist', function() {
    BasisController::artist();
});

$routes->get('/testisivu', function() {
    BasisController::test();
});

$routes->get('/artistitestisivu', function() {
    BasisController::test();
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
