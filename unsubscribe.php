<?php

define( 'FORBIDDEN', TRUE );

require_once( 'includes/init.php' );

$adbox->unsubscribe();

$app_id                 = 'adbox';
$app_pass               = 'funbox';
$subscriptionroot       = '83341001_16265_adbox';
$msisdn                 = $adbox->getMsisdn();

$unsubAPI               = sprintf( "http://103.239.252.108/blsdp_wap/deregister.php?appid=%s&apppass=%s&msisdn=%s&subscriptionroot=%s", $app_id, $app_pass, $msisdn, $subscriptionroot);

$message = $adbox->getIPAddress()." - - [".date("Y-M-d h:i:s")."] - - ".$msisdn." - -  Redirecting to: ".$unsubAPI."\n";

error_log($message,3,'/var/www/logs/blink_portal_unsubscribe_log.log');

$adbox->closeDB();

$adbox->redirect( './' );