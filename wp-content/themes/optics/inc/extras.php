<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Optics
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function optics_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	return $classes;
}
add_filter( 'body_class', 'optics_body_classes' );

/*
 * Custom comments display to move Reply link,
 * used in comments.php
 */
function optics_comments( $comment, $args, $depth ) {
?>
		<li id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?>>
			<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
				<footer class="comment-meta">
					<div class="comment-metadata">
						<span class="comment-author vcard">
							<?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'] ); ?>

							<?php printf( '<b class="fn">%s</b>', get_comment_author_link() ); ?>
						</span>
						<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID, $args ) ); ?>">
							<time datetime="<?php comment_time( 'c' ); ?>">
								<?php printf( '<span class="comment-date">%1$s</span><span class="comment-time screen-reader-text">%2$s</span>', get_comment_date(), get_comment_time() ); ?>
							</time>
						</a>
						<?php
						comment_reply_link( array_merge( $args, array(
							'add_below' => 'div-comment',
							'depth'     => $depth,
							'max_depth' => $args['max_depth'],
							'before'    => '<span class="reply">',
							'after'     => '</span>'
						) ) );
						?>
						<?php edit_comment_link( esc_html__( 'Edit', 'optics' ), '<span class="edit-link">', '</span>' ); ?>

					</div><!-- .comment-metadata -->

					<?php if ( '0' == $comment->comment_approved ) : ?>
					<p class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'optics' ); ?></p>
					<?php endif; ?>
				</footer><!-- .comment-meta -->

				<div class="comment-content">
					<?php comment_text(); ?>
				</div><!-- .comment-content -->

			</article><!-- .comment-body -->
<?php
}

/**
 * Determine if the companion plugin is installed.
 *
 * @since  1.0
 *
 * @return bool    Whether or not the companion plugin is installed.
 */
function optics_is_pro() {
    /**
     * Allow for toggling of the GPP Pro status.
     * @param bool    $is_pro    Whether or not GPP Pro is installed.
     */
    return apply_filters( 'optics_is_pro', defined( 'GPP_PRO' ) );
}

/**
 * Show Footer Credits
 */
function optics_footer_info() {
	$html = '';

	if( ! ( optics_is_pro() ) || null !== get_theme_mod( 'default_credits' ) || '' != get_theme_mod( 'custom_credits' ) || 'show' == get_theme_mod( 'default_credits' ) ) {
		$html .= '<div class="site-info">';	
	}

	if ( 'hide' == get_theme_mod( 'default_credits' ) ) {
		$html .= esc_html( get_theme_mod( 'custom_credits' ) );
	} else {
		$html .= sprintf( esc_html__( 'Proudly powered by %1$s. Theme: %2$s by %3$s.', 'optics' ), '<a href="https://wordpress.org/">WordPress</a>', '<a href="http://graphpaperpress.com/themes/optics">Optics</a>', '<a href="http://graphpaperpress.com/">Graph Paper Press</a>' );
	}

	if( ! ( optics_is_pro() ) || null !== get_theme_mod( 'default_credits' ) || '' != get_theme_mod( 'custom_credits' ) || 'show' == get_theme_mod( 'default_credits' ) ) {
		$html .= '</div>';	
	}

	echo $html;
}

/**
 * Show Footer Classes
 */
function optics_footer_classes() {
	$classes ='';
	if( ! ( optics_is_pro() ) || null !== get_theme_mod( 'default_credits' ) || '' != get_theme_mod( 'custom_credits' ) || 'show' == get_theme_mod( 'default_credits' ) ) {
		$classes .= ' has-site-info';
	}

	if ( has_nav_menu( 'social' ) ) { 
		$classes .= ' has-social-menu';
	}

	echo $classes;
}