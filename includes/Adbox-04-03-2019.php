<?php

defined( 'FORBIDDEN' ) OR die( 'Forbidden' );

require_once( '/var/www/html/includes/common.class.fb.php' );
// require_once( '/var/www/html/wurfl/TeraWurfl.php' );
require_once( '/var/www/html/gpdpdp/GPDPDP.php' );

function debug( $arg, $exit = FALSE )
{
    $arg = ( $arg === NULL ) ? 'NULL' : $arg;
    $arg = ( $arg === TRUE ) ? 'TRUE' : $arg;
    $arg = ( $arg === FALSE ) ? 'FALSE' : $arg;
    echo '<pre>' . print_r( $arg, true ) . '</pre>';
    if ( $exit ) exit;
}

class Adbox
{

    protected $baseURL;

    protected $callbackURL;

    protected $config;

    protected $db;

    protected $deviceInfo;

    protected $downloadLimit = 0;

    protected $gpdpdp;

    protected $ipAddress;

    protected $msisdn;

    protected $operator;

    protected $requestData;

    protected $secondTireURL;

    protected $serviceInfo;

    public $siteLogo;

    public $siteTitle;

    protected $subscriptionInfo;

    public function __construct()
    {
        session_start();
        global $db;
        global $config;
        $this->gpdpdp = new GPDPDP;
        $this->gpdpdp->set_service_key( '6b8fe72a8a1a4ec7880cc938401323ee' );
        $this->gpdpdp->set_charge_code( 'SUB104600170807095639' );
        $this->gpdpdp->set_product_id( '785' );
        $this->gpdpdp->set_short_code( '16265' );
        $this->setDB( $db );
        $this->setConfig( NULL, $config );
        $this->setServiceName( 'funbox' );
        $this->setKeyword( 'fb' );
        $this->setShortcode( '16265' );
        $this->setDownloadLimit( 5 );
        $this->init();
    }

    public function init()
    {
        $this->prepareBaseURL();
        $this->prepareRequestData();
        // $this->prepareDeviceInfo();
        $this->prepareIPAddress();
        $this->prepareMsisdn();
        $this->prepareOperator();
        $this->prepareCallbackURL();
        $this->prepareSecondTireURL();
        $this->prepareSubscriptionInfo();
        $this->exitIfOperator();
        // $this->exitIfMsisdnNotFound();
        $this->exitIfIsInDoNotDisturb();
    }

    public function exitIfOperator()
    {
        $this->isOperator( 'gp' ) ? exit : NULL;
    }

    public function setArray( &$array, $key = NULL, $value = NULL )
    {
        if ( is_null( $key ) ) { $array = $value; return; }
        $keys = explode( '.', $key );
        while ( count( $keys ) > 1 )
        {
            $key = array_shift( $keys );
            if ( ! isset( $array[$key] ) || ! is_array( $array[$key] ) ) $array[$key] = array();
            $array = &$array[$key];
        }
        $array[array_shift($keys)] = $value;
        return;
    }

    public function hasArray( $array, $key = NULL )
    {
        if ( is_null( $key ) ) return FALSE;
        if ( ! $array ) return FALSE;
        foreach ( explode( '.', $key ) as $k )
        {
            if ( is_array( $array ) && array_key_exists( $k, $array ) ) $array = $array[$k]; else return FALSE;
        }
        return TRUE;
    }

    public function getArray( $array, $key = NULL )
    {
        if ( is_null( $key ) ) return $array;
        foreach ( explode( '.', $key ) as $k )
        {
            if ( is_array( $array ) && array_key_exists( $k, $array ) ) $array = $array[$k]; else return NULL;
        }
        return $array;
    }

    public function forgetArray( &$array, $key = NULL )
    {
        if ( is_null( $key ) ) { $array = array(); return; }
        $keys = explode( '.', $key );
        while ( count( $keys ) > 1 )
        {
            $key = array_shift( $keys );
            if ( isset( $array[$key] ) && is_array( $array[$key] ) ) $array = &$array[$key]; else continue;
        }
        unset( $array[array_shift( $keys )] );
        return;
    }

    /*public function prepareDeviceInfo()
    {
        $this->setArray( $productInfo, NULL, array() );
        if ( class_exists( 'TeraWurfl' ) )
        {
            $teraWurfl = new TeraWurfl;
            $teraWurfl->getDeviceCapabilitiesFromRequest();
            $productInfo = $this->getArray( $teraWurfl->capabilities, 'product_info' );
        }
        $this->setArray( $this->deviceInfo, 'brand', ( $this->hasArray( $productInfo, 'brand_name' ) && $this->getArray( $productInfo, 'brand_name' ) !== '' ) ? $this->getArray( $productInfo, 'brand_name' ) : 'Unknown' );
        $this->setArray( $this->deviceInfo, 'browser', ( $this->hasArray( $productInfo, 'mobile_browser' ) && $this->hasArray( $productInfo, 'mobile_browser_version' ) && $this->getArray( $productInfo, 'mobile_browser' ) !== '' && $this->getArray( $productInfo, 'mobile_browser_version' ) !== '' ) ? $this->getArray( $productInfo, 'mobile_browser' ) . ' ' . $this->getArray( $productInfo, 'mobile_browser_version' ) : 'Unknown' );
        $this->setArray( $this->deviceInfo, 'model', ( $this->hasArray( $productInfo, 'model_name' ) && $this->getArray( $productInfo, 'model_name' ) !== '' ) ? $this->getArray( $productInfo, 'model_name' ) : 'Unknown' );
        $this->setArray( $this->deviceInfo, 'os', ( $this->hasArray( $productInfo, 'device_os' ) && $this->hasArray( $productInfo, 'device_os_version' ) && $this->getArray( $productInfo, 'device_os' ) !== '' && $this->getArray( $productInfo, 'device_os_version' ) !== '' ) ? $this->getArray( $productInfo, 'device_os' ) . ' ' . $this->getArray( $productInfo, 'device_os_version' ) : 'Unknown' );
        $this->setArray( $this->deviceInfo, 'wireless', $this->hasArray( $productInfo, 'is_wireless_device' ) ? ( $this->getArray( $productInfo, 'is_wireless_device' ) === TRUE ? 'Yes' : 'No' ) : 'Unknown' );
    }*/

    /*
     * Supported keys: brand, browser, model, os, wireless
     */
    public function getDeviceInfo( $key = NULL )
    {
        return $this->getArray( $this->deviceInfo, $key );
    }

    public function setDB( $db )
    {
        $this->db = $db;
    }

    public function getDB()
    {
        return $this->db;
    }

    public function closeDB()
    {
        global $db;
        mysql_close( $this->db->dbh );
        $this->db->dbh = null;
        $this->db = null;
        $db = null;
        $this->gpdpdp->db->close();
        $this->gpdpdp->db = null;
    }

    public function setConfig( $key = NULL, $value )
    {
        $this->setArray( $this->config, $key, $value );
    }

    public function getConfig( $key = NULL )
    {
        return $this->getArray( $this->config, $key );
    }

    public function setServiceInfo( $key = NULL, $value )
    {
        $this->setArray( $this->serviceInfo, $key, $value );
    }

    public function getServiceInfo( $key = NULL )
    {
        return $this->getArray( $this->serviceInfo, $key );
    }

    public function setServiceName( $name )
    {
        $this->setServiceInfo( 'name', $name );
    }

    public function getServiceName()
    {
        return $this->getServiceInfo( 'name' );
    }

    public function setShortcode( $shortcode )
    {
        $this->setServiceInfo( 'shortcode', $shortcode );
    }

    public function getShortcode()
    {
        return $this->getServiceInfo( 'shortcode' );
    }

    public function setKeyword( $keyword )
    {
        $this->setServiceInfo( 'keyword', $keyword );
    }

    public function getKeyword()
    {
        return $this->getServiceInfo( 'keyword' );
    }

    public function hasServerData( $key )
    {
        return $this->hasArray( array_change_key_case( $_SERVER ), $key );
    }

    public function getServerData( $key = NULL )
    {
        return $this->getArray( array_change_key_case( $_SERVER ), $key );
    }

    public function prepareIPAddress()
    {
        $this->ipAddress = '';
        if ( $this->hasServerData( 'http_client_ip' ) )
        {
            $this->ipAddress = $this->getServerData( 'http_client_ip' );
        }
        elseif ( $this->hasServerData( 'http_x_forwarded_for' ) )
        {
            $this->ipAddress = $this->getServerData( 'http_x_forwarded_for' );
        }
        elseif ( $this->hasServerData( 'remote_addr' ) )
        {
            $this->ipAddress = $this->getServerData( 'remote_addr' );
        }
    }

    public function getIPAddress()
    {
        return $this->ipAddress;
    }

    public function hasRequestHeader( $key )
    {
        return $this->hasArray( array_change_key_case( apache_request_headers() ), $key );
    }

    public function getRequestHeader( $key = NULL )
    {
        return $this->getArray( array_change_key_case( apache_request_headers() ), $key );
    }

    public function hasCookieData( $key )
    {
        return $this->hasArray( $_COOKIE, $key );
    }

    public function getCookieData( $key = NULL )
    {
        return $this->getArray( $_COOKIE, $key );
    }

    public function prepareMsisdn()
    {
        if ( $this->getMsisdn() !== FALSE )
        {
            return $this->getMsisdn();
        }
        if ( $this->ipInRangeGp() ) // gp
        {
            if ( $this->hasSessionData( 'msisdn' ) )
            {
                $this->setMsisdn( $this->getSessionData( 'msisdn' ) );
            }
            elseif ( is_numeric( $msisdn = $this->gpdpdp->get_virtual_msisdn() ) )
            {
                $this->setSessionData( 'msisdn', $msisdn );
                $this->setMsisdn( $msisdn );
            }
            else
            {
                $this->setMsisdn( '' );
            }
        }
        elseif ( $this->hasServerData( 'http_msisdn' ) )
        {
            $this->setMsisdn( $this->getServerData( 'http_msisdn' ) ); // gp & motorola & siemens
        }
        elseif ( $this->hasServerData( 'http_x_msisdn' ) )
        {
            $this->setMsisdn( $this->getServerData( 'http_x_msisdn' ) ); // airtel & motorola & siemens
        }
        elseif ( $this->hasServerData( 'http_x_up_calling_line_id' ) )
        {
            $this->setMsisdn( $this->getServerData( 'http_x_up_calling_line_id' ) ); // all mobile phones
        }
        elseif ( $this->hasServerData( 'http_x_hts_clid' ) )
        {
            $this->setMsisdn( $this->getServerData( 'http_x_hts_clid' ) ); // nokia & sonyericsson
        }
        elseif ( $this->hasServerData( 'x_msisdn' ) )
        {
            $this->setMsisdn( $this->getServerData( 'x_msisdn' ) ); // motorola & siemens
        }
        elseif ( $this->hasServerData( 'http_x_wap_network_client_msisdn' ) )
        {
            $this->setMsisdn( $this->getServerData( 'http_x_wap_network_client_msisdn' ) ); // motorola & siemens
        }
        elseif ( $this->hasRequestHeader( 'msisdn' ) )
        {
            $this->setMsisdn( $this->getRequestHeader( 'msisdn' ) ); // gp
        }
        elseif ( $this->hasRequestHeader( 'x-msisdn' ) )
        {
            $this->setMsisdn( $this->getRequestHeader( 'x-msisdn' ) ); // gp
        }
        elseif ( $this->hasCookieData( 'user-identity-forward-msisdn' ) )
        {
            $this->setMsisdn( $this->getCookieData( 'user-identity-forward-msisdn' ) );
        }
        else
        {
            $this->setMsisdn( '' );
        }
    }

    public function setMsisdn( $msisdn )
    {
        return $this->msisdn = $msisdn;
    }

    public function getMsisdn( $start = 0, $length = NULL )
    {
        if ( is_null( $length ) )
            return substr( $this->msisdn, $start );
        else
            return substr( $this->msisdn, $start, $length );
    }

    public function ipInRange( $ip, $range )
    {
        if ( ! $this->hasString( $range, '/' ) )
            $range .= '/32';
        list( $range, $netmask ) = explode( '/', $range, 2 );
        $range_decimal = ip2long( $range );
        $ip_decimal = ip2long( $ip );
        $wildcard_decimal = pow( 2, ( 32 - $netmask ) ) - 1;
        $netmask_decimal = ~ $wildcard_decimal;
        return ( ( $ip_decimal & $netmask_decimal ) == ( $range_decimal & $netmask_decimal ) );
    }

    public function ipInRangeGp()
    {
        return $this->ipInRange( $this->getIPAddress(), '37.111.192.0/18' ) || $this->ipInRange( $this->getIPAddress(), '119.30.32.0/20' ) || $this->ipInRange( $this->getIPAddress(), '123.108.240.0/21' ) || $this->ipInRange( $this->getIPAddress(), '202.56.4.0/22' );
    }

    public function prepareOperator()
    {
        switch ( $this->getMsisdn( 0, 5 ) )
        {
            case '88016': { $this->setOperator( 'robi' ); break; }
            case '88018': { $this->setOperator( 'robi' ); break; }
            case '88019': { $this->setOperator( 'blink' ); break; }
            default:
            {
                if ( $this->ipInRangeGp() )
                    $this->setOperator( 'gp' );
                else
                    $this->setOperator( '' );
                break;
            }
        }
    }

    public function setOperator( $operator )
    {
        $this->operator = $operator;
    }

    public function getOperator()
    {
        return $this->operator;
    }

    public function isOperator( $operator )
    {
        return $this->getOperator() === $operator;
    }

    public function exitIfMsisdnNotFound()
    {
        $this->getMsisdn() === FALSE ? exit : NULL;
    }

    public function exitIfIsInDoNotDisturb()
    {
        $this->isDoNotDisturb() ? exit : NULL;
    }

    public function prepareRequestData( $key = null )
    {
        $qs = $this->getServerData( 'query_string' );
        $qs = str_replace( '?', '&', $qs );
        parse_str( $qs, $qs );
        $qs = array_merge( $_POST, $qs );
        $this->requestData = $qs;
    }

    public function hasRequestData( $key )
    {
        return $this->hasArray( $this->requestData, $key );
    }

    public function getRequestData( $key = null )
    {
        return $this->getArray( $this->requestData, $key );
    }

    public function setSessionData( $key, $value )
    {
        $this->setArray( $_SESSION, $key, $value );
    }

    public function hasSessionData( $key )
    {
        return $this->hasArray( $_SESSION, $key );
    }

    public function getSessionData( $key = NULL )
    {
        return $this->getArray( $_SESSION, $key );
    }

    public function forgetSessionData( $key )
    {
        return $this->forgetArray( $_SESSION, $key );
    }

    public function redirect( $to, $after = 0 )
    {
        if ( $after < 0 ) $after = 0;
        if ( $after > 0 ) header( "refresh: 3; url={$to}" );
        else { header( "Location: {$to}" ); exit; }
    }

    public function setResponseHeader( $key, $value )
    {
        header( "{$key}: {$value}" );
    }

    public function setResponseHeaders( array $headers )
    {
        foreach ( $headers as $key => $value )
            $this->setResponseHeader( $key, $value );
    }

    /*
     *
     * valid keys for options array
     * content_id - integer
     * category_id - integer
     * sub_category_id - integer or string
     * preview_url_format - string
     * subscribe_url_format - string
     * content_url_format - string
     * thumb_url_format - string
     * query_data - array
     * limit - integer
     *
     * example:
     * $contents = get_contents( array(
     *  'content_id'           => NULL,
     *  'category_id'          => NULL,
     *  'sub_category_id'      => NULL,
     *  'preview_url_format'   => 'preview.php?%s',
     *  'subscribe_url_format' => 'subscribe.php?%s',
     *  'download_url_format'  => 'download.php?%s',
     *  'content_url_format'   => 'http://funboxbd.com/ctn/%s/%s',
     *  'thumb_url_format'     => 'http://funboxbd.com/preview/%s/%s',
     *  'query_data'           => $query_data,
     *  'limit'                => 6
     * ) );
     *
     */
    public function getContents( $options = array() )
    {
        $defaults = array(
            'content_id'           => NULL,
            'category_id'          => NULL,
            'sub_category_id'      => NULL,
            'preview_url_format'   => '%spreview.php?%s',
            'subscribe_url_format' => '%ssubscribe.php?%s',
            'download_url_format'  => '%sdownload.php?%s',
            'content_url_format'   => 'http://funboxbd.com/ctn/%s/%s',
            'thumb_url_format'     => 'http://funboxbd.com/preview/%s/%s',
            'query_data'           => array(),
            'limit'                => 6,
        );
        $options = array_merge( $defaults, $options );
        if (
            empty( $options ) ||
            empty( $options['preview_url_format'] ) ||
            empty( $options['subscribe_url_format'] ) ||
            empty( $options['download_url_format'] ) ||
            empty( $options['content_url_format'] ) ||
            empty( $options['thumb_url_format'] ) ||
            (
                empty( $options['limit'] ) ||
                $options['limit'] <= 0
            )
        )
        {
            return null;
        }
        $this->getDB()->select( 'gpwap' );
        $sql = "SELECT c.content_id AS id, c.title, CASE WHEN ca.cat_id = 3 THEN 'mp3icon.gif' WHEN ca.cat_id = 5 THEN c.video_preview ELSE c.pre_view END AS thumb_file_name, c.file_name, c.file_size, ca.thumb_folder_name, ca.folder_name, c.sub_cat_id, s.sub_cat_name, s.cat_id AS category_id, ca.cat_name FROM ( SELECT * FROM wap_content UNION ALL SELECT gd.content_id, g.sub_cat_id, g.game_name AS title, g.owner, g.price, gd.apk_file AS file_name, '' AS video_preview, g.preview AS pre_view, '' AS file_size, g.short_des AS file_description, gd.gp_comments, gd.status AS content_status, gd.insert_dt AS insert_date, gd.update_dt AS update_date, gd.approve_dt AS approve_date, g.special_content, '' AS push_status, '' AS greeting_map, 0 AS mapping_status FROM game AS g, game_details AS gd WHERE g.game_id = gd.game_id AND gd.handset = 'android' GROUP BY gd.apk_file ) AS c, wap_sub_cat AS s, wap_category AS ca WHERE c.sub_cat_id = s.sub_cat_id AND s.cat_id = ca.cat_id";
        //$sql = "SELECT c.content_id AS id, c.title, CASE WHEN ca.cat_id = 3 THEN 'mp3icon.gif' WHEN ca.cat_id = 5 THEN c.video_preview ELSE c.pre_view END AS thumb_file_name, c.file_name, c.file_size, ca.thumb_folder_name, ca.folder_name, c.sub_cat_id, s.sub_cat_name, s.cat_id AS category_id, ca.cat_name FROM wap_content AS c, wap_sub_cat AS s, wap_category AS ca WHERE c.sub_cat_id = s.sub_cat_id AND s.cat_id = ca.cat_id";
        if ( ! is_null( $options['category_id'] ) )
        {
            $sql .= " AND ca.cat_id IN ( {$options['category_id']} )";
        }
        if ( ! is_null( $options['sub_category_id'] ) )
        {
            $sql .= " AND s.sub_cat_id IN ( {$options['sub_category_id']} )";
        }
        if ( is_null( $options['content_id'] ) )
        {
            $sql .= " ORDER BY RAND() LIMIT {$options['limit']}";
        }
        else
        {
            $sql .= " AND c.content_id = '{$options['content_id']}' LIMIT {$options['limit']}";
        }
        echo "<!-- $sql -->";
        $contents = $this->getDB()->get_results( $sql );
        foreach( $contents as $content )
        {
            $query_data = array( 'content' => $content->id, 'category' => $content->category_id );
            $query_data = array_merge( $query_data, $options['query_data']  );
            $query_string = http_build_query( $query_data );
            $content->preview_url = sprintf( $options['preview_url_format'], $this->getBaseURL(), $query_string );
            $content->download_url = sprintf( $options['download_url_format'], $this->getBaseURL(), $query_string );
            $content->subscribe_url = sprintf( $options['subscribe_url_format'], $this->getBaseURL(), $query_string );
            $content->content_url = sprintf( $options['content_url_format'], $content->folder_name, $content->file_name );
            $content->thumb_url = sprintf( $options['thumb_url_format'], $content->thumb_folder_name, $content->thumb_file_name );
            $services = array(
                1 => array( 'service_id' => '83341002', 'service_charge' => '5.00' ), // wallpaper
                2 => array( 'service_id' => '83341003', 'service_charge' => '5.00' ), // animation
                3 => array( 'service_id' => '83341005', 'service_charge' => '10.00' ), // mp3
                5 => array( 'service_id' => '83341004', 'service_charge' => '15.00' ), // video
                6 => array( 'service_id' => '83341006', 'service_charge' => '20.00' ), // game
            );
            $content->service_id = $services[$content->category_id]['service_id'];
            $content->service_charge = $services[$content->category_id]['service_charge'];
            $content->ondemand_url = $url = $this->getBlinkChargeUrl( $content->service_id, $content->id, $content->download_url, 'content' );
        }
        return $contents;
    }

    public function getCarousels( $limit = 6 )
    {
        $carousels = array(
            'funbox-carousel-15.jpg',
            'funbox-carousel-16.jpg',
            'funbox-carousel-17.jpg',
            // 'funbox-carousel-01.jpg',
            // 'funbox-carousel-02.jpg',
            // 'funbox-carousel-03.jpg',
            'funbox-carousel-04.jpg',
            // 'funbox-carousel-05.jpg',
            'funbox-carousel-06.jpg',
            // 'funbox-carousel-07.jpg',
            // 'funbox-carousel-08.jpg',
            'funbox-carousel-09.jpg'
            // 'funbox-carousel-10.jpg',
            // 'funbox-carousel-11.jpg',
            // 'funbox-carousel-12.jpg',
            // 'funbox-carousel-13.jpg',
            // 'funbox-carousel-14.jpg',
            
        );
        return array_values( array_intersect_key( $carousels, array_flip( array_rand( $carousels, $limit ) ) ) );
    }

    /*
     *
     * valid keys for options array
     * content_id - integer
     * subscribe_url_format - string
     * content_url_format - string
     * thumb_url_format - string
     * query_data - array
     *
     * example:
     * $content = get_content( array(
     *  'content_id'           => '748',
     *  'category_id'          => NULL,
     *  'sub_category_id'      => NULL,
     *  'preview_url_format'   => 'preview.php?%s',
     *  'subscribe_url_format' => 'subscribe.php?%s',
     *  'download_url_format'  => 'download.php?%s',
     *  'content_url_format'   => 'http://funboxbd.com/ctn/%s/%s',
     *  'thumb_url_format'     => 'http://funboxbd.com/preview/%s/%s',
     *  'query_data'           => $query_data
     * ) );
     *
     */
    public function getContent( $options = array() )
    {
        $options['limit'] = 1;
        $contents = $this->getContents( $options );
        $content = $contents ? $contents[0] : NULL;
        return $content;
    }

    /*
     * log - string or array
     * destination - string
     */
    /*public function setLog( $log, $destination )
    {
        if (
            empty( $log ) ||
            empty( $destination )
        )
        {
            return false;
        }
        if ( is_array( $log ) )
        {
            $log = implode( '||', $log );
        }
        $log .= PHP_EOL;
        $fp = fopen( $destination, 'a+' );
        if ( $fp )
        {
            fwrite( $fp, $log );
            fclose( $fp );
            return true;
        }
        return false;
    }*/

    public function setSubscriptionInfo( $info = array() )
    {
        $this->subscriptionInfo = $info;
    }

    public function prepareSubscriptionInfo()
    {
        // $result = array();
        $result = null;
        if ( $this->isOperator( 'gp' ) )
        {
            $this->getDB()->select( 'gpwap' );
            $format = "SELECT channel, status, subs_date AS subscribed_at, unsubs_date AS unsubscribed_at, entry AS created_at, last_update AS updated_at FROM subscribers WHERE msisdn = '%s' AND service = '%s' LIMIT 1";
            $sql = sprintf( $format, $this->getMsisdn(), $this->getKeyword() );
            // $result = array_merge( $result, $this->getDB()->get_row( $sql, ARRAY_A ) );
            $result = $this->getDB()->get_row( $sql, ARRAY_A );
        }
        elseif ( $this->isOperator( 'robi' ) )
        {
            $this->getDB()->select( 'sms' );
            $format = "SELECT channel, status, subs_date AS subscribed_at, unsubs_date AS unsubscribed_at, entry AS created_at, last_update AS updated_at FROM robi_subscribers WHERE msisdn = '%s' AND service = '%s' LIMIT 1";
            $sql = sprintf( $format, $this->getMsisdn(), $this->getKeyword() );
            // $result = array_merge( $result, $this->getDB()->get_row( $sql, ARRAY_A ) );
            $result = $this->getDB()->get_row( $sql, ARRAY_A );
        }
        elseif ( $this->isOperator( 'blink' ) )
        {
            $this->getDB()->select( 'gpwap' );
            $format = "SELECT channel, status, subs_date AS subscribed_at, unsubs_date AS unsubscribed_at, entry AS created_at, last_update AS updated_at FROM subscribers WHERE msisdn = '%s' AND service = '%s' LIMIT 1";
            $sql = sprintf( $format, $this->getMsisdn(), $this->getKeyword() );
            // $result = array_merge( $result, $this->getDB()->get_row( $sql, ARRAY_A ) );
            $result = $this->getDB()->get_row( $sql, ARRAY_A );
        }
        if ( is_null( $result ) )
        {
            $result = array();
        }
        $this->setSubscriptionInfo( $result );
    }

    public function getDoNotDisturb()
    {
        $this->getDB()->select( 'gpwap' );
        $sql = sprintf( "SELECT 1 FROM dnd WHERE msisdn = '%s' LIMIT 1;", $this->getMsisdn() );
        $this->getDB()->get_row( $sql );
        return $this->getDB()->num_rows ? TRUE : FALSE;
    }

    public function isDoNotDisturb()
    {
        return $this->getDoNotDisturb() ? TRUE : FALSE;
    }

    public function getChargedBlink()
    {
        $this->getDB()->select( 'gpwap' );
        $sql = sprintf( "SELECT 1 FROM charge_log WHERE msisdn = '%s' AND d_date = CURDATE() LIMIT 1;", $this->getMsisdn() );
        $this->getDB()->get_row( $sql );
        return $this->getDB()->num_rows ? TRUE : FALSE;
    }

    public function isChargedBlink()
    {
        return $this->getChargedBlink() ? TRUE : FALSE;
    }

    public function getPendingBlink()
    {
        $this->getDB()->select( 'gpwap' );
        $sql = sprintf( "SELECT 1 FROM pending_subscribers WHERE msisdn = '%s' AND d_date = CURDATE() LIMIT 1;", $this->getMsisdn() );
        $this->getDB()->get_row( $sql );
        return $this->getDB()->num_rows ? TRUE : FALSE;
    }

    public function isPendingBlink()
    {
        return $this->getPendingBlink() ? TRUE : FALSE;
    }

    public function isNotPendingBlink()
    {
        return $this->isPendingBlink() ? FALSE : TRUE;
    }

    public function chargeBlink()
    {
        $result         = banglalink_charging( 'funbox', '83341001', $this->getMsisdn() );
        $result         = explode( '::', $result );
        $tID            = trim( $result[0] );
        $statusCode     = trim( $result[1] );
        $description    = trim( $result[2] );
        if ( $statusCode == '100' )
        {
            $this->getDB()->select( 'gpwap' );
            $sessionID = date( 'YmdHis' ) . $this->getMsisdn();
            $sql = sprintf( "INSERT INTO charge_log ( session_id, referenceCode, msisdn, opr, d_date, t_time ) VALUES ( '%s', '%s', '%s', '%s', CURDATE(), CURTIME() );", $sessionID, $tID, $this->getMsisdn(), $this->getOperator() );
            $this->getDB()->query( $sql );
            return TRUE;
        }
        elseif ( $statusCode == '201' )
        {
            if ( $this->isNotPendingBlink() )
            {
                $this->getDB()->select( 'gpwap' );
                $sql = sprintf( "INSERT INTO pending_subscribers ( msisdn, opr, service, d_date, d_time, status ) VALUES ( '%s', '%s', '%s', CURDATE(), CURTIME(), '%s' );", $this->getMsisdn(), $this->getOperator(), $this->getKeyword(), $statusCode );
                $this->getDB()->query( $sql );
            }
            return TRUE;
        }
        return FALSE;
    }

    public function getRequestMethod()
    {
        return strtolower( $this->getServerData( 'request_method' ) );
    }

    public function isRequestMethod( $method )
    {
        return $this->getRequestMethod() === $method;
    }

    /*
     * Supported keys: channel, status, subscribed_at, unsubscribed_at, created_at, updated_at
     */
    public function getSubscriptionInfo( $key = NULL )
    {
        return $this->getArray( $this->subscriptionInfo, $key );
    }

    public function isSubscribedBefore()
    {
        return $this->getSubscriptionInfo() ? TRUE : FALSE;
    }

    public function isNotSubscribedBefore()
    {
        return $this->isSubscribedBefore() ? FALSE : TRUE;
    }

    public function isSubscribed()
    {
        return $this->getSubscriptionInfo( 'status' ) ? TRUE : FALSE;
    }

    public function isNotSubscribed()
    {
        return $this->isSubscribed() ? FALSE : TRUE;
    }

    public function setBaseURL( $url )
    {
        $this->baseURL = $url;
    }

    public function prepareBaseURL()
    {
        $https = $this->getServerData( 'https' );
        $protocol = ( empty( $https ) || $https == 'off' ) ? 'http' : 'https';
        $host = trim( $this->getServerData( 'server_name' ), '/' );
        $uri = trim( dirname( $this->getServerData( 'script_name' ) ), '/' );
        $url = $protocol . '://' . $host . '/' . $uri . '/';
        $this->setBaseURL( $url );
    }

    public function getBaseURL()
    {
        return $this->baseURL;
    }

    public function prepareCallbackURL( $query_data = array(), $basename = '' )
    {
        $query_data = array_merge( $query_data, $this->getRequestData() );
        $basename = $basename == '' ? 'preview.php' : $basename;
        $qs = http_build_query( $query_data );
        $url = $this->getBaseURL() . $basename . ( empty( $qs ) ? '' : '?' . $qs );
        $this->setCallbackURL( $url );
    }

    public function setCallbackURL( $url )
    {
        $this->callbackURL = $url;
    }

    public function getCallbackURL()
    {
        return $this->callbackURL;
    }

    public function prepareSecondTireURL()
    {
        if ( $this->isOperator( 'gp' ) )
        {
            $this->setSecondTireURL( $this->getGpSecondTireURL() );
        }
        elseif ( $this->isOperator( 'robi' ) )
        {
            $this->setSecondTireURL( $this->getRobiSecondTireURL() );
        }
        elseif ( $this->isOperator( 'blink' ) )
        {
            $this->setSecondTireURL( $this->getBlinkSecondTireURL() );
        }
        else
        {
            $this->setSecondTireURL( './' );
        }
    }

    public function setSecondTireURL( $url )
    {
        $this->secondTireURL = $url;
    }

    public function getSecondTireURL()
    {
        return $this->secondTireURL;
    }

    public function redirectToSecondTire()
    {
        $this->redirect( $this->getSecondTireURL() );
    }

    public function getGpSecondTireURL()
    {
        $content = $this->getContent( array(
            'content_id' => $this->getRequestData( 'content' ),
            'category_id' => $this->getRequestData( 'category' )
        ) );
        $cb_url = $this->getCallbackURL();
        $success_url = $cb_url;
        $failure_url = $cb_url;
        $cancel_url = $cb_url;
        $notify_url = $cb_url;
        $url = $this->gpdpdp->get_consent_gateway_url( $content->id, $content->cat_name, $content->title, $content->thumb_url, $success_url, $failure_url, $cancel_url, $notify_url, $content->content_url );
        return $url;
    }

    public function getRobiSecondTireURL()
    {
        $cb_url = urlencode( $this->getCallbackURL() );
        $sp_id = '200015';
        $nonce = date( 'Ymdhis' ) . $this->getMsisdn();
        $created = date( 'Y-m-d\TH:i:s\Z' );
        $password = 'Robi1234';
        $password_digest_str = $nonce . $created . $password;
        $password_digest = urlencode( base64_encode( hash( 'sha256', $password_digest_str, true ) ) );
        $language = 'en';
        $transaction_id = uniqid();
        // $product_id = '0300394129'; // old
        $product_id = '0300409504'; // new
        $url = sprintf( 'https://consent.robi.com.bd/store/wapconfirm?spid=%s&passwordDigest=%s&msisdn=%s&language=%s&transactionId=%s&callbackURL=%s&productID=%s&nonce=%s&created=%s', $sp_id, $password_digest, $this->getMsisdn(), $language, $transaction_id, $cb_url, $product_id, $nonce, $created );
        return $url;
    }

    public function getBlinkSecondTireURL()
    {
        $content = $this->getContent( array(
            'content_id' => $this->getRequestData( 'content' ),
            'category_id' => $this->getRequestData( 'category' )
        ) );
        $url = $this->getBlinkChargeUrl( '83341001', $content->id, $this->getCallbackURL(), 'subscription' );
        return $url;
    }

    public function getBlinkChargeUrl( $service_id, $content_id, $back, $request_type )
    {
        $app_id = 'adbox';
        $app_pass = 'funbox';
        //$subscription_group_id = 'adbox';
        $subscription_group_id = '83341001_16265';
        $subscriptionroot      = '83341001_16265_adbox';
        $ano = $this->getMsisdn();
        $bno = '16265';
        $api = urlencode( 'http://funboxbd.com/api/v1/blink-get-notification.php' );
        $back = urlencode( $back );
        $reference_id = 'portal';
        $success_url  = 'http://funboxbd.com/club';
        $fail_url  = 'http://funboxbd.com/club';
        //$url = sprintf( "http://103.239.252.108/blsdp_wap/consent.php?appid=%s&apppass=%s&subscriptiongroupid=%s&serviceid=%s&ano=%s&bno=%s&contentid=%s&api=%s&back=%s&referenceId=%s&request_type=%s", $app_id, $app_pass, $subscription_group_id, $service_id, $ano, $bno, $content_id, $api, $back, $reference_id, $request_type );

        // 'http://103.239.252.108/blsdp_wap/subscribe.php?
        // appid=test
        // apppass=test
        // MSISDN=msisdn
        // subscriptionroot=Subscriptionroot
        // subscriptiongroupid=subscriptiongroupid
        // shortcode=1111
        // success_url=success_url
        // cp_fail_url=fail_url
        // api=api'

        $url = sprintf( "http://103.239.252.108/blsdp_wap/subscribe.php?appid=%s&apppass=%s&MSISDN=%s&subscriptionroot=%s&subscriptiongroupid=%s&shortcode=%s&success_url=%s&cp_fail_url=%s&api=%s", $app_id, $app_pass, $ano, $subscriptionroot, $subscription_group_id, $bno, $success_url, $fail_url, $api );
        return $url;
    }

    public function unsubscribe()
    {
        $response = FALSE;
        if ( $this->isOperator( 'gp' ) )
        {
            $response = $this->unsubscribeGp();
        }
        elseif ( $this->isOperator( 'robi' ) )
        {
            $response = $this->unsubscribeRobi();
        }
        elseif ( $this->isOperator( 'blink' ) )
        {
            $response = $this->unsubscribeBlink();
        }
        return $response;
    }

    public function unsubscribeGp()
    {
        $response = $this->gpdpdp->unsubscribe( $this->getMsisdn() );
        return $response;
    }

    public function log( $message, $destination )
    {
        $message = $message . PHP_EOL;
        $destination = sprintf( '/var/www/logs/%s.log', $destination );
        return error_log( $message, 3, $destination );
    }

    public function wapVisitorLog()
    {
        // $message = sprintf( '%s||%s||%s||%s||%s||%s||%s', date( 'Y-m-d H:i:s' ), $this->getMsisdn(), $this->getKeyword(), $this->getOperator(), $this->getDeviceInfo( 'brand' ), $this->getDeviceInfo( 'model' ), $this->getIPAddress() );
        $message = sprintf( '%s||%s||%s||%s||%s||%s', date( 'Y-m-d H:i:s' ), $this->getMsisdn(), $this->getKeyword(), $this->getOperator(), $this->getIPAddress(), $_SERVER['HTTP_USER_AGENT'] );
        $destination = 'wap_visitor';
        return $this->log( $message, $destination );
    }

    public function unsubscribeRobiLog( $message )
    {
        $message = sprintf( '%s - %s', date( 'Y-m-d H:i:s' ), $message );
        $destination = 'sdp_log';
        return $this->log( $message, $destination );
    }

    public function unsubscribeRobi()
    {
        $url = 'http://120.50.12.54:8990/sdpAps/api/unsubscription.php';
        $data = array(
            'msisdn'    => $this->getMsisdn(),
            // 'productID' => '0300394129' // old
            'productID' => '0300409504' // new
        );
        $this->unsubscribeRobiLog( $url . '?' . http_build_query( $data ) );
        $response = $this->requestCURL( $url, $data );
        $this->unsubscribeRobiLog( $response );
        return $response === 'Successfull';
    }

    public function unsubscribeBlink()
    {
        // $this->getDB()->select( 'gpwap' );
        // $sql = sprintf( "UPDATE subscribers SET status = '0', unsubs_date = NOW(), channel = 'PORTAL', last_update = NOW() WHERE msisdn = '%s' AND service = '%s';", $this->getMsisdn(), $this->getKeyword() );
        // $this->getDB()->query( $sql );
        // $messageID = date( 'YmdHis' ) . $this->getMsisdn();
        // $subject = "ADBOX;IOD;PULL;00;FB;INFO";
        // $message = sprintf( 'You have successfully unsubscribed from %s service. To start again, SMS START space %s to %s.', strtoupper( $this->getServiceInfo( 'name' ) ), strtoupper( $this->getKeyword() ), $this->getShortcode() );
        // $ackAddress = $this->getConfig( 'blink.gw_ip' );
        // $chargeID = $this->getConfig( 'blink.price_00_sms' );
        // $ptxID = $this->getConfig( "blink.{$chargeID}" );
        // CreateMT( $messageID, $subject, $this->getMsisdn(), $message, $this->getShortcode(), $ackAddress, $chargeID, '', 'blink', $ptxID, '', 'push' );
        // return TRUE;

        $app_id                 = 'adbox';
        $app_pass               = 'funbox';
        $subscriptionroot       = '83341001_16265_adbox';
        $msisdn                 = $this->getMsisdn();

        $unsubAPI               = sprintf( "http://103.239.252.108/blsdp_wap/deregister.php?appid=%s&apppass=%s&msisdn=%s&subscriptionroot=%s", $app_id, $app_pass, $msisdn, $subscriptionroot);

        $response   = $this->requestCURL($unsubAPI);

        if($response == 0){
            $this->getDB()->select( 'gpwap' );
            $sql = sprintf( "UPDATE subscribers SET status = '0', unsubs_date = NOW(), channel = 'PORTAL', last_update = NOW() WHERE msisdn = '%s' AND service = '%s';", $this->getMsisdn(), $this->getKeyword() );
            $this->getDB()->query( $sql );
            $messageID = date( 'YmdHis' ) . $this->getMsisdn();
            $subject = "ADBOX;IOD;PULL;00;FB;INFO";
            $message = sprintf( 'You have successfully unsubscribed from %s service. To start again, SMS START space %s to %s.', strtoupper( $this->getServiceInfo( 'name' ) ), strtoupper( $this->getKeyword() ), $this->getShortcode() );
            $ackAddress = $this->getConfig( 'blink.gw_ip' );
            $chargeID = $this->getConfig( 'blink.price_00_sms' );
            $ptxID = $this->getConfig( "blink.{$chargeID}" );
            CreateMT( $messageID, $subject, $this->getMsisdn(), $message, $this->getShortcode(), $ackAddress, $chargeID, '', 'blink', $ptxID, '', 'push' );
            return TRUE;
        }

        else{
            exit('Unsubscription Failed');
        }
    }

    public function requestCURL( $url, $data = array(), $headers = array() )
    {
        $ch = curl_init( $url );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, TRUE );
        if ( $data )
        {
            curl_setopt( $ch, CURLOPT_POST, TRUE );
            curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );
        }
        if ( $headers )
        {
            curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
        }
        $response = curl_exec( $ch );
        curl_close( $ch );
        return $response;
    }

    public function insertDownloadLog( $cid, $cname, $ctype, $dmodel, $ccharge = '0.00', $src = 'funbox' )
    {
        $this->getDB()->select( 'gpwap' );
        $sql = sprintf( "INSERT INTO download_log ( msisdn, d_date, d_time, content_id, content_name, content_type, phone_model, unit_price, downloads, revenue, source ) VALUES ( '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '1', '0', '%s' );", $this->getMsisdn(), date( 'Y-m-d' ), date( 'H:i:s' ), $cid, $cname, $ctype, $dmodel, $ccharge, $src );
        $this->getDB()->query( $sql );
    }

    public function setDownloadLimit( $limit )
    {
        $this->downloadLimit = $limit;
    }

    public function getDownloadLimit()
    {
        return $this->downloadLimit;
    }

    public function isLessThanDownloadLimit()
    {
        $this->getDB()->select( 'gpwap' );
        $sql = sprintf( "SELECT COUNT( * ) AS downloads FROM download_log WHERE msisdn = '%s' AND d_date = CURDATE();", $this->getMsisdn() );
        $result = $this->getDB()->get_row( $sql );
        return $result->downloads < $this->getDownloadLimit() ? TRUE : FALSE;
    }

    /*
     * download( 'http://funboxbd.com/animations/e8bce6f.gif' );
     */
    public function download( $url, $direct = TRUE )
    {
        if ( $direct )
        {
            $this->redirect( $url );
        }
        else
        {
            $name = basename( $url );
            $this->setResponseHeaders(
                array(
                    'content-type' => 'application/octet-stream',
                    'content-transfer-encoding' => 'binary',
                    'content-disposition' => "attachment; filename=\"{$name}\""
                )
            );
            readfile( $url ); exit;
        }
    }

    public function getSupportNumber()
    {
        if ( $this->isOperator( 'gp' ) )
            return '01758553388';
        elseif ( $this->isOperator( 'robi' ) )
            return '01860744898';
        elseif ( $this->isOperator( 'blink' ) )
            return '01977733255';
        return '01977733255, 01636007777, 01860744898';
    }

    public function hasString( $haystack, $needle )
    {
        return strpos( $haystack, $needle ) === FALSE ? FALSE : TRUE;
    }

    public function redirectIfNoContentAndNoCategory()
    {
        $content = $this->getRequestData( 'content' );
        $category = $this->getRequestData( 'category' );
        if ( ( is_numeric( $content ) && $content ) && ( is_numeric( $category ) && $category ) ) return;
        $this->redirect( './' );
    }

    public function getBanner()
    {
        $name = 'funbox_banner';
        $dir = '/var/www/html/funcms/uploads/';
        $url = 'http://funboxbd.com/funcms/uploads/';
        $gif = $dir . $name . '.gif';
        $jpg = $dir . $name . '.jpg';
        $png = $dir . $name . '.png';
        $file = '';
        if ( file_exists( $gif ) )
        {
            $file = $url . $name . '.gif';
        }
        elseif ( file_exists( $jpg ) )
        {
            $file = $url . $name . '.jpg';
        }
        elseif ( file_exists( $png ) )
        {
            $file = $url . $name . '.png';
        }
        return $file;
    }

    // Airtel Same Day Subscription Issue 

}