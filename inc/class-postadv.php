<?php
class Postadv {

	/**
	 * constructor
	 */
	public function __construct() {

		if( is_admin() ) {

			add_action( 'admin_menu', array( $this, 'pa_create_option_menu' ) );

			// add_action( 'add_meta_boxes', 'Postadv::pa_add_metabox', 10, 2 );
			add_action( 'add_meta_boxes', array( $this, 'pa_add_metabox' ), 10, 2 );
			add_action( 'save_post', array( $this, 'pa_save_metabox' ), 10, 2 );
		}

		add_shortcode( 'postadv', array( $this, 'pa_render_adv' ));
	}

	/**
	 * Add submenu under settings menu
	 */
	public function pa_create_option_menu() {
				
		add_options_page(
			__( 'Postadv Settings', 'postadv' ),
			__( 'Postadv', 'postadv'),
			'manage_options',
			'postadv.php',
			array( $this, 'pa_display_admin_page' )
		);
	}

	/**
	 * Display postadv admin settings
	 */
	public function pa_display_admin_page() {

		require_once( POSTADV_PLUGIN_DIR_PATH . '/view/admin-settings.php' );
	}

	/**
	 * Add, render and save meta box
	 */
	public function pa_add_metabox( $post_type, $post ) {

		// add_meta_box( $id, $title, $callback, $screen, $context, $priority, $callback_args );
		add_meta_box( 'postadvdiv', __( 'Post Adv.', 'postadv' ), array( $this, 'pa_render_adv_textarea' ), $post_type, 'side' );
	}

	public function pa_render_adv_textarea( $post ) { 

		wp_nonce_field( basename( __FILE__ ), '_panonce' );
		$postadv = get_post_meta( $post->ID, 'postadvdiv', true );

		?>
		<p>If you want to have different adv. per post than add your script here else leave empty.</p>
		<textarea name="pa_ip_adv" rows="5" style="width: 100%;"><?php echo $postadv; ?></textarea>

	<?php 
	}

	function pa_save_metabox( $post_id, $post ) {

		// Verify this came from the our screen and with proper authorization,
		// because save_post can be triggered at other times
		if ( !wp_verify_nonce( $_POST['_panonce'], basename( __FILE__ ) ))
			return $post_id;

		// Verify if this is an auto save routine. If it is our form has not been submitted, we dont want to do anything
		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
			return $post_id;

		// Check permissions to edit pages and/or posts
		if ( 'page' == $_POST['post_type'] ||  'post' == $_POST['post_type']) {
			if ( !current_user_can( 'edit_page', $post_id ) || !current_user_can( 'edit_post', $post_id ))
			  return $post_id;
		} 
		
		// OK, we're authenticated: we need to find and save the data
		$value = $_POST['pa_ip_adv'];

		// save data
		update_post_meta( $post_id, 'postadvdiv', $value ); 
	}

	/**
	 * Shortcode
	 */
	function pa_render_adv( $atts ) {

		$a = shortcode_atts( array (
			'page' => 0,
			'latency' => get_option( '_pa_latency' ),
			'latency_day' => get_option( '_pa_latency_day' ) 
			), $atts );

		ob_start();

		// first check if the post has ad sense code
		global $post;
		$postadv = get_post_meta( $post->ID, 'postadvdiv', true );

		// if the single post is empty/not used for google adsense
		if( $postadv == "" ) {
			
			if( $a['page'] ) {

				$page = get_post( $a['page'] );
				$postadv = apply_filters( 'the_content', $page->post_content );

			} else {

				// if the page is not used for adsense
				if( $postadv == "" ) {
					$postadv = get_option( '_pa_script' );
				}
			}
		} 

		if( $postadv != "" ) {

			// now lets check the latency
			// if latecny is on
			if( $a['latency'] == 'on' ) {

				$latency_day = "+{$a['latency_day']} days";
				
				$published_day =  date( 'Y-m-d', strtotime( $post->post_date ) );
				$published_day_string = strtotime( $published_day );
				
				// add latency day + published date
				$latency_date_string = strtotime( $latency_day, $published_day_string );
				
				$today_date_string = strtotime( date( 'Y-m-d' ) );

				$days_passed = date( 'j', $today_date_string - $published_day_string );

				if( $days_passed > $a['latency_day'] ) {

					echo '<div class="postadv-wrapper" style="text-align:center;">';
					echo stripcslashes( $postadv );
					echo '</div>';

				} else {
					// echo '<p>Latency date not crossed.</p>';
				}

			} else {

				// else show directly
				echo '<div class="postadv-wrapper" style="text-align:center;">';
				echo stripcslashes( $postadv );
				echo '</div>';

			}
			return ob_get_clean();
		}
	}

	/**
	 * Sanitization process
	 */
	public function pa_sanitize( $val ) {

		// trim whitespaces before and after the value
		$val = trim( $val );

		// remove any slashes from PHP's magic quotes
		$val = wp_unslash( $_POST[ 'pa_ip_script' ] );

		return $val;
	}
}