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
HelloWorldController::add_movie();
});

$routes->get('/addmovie/addpeople', function() {
HelloWorldController::add_people();
});

$routes->get('/search', function() {
HelloWorldController::search();
});

$routes->get('/movie', function() {
HelloWorldController::movie();
});

$routes->get('/lists', function() {
HelloWorldController::lists();
});

$routes->get('/mypage', function() {
HelloWorldController::mypage();
});

$routes->get('/artist', function() {
HelloWorldController::artist();
});