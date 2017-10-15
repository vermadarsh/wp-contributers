<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.facebook.com/vermadarsh
 * @since      1.0.0
 *
 * @package    Wp_Contributers
 * @subpackage Wp_Contributers/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Wp_Contributers
 * @subpackage Wp_Contributers/public
 * @author     Adarsh Verma <adarsh.srmcem@gmail.com>
 */
class Wp_Contributers_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function wpc_enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-contributers-public.css' );
	}

	/**
	 *
	 */
	public function wpc_add_contributors_list( $content ) {
		
		global $post;
		$contributors = get_post_meta( $post->ID, 'post-contributors', true );
		if( ! $contributors ) {
			$contributors = array();
		}

		$content .= '<div class="wpc-contributors">';
		$content .= '<h3>' . __( 'Contributors', WPC_TEXT_DOMAIN ) . '</h3>';
		if( !empty( $contributors ) ) {
			foreach( $contributors as $cid ) {
				$contributor = get_userdata( $cid );
				$c_avatar = get_avatar( $cid );
				$c_url = get_author_posts_url( $cid );

				$content .= '<div class="wpc-contributor">';
				$content .= '<a href=" ' . $c_url . ' " title=" ' . $contributor->data->display_name . ' ">';
				$content .= $c_avatar;
				$content .= '<span class="wpc-contributor-name">' . $contributor->data->display_name . '</span>';
				$content .= '</a>';
				$content .= '</div>';
			}
		} else {
			$content .= '<p class="wpc-no-contributor">' . __( 'No Contributor!', WPC_TEXT_DOMAIN ) . '</p>';
		}
		$content .= '</div>';

		return $content;
	}

}
