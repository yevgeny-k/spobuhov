<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php do_action( 'spacious_before_post_content' ); ?>

	<header class="entry-header">
	<h1 class="entry-title">Законопроект № <?php echo get_post_meta(get_the_ID(), 'bill_number', true); ?></h1><!-- .entry-title -->
	</header>

	<div class="entry-content clearfix">
		<?php the_title(); ?>
	</div>

	<footer class="entry-meta-bar clearfix">	        			
		<div class="entry-meta clearfix">
			<span class="date updated"><?php the_time( get_option( 'date_format' ) ); ?></span>
      <?php edit_post_link( __( 'Edit', 'spacious' ), '<span class="edit-link">', '</span>' ); ?>
			<span class="read-more-link"><a class="read-more" href="<?php echo get_post_meta(get_the_ID(), 'bill_duma_url', true); ?>" target="_blank"><?php _e( 'Read more', 'spacious' ); ?></a></span>
		</div>
	</footer>

	<?php
	do_action( 'spacious_after_post_content' );
   ?>
</article>