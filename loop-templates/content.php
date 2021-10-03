<?php
/**
 * Post rendering content according to caller of get_template_part
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<article <?php post_class('article-item'); ?> id="post-<?php the_ID(); ?>">

	<header class="entry-header">

		 <span>

		 	<?php   // Get terms for post
	 	     echo (get_page_template_slug($post->ID));

			 $terms = get_the_terms( $post->ID , 'clothes-type' );
			 // Loop over each item since it's an array
			 if ( $terms != null ){
				 foreach( $terms as $term ) {
					 // Print the name method from $term which is an OBJECT
					  $term_link = get_term_link(  (int) $term->term_id, 'clothes-type' );
					  print '<a class="term-title" target="_blank" href="'.$term_link.'">'.$term->slug.'</a> ';
					 // Get rid of the other data stored in the object, since it's not needed
					 unset($term);
			     } 
			 } 

			?>

		 </span>

		 

		<?php if ( 'post' === get_post_type() ) : ?>

			<div class="entry-meta">
				<?php understrap_posted_on(); ?>
			</div><!-- .entry-meta -->

		<?php endif; ?>

	</header><!-- .entry-header -->

    <br>
    
	<?php echo get_the_post_thumbnail( $post->ID, array(200, 200) ); ?>

    <br>

	<div class="entry-content">

		<?php
		the_title(
			sprintf( '<h2 class="entry-title acf-text"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ),
			'</a></h2>'
		);
		?>
		<br>

		<div class="acf-text"><p><?php the_field('sex'); ?></p></div>
		<div class="acf-text"><p><?php the_field('color'); ?></p></div>
		<div class="acf-text"><p><?php the_field('size'); ?></p></div>


	</div><!-- .entry-content -->


</article><!-- #post-## -->
