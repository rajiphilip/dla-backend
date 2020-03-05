<?php

define('ENVIRONMENT', 'development');

if (ENVIRONMENT == 'development' || ENVIRONMENT == 'dev') {
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
}

define('URL_PUBLIC_FOLDER', 'public');
define('URL_PROTOCOL', '//');
define('URL_DOMAIN', $_SERVER['HTTP_HOST']);
define('URL_SUB_FOLDER', str_replace(URL_PUBLIC_FOLDER, '', dirname($_SERVER['SCRIPT_NAME'])));
define('URL', URL_PROTOCOL . URL_DOMAIN . URL_SUB_FOLDER);
define('SALT','@250b6cf8441b7EE68fd');
define("SITE_KEY", '5e994989ca28047151d0e56f45637627');
define('APP_EMAIL','staging@dlaonline.org');
define('APP_PWRD','!,VPn%krk;T+');
define('EmailServer','mail.dlaonline.org');
//  define('EmailPort',465);
define('EmailPort',26);

const PERMITTED_ROLES = [
    'SUPER_ADMIN',
    'ADMIN',
    'ACCOUNT',
    'FACILITATOR'
];

const SESSION_STATES = [
    1 => 'PAST',
    2 => 'PRESENT',
    3 => 'FUTURE'
];

define('DB_TYPE', 'mysql');
define('DB_HOST', 'localhost');
define('DB_NAME', 'dlabackend');
define('DB_USER', 'root');
define('DB_PASS', 'Password10@');
define('DB_CHARSET', 'utf8');
