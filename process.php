<?php

$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") ."://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

$mysqli = connect_db();


if (isset( $_GET['shortcode']) ){
    
    $shortcode = $_GET['shortcode'];
    $url = get_url( $shortcode );
    
    if ($url !== false) {
        header("location:".$url);
        die;
    }
    
}

if(isset($_POST['url'])){

    if ( verify_url( $_POST['url']) === false ){
        
        echo "Please enter correct url";
    }else{
        $shortcode = set_shortcode( $_POST['url'] );
        $short_url = $actual_link.$shortcode;
    }

     
}




?>
