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
				}
			}
		} else {
			$HQ = GoAbroadHQ::LeadCapture();
			$HQ->submitLead($_POST);
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
		if ( version_compare( $GLOBALS['wp_version'], AKISMET__MINIMUM_WP_VERSION, '<' ) ) {
			load_plugin_textdomain( 'goabroadhq' );
			
			$message = '<strong>'.sprintf(esc_html__( 'Akismet %s requires WordPress %s or higher.' , 'goabroadhq'), AKISMET_VERSION, AKISMET__MINIMUM_WP_VERSION ).'</strong> '.sprintf(__('Please <a href="%1$s">upgrade WordPress</a> to a current version, or <a href="%2$s">downgrade to version 2.4 of the Akismet plugin</a>.', 'goabroadhq'), 'https://codex.wordpress.org/Upgrading_WordPress', 'http://wordpress.org/extend/plugins/goabroadhq/download/');

			Self::bail_on_activation( $message );
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
	<p><?php echo esc_html( $message ); ?></p>
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