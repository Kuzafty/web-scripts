<?php

// Add util.php lib
require_once '../lib/php/util.php';

// Use web class for complete load
use util\web;
// Tools
use util\debug;

try{

    // New object web, without args
    $web = new web();

    // Add home content in test mode
    $web->add('./docs/html/home/home.html', '', true);

    // Compile web page
    $web->make();

}catch(Exception $e){
    // Get readable message
    $debug = debug::debugTrace($e);
    // Print error message
    echo $debug;
}

?>