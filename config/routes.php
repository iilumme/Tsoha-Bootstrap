<?php

$routes->get('/', function() {
    HelloWorldController::first_page();
});

$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
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

$routes->get('/register', function() {
    HelloWorldController::register();
});

$routes->get('/search', function() {
    HelloWorldController::search();
});