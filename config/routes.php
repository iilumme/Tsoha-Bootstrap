<?php

//ETUSIVU
$routes->get('/', function() {
    HelloWorldController::first_page();
});

$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
});

$routes->get('/register', function() {
    HelloWorldController::register();
});

$routes->get('/login', function() {
    HelloWorldController::login();
});

//ELOKUVAN LISAYS
$routes->get('/addmovie', function() {
    MovieController::addpage();
});

$routes->get('/addmovie/addpeople', function() {
    MovieController::addArtistitpage();
});

$routes->get('/search', function() {
    HelloWorldController::search();
});

$routes->get('/movie/edit', function() {
    HelloWorldController::movieEdit();
});

$routes->get('/movie/:id', function($id) {
    MovieController::showOne($id);
});

$routes->get('/lists', function() {
    HelloWorldController::lists();
});

$routes->get('/mypage', function() {
    HelloWorldController::mypage();
});

$routes->get('/artist/:id', function($id) {
    ArtistController::showOne($id);
});

$routes->get('/artist', function() {
    HelloWorldController::artist();
});

$routes->get('/testisivu', function() {
    HelloWorldController::test();
});


//POST

$routes->post('/testisivu', function() {
    $par = $_POST;
    Kint::dump($par);
    HelloWorldController::test();
});

$routes->post('/addmovie/addpeople', function() {
    MovieController::store();
});

//$routes->post('/movie/1', function() {
//    LaariController::store();
//});