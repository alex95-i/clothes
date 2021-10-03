<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();

$container = get_theme_mod( 'understrap_container_type' );
?>

<?php if ( is_front_page() && is_home() ) : ?>
	<?php get_template_part( 'global-templates/hero' ); ?>
<?php endif; ?>

<div class="wrapper" id="index-wrapper">

	<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

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

						   get_template_part( 'loop-templates/content', get_post_format() );

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
            
            <br>

			<?php 
			if( current_user_can('editor') || current_user_can('administrator') ) {
			get_template_part( 'loop-templates/content', 'form' ); 
			}
			?>

		</div><!-- .row -->

	</div><!-- #content -->

</div><!-- #index-wrapper -->

<?php
get_footer();
