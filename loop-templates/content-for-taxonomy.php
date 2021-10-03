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

		<?php if ( 'post' === get_post_type() ) : ?>

			<div class="entry-meta">
				<?php understrap_posted_on(); ?>
			</div><!-- .entry-meta -->

		<?php endif; ?>

	</header><!-- .entry-header -->

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
