<?php

/* 
 * 
 * Front Controller
 * 
 * 
 */

/*
 * configuration
 */
require_once '../config.php';

/*
 * vendor autoload for
 * - Twig
 * - Twig extensions
 */
require_once '../vendor/autoload.php';

/*
 * autoload for our models
 */
spl_autoload_register(function ($class) {
    include '../model/' . $class . '.php';
});