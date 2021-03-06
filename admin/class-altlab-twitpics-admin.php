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

// [bartag foo="foo-value"]
function altlab_twitpics_shortcode( $atts ) {
	global $post;
    $a = shortcode_atts( array(
        'paged' => 'true',
        'post_type' => 'twitpic',
        'category_name' => '',
        'tag' => '',
        'posts_per_page' => '15',
        'max_column' => '3',
        'thumbnail' => 'true',
        'thumbnail_size' => 'large',
        'excerpt' => 'false',
        'content' => 'true',
        'title' => 'false',
        'author' => 'false',
        'date' => 'false'
    ), $atts );
 	
 	$output= "";
	
	// Run a new query for the twitpics
	if ( $a['paged'] == 'true' ){ $paged = (get_query_var('paged')) ? get_query_var('paged') : 1; } else { $paged = null; }
	$args = array(
		'post_type' => $a['post_type'],
		'paged' => $paged,
		'posts_per_page' => $a['posts_per_page'],
		'category_name' => $a['category_name'],
        'tag' => $a['tag']
	);

	$the_query = new WP_Query( $args );

	// The Loop
	if ( $the_query->have_posts() ) :
		$output = "
			<div class='altlabtwitpic-masonry maxcol".$a['max_column']."'>
		  		<div class='altlabtwitpic-grid-sizer'></div>";
	
	
	while ( $the_query->have_posts() ) : $the_query->the_post();
		// thumbnail output
		$output .= "<article class='altlabtwitpic-brick hentry'>";
		if ( has_post_thumbnail() && $a['thumbnail'] == 'true' ) {
			$thumbnail_url = wp_get_attachment_image_src( get_post_thumbnail_id(), $a['thumbnail_size']);
			$output .= "<img class='twitpic' src='".$thumbnail_url[0]."'/>";
		}
		
		// postmeta
		if ( $a['title'] == 'true' || $a['author'] == 'true' || $a['date'] == 'true' ){
			$output .= "<ul class='post-meta'>";
			if ( $a['title'] == 'true' ){
				$output .= "<li class='post-title'>".get_the_title()."</li>";
			}
			if ( $a['author'] == 'true' ){
				$output .= "<li class='post-author'>".get_the_author()."</li>";
			}
			if ( $a['date'] == 'true' ){
				$output .= "<li class='post-date'>".get_the_date()."</li>";
			}

		}

		if ( current_user_can('administrator') ){
			$output .= "<a href='".get_edit_post_link()."'>&#9998;</a>";
		}

		if ( $a['content'] == 'true' ){
			$output .= get_the_content();
		}
		if ( $a['excerpt'] == 'true' ){
			$output .= get_the_excerpt();
		}

		$output .= "</article>";
	
	endwhile;
		$output .= "</div>";
	endif;
		

	if ( $a['paged'] == 'true' ){
		$output .= "<nav class='navigation pagination'><div class='next'>".get_next_posts_link('Next Page', $the_query->max_num_pages)."</div>";
		$output .= "<div class='prev'>".get_previous_posts_link('Previous Page')."</div></nav>";
	}


	wp_reset_postdata();	

    return $output;
}
add_shortcode( 'twitpic', 'altlab_twitpics_shortcode' );







	