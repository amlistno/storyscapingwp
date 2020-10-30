<?php

/*
* Plugin Name: REPOT SoMe Plugin
* Plugin URI: http://fakeitTillyouMakeit.com
* Description: This is a plugin made to encourage user generated content for RePot. The plugin is based on HTML, CSS and PHP. 
*Version: 0.0.2
*Author: OM. MB. ED. AN.
*Author URI: Same page ^
*License: GPL2
*/

function newsletter_form()
{
    
    $content = '';
    $content .= '<div class="login-form">';
    $content .= '<div class="popupCloseButton">X</div>';
	$content .= '<img src="  '. plugins_url("repotSOME/img/logo.png") .'  " alt="RePot Logo">';



    $content .='<section>';
    $content .='<h3 id="velkommen">Want to spread the message of sustainability?</h3>';
	
	
    
    $content .= '<h3 id="velkommen">Join us on Instagram!</h3>';
	
	$content .= '<h5 id="tilmeld">Use our hashtag #startsomewhere and tag @repot.dk on your post showing what you are doing to preserve the environment!</h5>';
	
    $content .= '</section>';


    $content .= '<section class="form">';
    $content .='<form action="#" id="myForm">';

    $content .= '<div>';
    $content .='<input type="button" value="VISIT OUR INSTAGRAM">';
    $content .= '</div>';
    $content .= '</form>';
    $content .= '</section>';
    $content .= '</div>';
    
    
    return $content;
}



function register_styles_and_scripts_for_plugin()
{
    wp_enqueue_style ('fontAwsomeCDN', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css');
/*This is how we link to an stylesheet fontawesome CDN*/

    
    wp_enqueue_style ('CustomFontMontserrat','https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;800&display=swap');
	
	wp_enqueue_style ('CustomFontKarla','https://fonts.googleapis.com/css2?family=Karla&display=swap');
    
/*This is how we link to a google font style*/
    
    wp_enqueue_style ('CustomStylesheet', plugins_url('repotSOME/css/style.css'));

/*This is how we link to our stylesheet. It shows the breadcrumbs in my filestructur*/


    wp_deregister_script('jquery');
/*here I deregister my script jquery*/


    wp_enqueue_script('jquery', 'https://code.jquery.com/jquery-3.1.1.min.js',array(),null,true);


    
    wp_enqueue_script('jquery', 'https://code.jquery.com/jquery-3.1.1.min.js', array(), null, true);
/*This is how we link to our javascript*/ 
	
	wp_enqueue_script('CustomScript', plugins_url('repotSOME/js/script.js'), array('jquery'), null, true);
}




add_shortcode('show_repotSOME','newsletter_form');

add_action('wp_enqueue_scripts', 'register_styles_and_scripts_for_plugin');
/* without this the plugin wont work */ 

