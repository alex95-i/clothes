<?php
/**
 * The template for displaying clothes taxonomy
 *
 * 
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();

$container = get_theme_mod( 'understrap_container_type' );
$term_id = get_queried_object_id();
$term_name = get_term( $term_id )->name;
$term = get_term( $term_id );
$description = get_field('description', $term->taxonomy . '_' . $term->term_id);
$image = get_field('image', $term->taxonomy . '_' . $term->term_id);
?>

<?php if ( is_front_page() && is_home() ) : ?>
	<?php get_template_part( 'global-templates/hero' ); ?>
<?php endif; ?>

<div class="wrapper" id="index-wrapper">

	<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">
    
		<div><h1><?php echo $term_name;?></h1></div>
		<div><p><?php echo $description; ?></p></div>
	    <div><img src="<?php echo $image; ?>"  width="500" height="500"></div>
        <br>
		<div class="row">

			<!-- Do the left sidebar check and opens the primary div -->
			<?php get_template_part( 'global-templates/left-sidebar-check' ); ?>

			<main class="site-main custom-wrapper" id="main">
				<?php

				$args = array(  
					'post_type' => 'clothes',
					'post_status' => 'publish',
					'posts_per_page' => 10, 
					'orderby' => 'date', 
					'order' => 'DESC',
					'tax_query' => array(
				    array(
				    'taxonomy' => 'clothes-type',
				    'field' => 'term_id',
				    'terms' => $term_id
				     )
				  )
				);

				$loop = new WP_Query( $args ); 

				if ( $loop->have_posts() ) {

					$count = 0;
					// Start the Loop.
					while ( $loop->have_posts() ) {
						
						$loop->the_post();

						$count++;                   
						/*
						 * Include the Post-Format-specific template for the content.
						 * If you want to override this in a child theme, then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						?>

						<div class="<?php echo ($count > 4) ? 'item child-hidden' : 'item custom-child'?>">

						<?php

						   get_template_part( 'loop-templates/content-for-taxonomy', get_post_format() );

						?>

						</div>

						<?php
					}
				} else {
					get_template_part( 'loop-templates/content', 'none' );
				}
				?>

			</main><!-- #main -->

			<!-- The pagination component -->
			<button id="custom-next">Next page</button>

			

		</div><!-- .row -->

	</div><!-- #content -->

</div><!-- #index-wrapper -->

<?php
get_footer();
