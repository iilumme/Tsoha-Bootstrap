<?php

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

$routes->get('/addmovie', function() {
    MovieController::addpage();
});

$routes->post('/addmovie/addpeople', function() {
    MovieController::store();
});

$routes->post('/movie/1', function() {
    LaariController::store();
});

$routes->get('/addmovie/addpeople', function() {
    MovieController::addArtistitpage();
});

$routes->get('/search', function() {
    HelloWorldController::search();
});

$routes->get('/movie', function() {
    HelloWorldController::movie();
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




