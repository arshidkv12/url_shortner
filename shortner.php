<?php

/**
 * Connect Database 
 * return db connection 
 */

function connect_db(){

    $mysqli = new mysqli(HOST,USERNAME,PASSWORD,DB);
    
    if( ! $mysqli ){

      die('Could not connect: ' . mysql_error());  
    }else{

      return $mysqli;
    }
}

/**
 * Veify url
 * @param  String $url 
 * @return boolean 
 */
function verify_url($url) {
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_setopt($ch,  CURLOPT_RETURNTRANSFER, true);
    curl_exec($ch);
    $response = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    return (!empty($response) && $response != 404);
}

/**
 * Convert url to shortcode 
 * @param  String $url  
 * @return String $shortcode
 */
function set_shortcode($url){

    global $mysqli;
    $url = $mysqli->real_escape_string($url);

    $res = $mysqli->query("SELECT url,shortcode FROM links WHERE url = '$url' LIMIT 1");
    if( $res ){

        while($row = $res->fetch_array() ) {
            
            return $row['shortcode'];
        }
    }

    $mysqli->query("INSERT INTO links VALUES (null,'$url',0)");

    $insert_id = $mysqli->insert_id;
    $id        = $insert_id.rand(1000,9999);
    $shortcode = base_convert($id,20,36);

    $mysqli->query("UPDATE links SET shortcode='$shortcode' WHERE id='$insert_id' LIMIT 1");

    return $shortcode;
}

/**
 * Get url from shortcode 
 * @param  String $shortcode  
 * @return String $url or false 
 */
function get_url( $shortcode ){

    global $mysqli;
    $shortcode = $mysqli->real_escape_string($shortcode);
    $result    = $mysqli->query("SELECT url,shortcode FROM links WHERE shortcode='$shortcode' LIMIT 1");

    while($row = $result->fetch_array()) {  
        $url = $row['url'];  
        return $url;
    }
    return false;  

}


