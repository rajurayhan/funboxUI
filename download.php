<?php

define( 'FORBIDDEN', TRUE );

require_once( 'includes/init.php' );

$adbox->redirectIfNoContentAndNoCategory();

$content = $adbox->getContent( array(
	'content_id' => $adbox->getRequestData( 'content' ),
	'category_id' => $adbox->getRequestData( 'category' )
) );

if ( $adbox->isLessThanDownloadLimit() )
{
    // $adbox->insertDownloadLog( $content->id, $content->title, $content->cat_name, $adbox->getDeviceInfo( 'model' ) );
	$adbox->insertDownloadLog( $content->id, $content->title, $content->cat_name, '' );
	$adbox->download( $content->content_url );
}
elseif( $adbox->isOperator( 'blink' ) )
{
    // $adbox->insertDownloadLog( $content->id, $content->title, $content->cat_name, $adbox->getDeviceInfo( 'model' ), $content->service_charge );
	$adbox->insertDownloadLog( $content->id, $content->title, $content->cat_name, '', $content->service_charge );
	$adbox->download( $content->content_url );
}
$adbox->closeDB();
$adbox->redirect( './' );