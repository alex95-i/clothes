<?php
/**
 * UnderStrap functions and definitions
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// UnderStrap's includes directory.
$understrap_inc_dir = 'inc';

// Array of files to include.
$understrap_includes = array(
	'/theme-settings.php',                  // Initialize theme default settings.
	'/setup.php',                           // Theme setup and custom theme supports.
	'/widgets.php',                         // Register widget area.
	'/enqueue.php',                         // Enqueue scripts and styles.
	'/template-tags.php',                   // Custom template tags for this theme.
	'/pagination.php',                      // Custom pagination for this theme.
	'/hooks.php',                           // Custom hooks.
	'/extras.php',                          // Custom functions that act independently of the theme templates.
	'/customizer.php',                      // Customizer additions.
	'/custom-comments.php',                 // Custom Comments file.
	'/class-wp-bootstrap-navwalker.php',    // Load custom WordPress nav walker. Trying to get deeper navigation? Check out: https://github.com/understrap/understrap/issues/567.
	'/editor.php',                          // Load Editor functions.
	'/block-editor.php',                    // Load Block Editor functions.
	'/deprecated.php',                      // Load deprecated functions.
);

// Load WooCommerce functions if WooCommerce is activated.
if ( class_exists( 'WooCommerce' ) ) {
	$understrap_includes[] = '/woocommerce.php';
}

// Load Jetpack compatibility file if Jetpack is activiated.
if ( class_exists( 'Jetpack' ) ) {
	$understrap_includes[] = '/jetpack.php';
}

// Include files.
foreach ( $understrap_includes as $file ) {
	require_once get_theme_file_path( $understrap_inc_dir . $file );
}


/* Custom Post Type Clothes Start */

function create_post_type_clothes_and_taxonomy() {
	$supports = array(
		'title', // post title
		'editor', // post content
		'author', // post author
		'thumbnail', // featured images
		'excerpt', // post excerpt
	);
	$labels = array(
		'name' => _x('Clothes', 'plural'),
		'singular_name' => _x('Clothes', 'singular'),
		'menu_name' => _x('Clothes', 'admin menu'),
		'name_admin_bar' => _x('Clothes', 'admin bar'),
		'add_new' => _x('Add Clothes', 'add new'),
		'add_new_item' => __('Add New Clothes'),
		'new_item' => __('New Clothes'),
		'edit_item' => __('Edit Clothes'),
		'view_item' => __('View Clothes'),
		'all_items' => __('All Clothes'),
		'search_items' => __('Search Clothes'),
		'not_found' => __('No Clothes found.'),
	);
	$args = array(
		'supports' => $supports,
		'label'  => 'Clothes',
		'labels' => $labels,
		'description' => 'clothes post type',
		'public' => true,
		'query_var' => true,
		'rewrite' => array('slug' => 'clothes'),
		'has_archive' => false,
		'hierarchical' => false,
	);

	register_taxonomy( 'clothes-type', [ 'clothes' ], [
		'label'                 => '', // определяется параметром $labels->name
		'labels'                => [
			'name'              => 'Clothes type',
			'singular_name'     => 'Clothes type',
			'search_items'      => 'Search clothes types',
			'all_items'         => 'All Clothes types',
			'view_item '        => 'View Clothes type',
			'parent_item'       => 'Parent Clothes type',
			'parent_item_colon' => 'Parent Clothes type:',
			'edit_item'         => 'Edit Clothes type',
			'update_item'       => 'Update Clothes type',
			'add_new_item'      => 'Add Clothes type',
			'new_item_name'     => 'New Clothes type',
			'menu_name'         => 'Clothes types',
		],
		'public'                => true,
		// 'publicly_queryable'    => null, // равен аргументу public
		// 'show_in_nav_menus'     => true, // равен аргументу public
		// 'show_ui'               => true, // равен аргументу public
		// 'show_in_menu'          => true, // равен аргументу show_ui
		// 'show_tagcloud'         => true, // равен аргументу show_ui
		// 'show_in_quick_edit'    => null, // равен аргументу show_ui
		'hierarchical'          => false,

		'rewrite'               => true,
		//'query_var'             => $taxonomy, // название параметра запроса
		'capabilities'          => array(),
		'meta_box_cb'           => null, // html метабокса. callback: `post_categories_meta_box` или `post_tags_meta_box`. false — метабокс отключен.
		'show_admin_column'     => false, // авто-создание колонки таксы в таблице ассоциированного типа записи. (с версии 3.5)
		'show_in_rest'          => null, // добавить в REST API
		'rest_base'             => null, // $taxonomy
		// '_builtin'              => false,
		//'update_count_callback' => '_update_post_term_count',
	] );

     register_post_type('clothes', $args);
}
add_action('init', 'create_post_type_clothes_and_taxonomy');
/* Custom Post Type End */

/*loop-next script*/

add_action( 'wp_enqueue_scripts', 'loop_next' );
function loop_next(){
	wp_enqueue_script( 'loop_next', get_template_directory_uri() . '/js/my_loop_next.js');
}

/*ajax call script*/
function my_enque(){
	wp_enqueue_script( 'ajax-script', get_template_directory_uri() . '/js/my_ajax.js');
	wp_localize_script( 'ajax-script', 'my_ajax_object',
            array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
}

add_action( 'wp_enqueue_scripts', 'my_enque' );



// The ajax answer()
add_action( 'wp_ajax_create_clothes', 'answer' );

function answer() {
    // check_ajax_referer( 'nonce-name' );
    
	if ( ( empty( $_POST['ajax_nonce'] ) ) || ( ! wp_verify_nonce($_POST['ajax_nonce'], 'nonce_clothes') ) ) {
	 return;
	}
	
	require_once( ABSPATH . 'wp-admin/includes/image.php' );
	require_once( ABSPATH . 'wp-admin/includes/file.php' );
	require_once( ABSPATH . 'wp-admin/includes/media.php' );
	
	$attachment_id = media_handle_upload( 'myfile', $_POST['image'] );

	if ( is_wp_error( $attachment_id ) ) {
		echo "Ошибка загрузки медиафайла.";
	} 
		
    $post_id = wp_insert_post(array (
    'post_type'    => 'clothes',
    'post_title'   => $_POST['title'],
    'post_content' => '',
    'post_status'  => 'publish',
    ));
	
	set_post_thumbnail( $post_id, $attachment_id );
	
	$size = explode(',', $_POST['size_val']);
	$color = explode(',', $_POST['color_val']);
	$sex = explode(',', $_POST['sex_val']);
	
	update_field('size', $size, $post_id);
	update_field('color', $color, $post_id);
	update_field('sex', $sex, $post_id);
	
    $terms = explode(',', $_POST['term_val']);

	wp_set_object_terms($post_id, $terms,'clothes-type');
 
    echo (json_encode($_POST));
	
    wp_die(); // terminate script after any required work, if not, the response text will output 'hello0' because the of function return after finish
}