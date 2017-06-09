<?php
define("BASEPATH", __DIR__);
define("BASEURL", "http".(isset($_SERVER['HTTPS']) ? "s" : "")."://".$_SERVER['HTTP_HOST']);
define("STORAGE", __DIR__ . '/storage');
define("data", STORAGE . '/data');
define("fb_data", data . '/fb_data');

ini_set("display_errors", true);

error_reporting(-1);


$config['default_route'] = "index";
$config['default_method'] = "index";



$config['error_handler']['show_error_query'] = true;


/**
 *
 * Assets Configuration.
 *
 */
$config['assets']['js']  = BASEURL . "/js";
$config['assets']['css'] = BASEURL . "/css";



/**
 *
 * Router Configuration.
 *
 */
$config['router']['manual_route']        = false;
$config['router']['automatic_route']    = true;
$config['router']['router_file']        = "index.php";



/**
 *
 * Database Configuration.
 *
 */
$config['database']['driver']    = "mysql";
$config['database']['host']        = "localhost";
$config['database']['user']        = "debian-sys-maint";
$config['database']['pass']        = "";
$config['database']['dbname']    = "icetea";
