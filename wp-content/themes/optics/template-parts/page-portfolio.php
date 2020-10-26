<?php
/**
 * Template Name: Default Portfolio Template
 *
 * Show JetPack Portfolio page on homepage
 *
 * @package Optics
 */

get_header(); 

?>

	<div id="primary" class="content-area jetpack-portfolio-home">
		<main id="main" class="site-main" role="main">

			<?php
				global $paged, $post;

				if ( get_query_var( 'paged' ) ) :
					$paged = get_query_var( 'paged' );
				elseif ( get_query_var( 'page' ) ) :
					$paged = get_query_var( 'page' );
				else :
					$paged = 1;
				endif;

				$posts_per_page = get_option( 'jetpack_portfolio_posts_per_page', '10' );
			 
			    $args = array(
			        'post_type' => 'jetpack-portfolio',
			        'ignore_sticky_posts' => true,
			        'paged' => $paged,
			        'posts_per_page' => $posts_per_page
			    );
			 		 
			    $wp_query = new WP_Query();
			    $wp_query->query( apply_filters( 'optics_portfolio_args_filter', $args ) );
			    $max_pages = $wp_query->max_num_pages;
			?>

			<div class="portfolio-content">

				<?php
				while ( $wp_query->have_posts() ) : $wp_query->the_post();

					get_template_part( 'template-parts/content', 'portfolio' );

				endwhile; // End of the loop.
				?>

			</div><!-- .portfolio-content -->			

		    <?php // Previous/next page navigation.
			the_posts_pagination( array(
				'prev_text'          => __( 'Previous page', 'optics' ),
				'next_text'          => __( 'Next page', 'optics' ),
				'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'optics' ) . ' </span>',
			) ); wp_reset_postdata(); ?>
		    
		    <?php edit_post_link( __( 'Edit', 'optics' ), '<footer class="entry-footer"><span class="edit-link">', '</span></footer>' ); ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>