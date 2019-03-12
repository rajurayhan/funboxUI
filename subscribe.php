<?php

define( 'FORBIDDEN', TRUE );

require_once( 'includes/init.php' );

$adbox->closeDB();

$message = $adbox->getIPAddress()." - - [".date("Y-M-d h:i:s")."] - - ".$adbox->getMsisdn()." - -  Redirecting to: ".$adbox->getSecondTireURL()."\n";

error_log($message,3,'/var/www/logs/blink_portal_subscribe_log.log');

//echo $message;

$adbox->redirectToSecondTire();
//echo $adbox->getSecondTireURL();