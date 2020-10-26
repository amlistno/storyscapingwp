<?php
/**
 * Jetpack Compatibility File.
 *
 * @link https://jetpack.me/
 *
 * @package optics
 */

/**
 * Jetpack setup function.
 *
 * See: https://jetpack.me/support/infinite-scroll/
 * See: https://jetpack.me/support/responsive-videos/
 */
function optics_jetpack_setup() {
	// Add theme support for Infinite Scroll.
	add_theme_support( 'infinite-scroll', array(
		'container' => 'main',
		'render'    => 'optics_infinite_scroll_render',
		'footer'    => 'page',
		'wrapper'	=> true,
		'footer_widgets' => true,
	) );

	// Site logo
	$args = array(
		'header-text' => array(
			'site-title',
			'site-description',
		),
		'size' => 'optics-site-logo',
	);
	add_theme_support( 'site-logo', $args );

	// Add theme support for Responsive Videos.
	add_theme_support( 'jetpack-responsive-videos' );
} // end function optics_jetpack_setup
add_action( 'after_setup_theme', 'optics_jetpack_setup' );


/**
 * Remove Comments on Portfolio Posts.
 */
function optics_remove_portfolio_comments() {
	remove_post_type_support( 'jetpack-portfolio', 'comments' );
}
add_action( 'init', 'optics_remove_portfolio_comments' );

/**
 * Custom render function for Infinite Scroll.
 */
function optics_infinite_scroll_render() {
	while ( have_posts() ) {
		the_post();
		if ( is_post_type_archive( 'jetpack-portfolio' ) || is_tax( 'jetpack-portfolio-type' ) || is_tax( 'jetpack-portfolio-tag' ) ) {
			get_template_part( 'template-parts/content', 'portfolio' );
		} else {
			get_template_part( 'template-parts/content', get_post_format() );
		}
	}
} // end function optics_infinite_scroll_render
