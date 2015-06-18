<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php do_action( 'spacious_before_post_content' ); ?>

	<?php 
	if( !is_single() ) {
	?>
	<header class="entry-header">
	<h1 class="entry-title">
		<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute();?>"><?php the_title(); ?></a>
	</h1><!-- .entry-title -->
	</header>
	<?php
	}
	?>

	<?php
		if( has_post_thumbnail() ) {
			if( of_get_option( 'spacious_site_layout', 'box_1218px' ) == 'box_1218px' || of_get_option( 'spacious_site_layout', 'box_1218px' ) == 'wide_1218px' ) {
				$featured = 'featured-blog-large'; 
			}
			elseif( of_get_option( 'spacious_site_layout', 'box_1218px' ) == 'box_978px' || of_get_option( 'spacious_site_layout', 'box_1218px' ) == 'wide_978px' ) {
				$featured = 'featured';
			}
			$image = '';        			
     		$title_attribute = get_the_title( $post->ID );
     		$image .= '<figure class="post-featured-image">';
  			$image .= '<a href="' . get_permalink() . '" title="'.the_title( '', '', false ).'">';
  			$image .= get_the_post_thumbnail( $post->ID, $featured, array( 'title' => esc_attr( $title_attribute ), 'alt' => esc_attr( $title_attribute ) ) ).'</a>';
  			$image .= '</figure>';

  			echo $image;
  		}
	?>

	<div class="entry-content clearfix">
	<p><strong>Издательство:</strong> <?php echo get_post_meta($post->ID, 'book_edition', true); ?></p>
		<?php
			the_excerpt();
		?>
	</div>

		<footer class="entry-meta-bar clearfix">	        			
			<div class="entry-meta clearfix">
				<p><a href="<?php 
				$uploadd = wp_upload_dir();
				echo $uploadd[baseurl].'/'.get_post_meta(get_post_meta($post->ID, 'book_file', true), '_wp_attached_file', true); 
				?>">Скачать электронную версию</a></p>
			</div>
		</footer>
	<?php
	do_action( 'spacious_after_post_content' );
   ?>
</article>