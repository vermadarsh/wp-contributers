<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.facebook.com/vermadarsh
 * @since      1.0.0
 *
 * @package    Wp_Contributers
 * @subpackage Wp_Contributers/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Contributers
 * @subpackage Wp_Contributers/admin
 * @author     Adarsh Verma <adarsh.srmcem@gmail.com>
 */
class Wp_Contributers_Admin {

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
	 * Add meta box to the post
	 */
	public function wpc_contributors_metabox() {
		add_meta_box( 'wpc-contributors-metabox', __( 'Contributors', WPC_TEXT_DOMAIN ), array( $this, 'wpc_contributors_metabox_content' ), 'post', 'side', 'high', null );
	}

	/**
	 * Price metabox - show content
	 */
	public function wpc_contributors_metabox_content() {
		global $post;
		$contributors = get_post_meta( $post->ID, 'post-contributors', true );
		if( ! $contributors ) {
			$contributors = array();
		}
		foreach( get_users() as $user ) {
			$checked = ( isset( $contributors ) && in_array( $user->ID, $contributors ) ) ? 'checked' : '';
			?>
			<p class="wpc-contributor">
			<input type="checkbox" <?php echo $checked;?> id="user-<?php echo $user->ID;?>" name="post_contributors[]" value="<?php echo $user->ID;?>">
			<label for="user-<?php echo $user->ID;?>"><?php echo $user->data->display_name;?></label>
			</p>
			<?php
		}
	}

	/**
	 * Actions performed to save the meta fields in books
	 */
	public function wpc_update_contributors_metabox( $postid ) {
		if( get_post_type( $postid ) == 'post' ) {
			if( isset( $_POST['post_contributors'] ) ) {
				$contributors = wp_unslash( $_POST['post_contributors'] );
				update_post_meta( $postid, 'post-contributors', $contributors );
			}
		}
	}

	/**
	 * Actions performed to add new column headings in the posts list
	 */
	public function wpc_new_column_heading( $defaults ) {
		$defaults['post-contributors']		=	__( 'Contributors', WPC_TEXT_DOMAIN );
		return $defaults;
	}

	/**
	 * Actions performed to add new column content in the posts list
	 */
	public function wpc_new_column_content( $column_name, $postid ) {
		$contributors = get_post_meta( $postid, 'post-contributors', true );
		if ( $column_name == 'post-contributors' ) {
			if( !empty( $contributors ) ) {
				$contributors_str = '';
				foreach( $contributors as $cid ) {
					$contributor = get_userdata( $cid );
					$contrubutor_edit_url = admin_url( 'user-edit.php?user_id='.$cid );
					$contributors_str .= '<a target="_blank" href=" ' . $contrubutor_edit_url . ' ">' . $contributor->data->display_name . '</a>, ';
				}
				$contributors_str = rtrim( $contributors_str, ', ' );
			} else {
				$contributors_str = '--';
			}
			echo $contributors_str;
		}
	}
}