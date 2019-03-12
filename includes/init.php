<?php

defined( 'FORBIDDEN' ) OR die( 'Forbidden' );

require_once( 'Adbox.php' );

$adbox = new Adbox;

// $adbox->exitIfMsisdnNotFound();

$adbox->siteTitle = 'Funbox';

$adbox->siteLogo = $adbox->getBanner();

$carousels = $adbox->getCarousels( 6 );