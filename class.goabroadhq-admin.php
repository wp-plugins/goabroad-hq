<?php

class GoAbroadHQ_Admin {
	const NONCE = 'goabroadhq-update-key';
	private static $initiated = false;
	public static function init() {
		if ( ! self::$initiated ) {
			self::init_hooks();
		}
		if ( isset( $_POST['action'] ) && $_POST['action'] == 'enter-key' ) {
			self::enter_api_key();
		}
		if ( isset( $_POST['action'] ) && $_POST['action'] == 'save-config' ) {
			self::save_config();
		}

	}

	public static function init_hooks() {
		add_action( 'admin_menu', array( 'GoAbroadHQ_Admin', 'admin_menu' ), 5 ); # Priority 5, so it's called before Jetpack's admin_menu.
		add_action( 'admin_notices', array( 'GoAbroadHQ_Admin', 'display_notice' ) );
	}
	public static function admin_init() {
		if(!get_option('GoAbroadHQ_Username')){

		}
	}
	public static function display_notice() {
		if(!GoAbroadHQ::get_api_key()){
			GoAbroadHQ::view( 'notice', array( 'type' => 'plugin' ) );
		}
	}


	public static function admin_menu() {
			$hook = add_options_page( __('GoAbroadHQ', 'goabroadhq'), __('GoAbroadHQ', 'goabroadhq'), 'manage_options', 'goabroadhq-key-config', array( 'GoAbroadHQ_Admin', 'display_page' ) );
	}


	public static function display_page() {
		if ( !GoAbroadHQ::get_api_key() || ( isset( $_GET['view'] ) && $_GET['view'] == 'start' ) )
			self::display_start_page();
		elseif ( isset( $_GET['view'] ) && $_GET['view'] == 'stats' )
			self::display_stats_page();
		else
			self::display_configuration_page();
	}

	public static function enter_api_key(){
		if ( isset( $_POST['_wpnonce'] ) && wp_verify_nonce( $_POST['_wpnonce'], self::NONCE ) ) {
			if (isset($_POST['username']) && isset($_POST['password'])) {
				update_option( 'goabroadhq_env', 'prod' );
				update_option( 'goabroadhq_username', $_POST['username'] );
				update_option( 'goabroadhq_password', $_POST['password'] );
				self::display_configuration_page();
				return;				
			}
		}
	}

	public static function display_start_page() {
		if ( isset( $_GET['action'] ) ) {
			if ( $_GET['action'] == 'delete-key' ) {
				if ( isset( $_GET['_wpnonce'] ) && wp_verify_nonce( $_GET['_wpnonce'], self::NONCE ) )
					delete_option( 'goabroadhq_username' );
					delete_option( 'goabroadhq_password' );
			}
		}

		if ( $api_key = GoAbroadHQ::get_api_key() ) {
			self::display_configuration_page();
			return;
		}

		echo '<h2 class="hq-header">'.esc_html__('GoAbroadHQ', 'goabroadhq').'</h2>';

		GoAbroadHQ::view('start');
	}

	public static function save_config(){
		if ( isset( $_POST['_wpnonce'] ) && wp_verify_nonce( $_POST['_wpnonce'], self::NONCE ) ) {
			if (isset($_POST['username']) && isset($_POST['password'])) {
				update_option( 'goabroadhq_env', 'prod' );
				update_option( 'goabroadhq_username', $_POST['username'] );
				update_option( 'goabroadhq_password', $_POST['password'] );
				return;				
			}
		}
	}

	public static function display_configuration_page(){
		GoAbroadHQ::view('config');
	}

	public static function get_page_url( $page = 'config' ) {

		$args = array( 'page' => 'goabroadhq-key-config' );

		if ( $page == 'stats' )
			$args = array( 'page' => 'goabroadhq-key-config', 'view' => 'stats' );
		elseif ( $page == 'delete_key' )
			$args = array( 'page' => 'goabroadhq-key-config', 'view' => 'start', 'action' => 'delete-key', '_wpnonce' => wp_create_nonce( self::NONCE ) );

		$url = add_query_arg( $args, admin_url( 'options-general.php' ) );

		return $url;
	}
}