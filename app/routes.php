<?php

/**
 * Application Routes goes here...
 *
 */

/** Home Page **/
// $routes['/'] = 'WelcomeController.indexAction';

$routes['/'] = array(
    'callback' => 'Sample\\Welcome.indexAction',
    'method' => '' /*  array('GET', 'POST') */,
    'cache' => true
);

/** 404 Page Not Found **/
$routes['404'] = 'Sample\\Error.pagenotfoundAction';
