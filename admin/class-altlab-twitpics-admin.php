<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://luetkemj.github.io
 * @since      1.0.0
 *
 * @package    Altlab_Twitpics
 * @subpackage Altlab_Twitpics/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Altlab_Twitpics
 * @subpackage Altlab_Twitpics/admin
 * @author     Mark Luetke <luetkemj@gmail.com>
 */
class Altlab_Twitpics_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Altlab_Twitpics_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Altlab_Twitpics_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/altlab-twitpics-admin.css', array(), $this->version, 'all' );
		// wp_enqueue_style( 'http:////maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Altlab_Twitpics_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Altlab_Twitpics_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/altlab-twitpics-admin.js', array( 'jquery' ), $this->version, false );

	}

}


// Flush your rewrite rules

function altlabtwitpics_flush_rewrite_rules() {
	flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'altlabtwitpics_flush_rewrite_rules' );

// let's create the function for the Twitpic
function altlabtwitpics_custom_post_type() { 
	// creating (registering) the Twitpic 
	register_post_type( 'twitpic', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
		// let's now add all the options for this Twitpic
		array( 'labels' => array(
			'name' => __( 'Twitpics', 'bonestheme' ), /* This is the Title of the Group */
			'singular_name' => __( 'Twitpic', 'bonestheme' ), /* This is the individual type */
			'all_items' => __( 'All Twitpics', 'bonestheme' ), /* the all items menu item */
			'add_new' => __( 'Add New', 'bonestheme' ), /* The add new menu item */
			'add_new_item' => __( 'Add New Twitpic', 'bonestheme' ), /* Add New Display Title */
			'edit' => __( 'Edit', 'bonestheme' ), /* Edit Dialog */
			'edit_item' => __( 'Edit Twitpics', 'bonestheme' ), /* Edit Display Title */
			'new_item' => __( 'New Twitpic', 'bonestheme' ), /* New Display Title */
			'view_item' => __( 'View Twitpic', 'bonestheme' ), /* View Display Title */
			'search_items' => __( 'Search Twitpic', 'bonestheme' ), /* Search Twitpic Title */ 
			'not_found' =>  __( 'Nothing found in the Database.', 'bonestheme' ), /* This displays if there are no entries yet */ 
			'not_found_in_trash' => __( 'Nothing found in Trash', 'bonestheme' ), /* This displays if there is nothing in the trash */
			'parent_item_colon' => ''
			), /* end of arrays */
			'description' => __( 'This is the Twitpic type', 'bonestheme' ), /* Twitpic Description */
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'query_var' => true,
			'menu_position' => 8, /* this is what order you want it to appear in on the left hand side menu */ 
			'menu_icon' => 'dashicons-twitter', /* the icon for the Twitpic type menu */
			'rewrite'	=> array( 'slug' => 'twitpic', 'with_front' => false ), /* you can specify its url slug */
			'has_archive' => 'twitpic', /* you can rename the slug here */
			'capability_type' => 'post',
			'hierarchical' => false,
			/* the next one is important, it tells what's enabled in the post editor */
			'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'sticky')
		) /* end of options */
	); /* end of register Twitpic */
	
}

// adding the function to the Wordpress init
add_action( 'init', 'altlabtwitpics_custom_post_type');









// [bartag foo="foo-value"]
function altlab_twitpics_shortcode( $atts ) {
	global $post;
    $a = shortcode_atts( array(
        'foo' => 'something',
        'bar' => 'something else',
    ), $atts );
 	
 	$output= "";
	// Run a new query for the twitpics
	$args = array(
		'post_type' => 'twitpic',
		'post_per_page' => 20
	);

	$the_query = new WP_Query( $args );

	// The Loop
	if ( $the_query->have_posts() ) :
		$output = "
			<div class='altlabtwitpic-masonry'>
		  		<div class='altlabtwitpic-grid-sizer'></div>";
	
	
	while ( $the_query->have_posts() ) : $the_query->the_post();
	
		if ( has_post_thumbnail() ) {
			$thumbnail_url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
			$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );
			print_r($thumbnail);


			// $thumbnail = get_the_post_thumbnail( $post->ID, 'full' );
			$content = get_the_content();
		}

		$output .= "
		  <div class='altlabtwitpic-brick'>
		  	<img class='twitpic lazy' width='".$thumbnail[1]."' height='".$thumbnail[2]."' data-original='".$thumbnail[0]."' />
		  	{$content}
		  </div>";
	
	endwhile;
		$output .= "</div>";
	endif;
	wp_reset_postdata();	

    return $output;
}
add_shortcode( 'twitpic', 'altlab_twitpics_shortcode' );







	