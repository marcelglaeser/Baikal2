<?php

use Symfony\Component\HttpFoundation\Request;

// If you don't want to setup permissions the proper way, just uncomment the following PHP line
// read http://symfony.com/doc/current/book/installation.html#configuration-and-setup for more information
//umask(0000);

// This check prevents access to debug front controllers that are deployed by accident to production servers.
// Feel free to remove this, extend it, or make something more sophisticated.
#if (isset($_SERVER['HTTP_CLIENT_IP'])
#    || isset($_SERVER['HTTP_X_FORWARDED_FOR'])
#    || !in_array(@$_SERVER['REMOTE_ADDR'], array('127.0.0.1', 'fe80::1', '::1'))
#) {
#    header('HTTP/1.0 403 Forbidden');
#    exit('You are not allowed to access this file. Check '.basename(__FILE__).' for more information.');
#}
if(@date_default_timezone_get() === 'UTC') {
    date_default_timezone_set('Europe/Paris');
}

$loader = require_once __DIR__.'/../app/bootstrap.php.cache';
require_once __DIR__.'/../app/AppKernel.php';

$kernel = new AppKernel('dev', true);
$kernel->loadClassCache();
Request::enableHttpMethodParameterOverride();
$request = Request::createFromGlobals();

if(intval($request->server->get('X_HEROKU')) == 1) {
    # Allow Symfony to rely on Heroku's proxy's informations, like X_FORWARDED_PORT
    Request::setTrustedProxies(array($request->server->get('REMOTE_ADDR')));
}

$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);