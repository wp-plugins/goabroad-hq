<?php

require(__DIR__.'/sdk/LeadCapture.php');
require(__DIR__.'/sdk/ReCaptcha.php');

class GoAbroadHQ {

	public static function init() {
		if(isset($_POST['goabroadhq_submit'])){
			GoAbroadHQ::submit();
		}
	}

	public static function submit(){
		if(get_option('goabroadhq_recaptcha_sitekey') && get_option('goabroadhq_recaptcha_secret')){
			$reCaptcha = new ReCaptcha(get_option('goabroadhq_recaptcha_secret'));
			if ($_POST["g-recaptcha-response"]) {
		    $resp = $reCaptcha->verifyResponse(
		        $_SERVER["REMOTE_ADDR"],
		        $_POST["g-recaptcha-response"]
		    );
				if ($resp != null && $resp->success) {
					$HQ = GoAbroadHQ::LeadCapture();
					$HQ->submitLead($_POST);
					wp_redirect($_POST['goabroadhq_redirect_url']);
					exit;
				}
			}
		} else {
			$HQ = GoAbroadHQ::LeadCapture();
			$HQ->submitLead($_POST);
			wp_redirect($_POST['goabroadhq_redirect_url']);
			exit;
		}
	}

	public static function LeadCapture(){
		return new LeadCapture(array('env'=>get_option('goabroadhq_env'),'credentials'=>array('username'=>get_option('goabroadhq_username'),'password'=>get_option('goabroadhq_password'))));
	}

	public static function view( $name, array $args = array() ) {
		$args = apply_filters( 'goabroadhq_view_arguments', $args, $name );
		
		foreach ( $args AS $key => $val ) {
			$$key = $val;
		}
		
		load_plugin_textdomain( 'goabroadhq' );

		$file = GOABROADHQ_PLUGIN_DIR . 'views/'. $name . '.php';

		include( $file );
	}


	/**
	 * Attached to activate_{ plugin_basename( __FILES__ ) } by register_activation_hook()
	 * @static
	 */
	public static function plugin_activation() {
		if ( version_compare( $GLOBALS['wp_version'], GOABROADHQ__MINIMUM_WP_VERSION, '<' ) ) {
			load_plugin_textdomain( 'goabroadhq' );
			
			$message = '<strong>'.sprintf('GoAbroadHQ requires Wordpress %s or higher.' , 'goabroadhq', GOABROADHQ_VERSION, GOABROADHQ__MINIMUM_WP_VERSION ).'</strong><br>'.sprintf('Please <a href="%1$s">upgrade WordPress</a> to a current version.', 'goabroadhq', 'https://codex.wordpress.org/Upgrading_WordPress', 'http://wordpress.org/extend/plugins/goabroadhq/download/');

			GoAbroadHQ::bail_on_activation( $message );
		}
		if(!is_resource(@fsockopen('hq.goabroadhq.com', 84,$errno,$errstr,5))){
			load_plugin_textdomain( 'goabroadhq' );
			
			$message = '<strong>'.sprintf('GoAbroadHQ requires you allow outgoing connections on port 84.' , 'goabroadhq').'</strong><br>'.sprintf('Please contact your hosting provider or systems administrator to open port 84.', 'goabroadhq');

			GoAbroadHQ::bail_on_activation( $message );
		}
	}

	/**
	 * Removes all connection options
	 * @static
	 */
	public static function plugin_deactivation( ) {
		delete_option('goabroadhq_env');
		delete_option('goabroadhq_username');
		delete_option('goabroadhq_password');
		delete_option('goabroadhq_recaptcha_secret');
		delete_option('goabroadhq_recaptcha_sitekey');
		//tidy up
	}

	private static function bail_on_activation( $message, $deactivate = true ) {
	?>
	<!doctype html>
	<html>
	<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<body>
	<p><?php echo $message; ?></p>
	</body>
	</html>
	<?php
		if ( $deactivate ) {
			$plugins = get_option( 'active_plugins' );
			$goabroadhq = plugin_basename( GOABROADHQ_PLUGIN_DIR . 'goabroadhq.php' );
			$update  = false;
			foreach ( $plugins as $i => $plugin ) {
				if ( $plugin === $goabroadhq ) {
					$plugins[$i] = false;
					$update = true;
				}
			}

			if ( $update ) {
				update_option( 'active_plugins', array_filter( $plugins ) );
			}
		}
		exit;
	}


	public static function get_api_key() {
		return apply_filters( 'goabroadhq_get_username', defined('WPCOM_API_KEY') ? constant('WPCOM_API_KEY') : get_option('goabroadhq_username') );
	}
}