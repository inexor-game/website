<?php

// Composer autoloader for required packages and dependencies
require_once('lib/autoload.php');
$f3 = \Base::instance();

$f3->set('DEBUG',1);
if ((float)PCRE_VERSION<7.9)
	trigger_error('PCRE version is out of date');

/**
 * TODO: Notes
 * Implement a download page
 * 	- use an FTP library to connect to our host
 * 	- filter all master builds
 * 	- build a list with font-awesome distribution icons
 */
// Load configuration
$f3->config('config.ini');

// Specific controllers
$f3->route('GET /', 'Controllers\Landing->index');
$f3->route('GET /blog/@year', 'Controllers\Blog->year');
$f3->route('GET /blog/@year/@entry', 'Controllers\Blog->entry');
$f3->route('GET /download/index [ajax]', 'Controllers\Download->request');

// Generic routing
$f3->route('GET /@controller', 'Controllers\@controller->index');
$f3->route('GET /@controller/@action', 'Controllers\@controller->@action');
$f3->route('GET /@controller/@action/@param', 'Controllers\@controller->@action');

// Error handling
$f3->set('ONERROR', function($f3) {
	$f3->set('content', 'error.htm');
	echo \Template::instance()->render('layout.htm');
});

$f3->run();
