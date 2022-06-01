<?php

// Lib used to create a web page
require_once '../lib/php/util.php';

// Use web class
use util\web;
// For debug purposes
use util\debug;

// Catch exceptions (You can add a custom exception handler)
try {

    // Create a web object
    $web = new Web("Select", "EN");

    // General css 
    $web->add('./docs/agen/css/index.css', "", true);

    // Add navbar css
    $web->add('./docs/agen/css/nav.css', "", true);

    // Add header navbar
    $web->add('./docs/agen/html/nav.php', "", true);

    // Add content
    $web->add('./docs/agen/html/index.php', "", true);

    // Make web
    $web->make();

}catch(Exception $e){
    // Debug message (Not recommended in production for security reasons)
    echo debug::debugTrace($e);
}

?>