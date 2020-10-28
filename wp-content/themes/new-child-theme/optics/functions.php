<?php
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
# This function is linking to parent theme (theme=style.css) and finally to child theme (style.css) 

function my_theme_enqueue_styles() {
    $parenthandle = 'parent-style'; // This is 'optics-style' for the Optics theme.
    $theme = wp_get_theme();
   
    wp_enqueue_style( $parenthandle, get_template_directory_uri() . '/style.css', 
        array(),  // if the parent theme code has a dependency, copy it to here
        $theme->parent()->get('Version')
    );
    #linking to my child theme (optics-child) 
    wp_enqueue_style( 'child-style', get_stylesheet_uri(),
        array( $parenthandle ),
        $theme->get('Version') // this only works if you have Version in the style header
    );
    add_theme_support( 'custom-logo', array(
    'height' => 480,
    'width'  => 720,
) );
}
