<?php global $post; ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <figure>
        <?php if ( has_post_thumbnail() ) { ?>
            <div class="entry-image"><?php the_post_thumbnail( 'medium' ); ?></div>
        <?php } else { ?>
        	<div class="no-image"></div>
        <?php } ?>

        <figcaption class="portfolio-meta">
            <a class="portfolio-title-wrap" href="<?php the_permalink(); ?>"><div class="portfolio-title"><?php the_title(); ?></div></a>
        </figcaption>
    </figure>
</article>