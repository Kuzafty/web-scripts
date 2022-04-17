<?php

/**
 * 
 * Use to select your protocol when a page is loaded.
 * 
*/
class proto {

    /**
     * 
     * When object is built select the protocol. Default is https.
     * 
     * @param  string    $protocol       Protocol
     * 
     */
    function __construct($protocol = 'https') {

        if($protocol == 'https') {
            if(empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == 'off'){
                $location = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                header('HTTP/1.1 301 Moved Permanently');
                header('Location: '.$location);
            }
        }else{
            if(!(empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == 'off')){
                $location = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                header('Location: '.$location);
            }
        }

    }

}

?>