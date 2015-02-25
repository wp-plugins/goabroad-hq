<?php
/**
 * @package GoAbroadHQ
 */
/*
Plugin Name: GoAbroadHQ
Plugin URI: http://www.goabroadhq.com/
Description: A wordpress widget to add GoAbroadHQ fields to your website or blog. This plugin only works if you are an active client of GoAbroadHQ
Version: 0.3.2
Author: GoAbroad
Author URI: http://www.goabroad.com
License: GPLv2 or later
Text Domain: GoAbroadHQ
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
  echo 'Please don\'t call me directly. I am just a plugin.';
  exit;
}

define( 'GOABROADHQ_VERSION', '0.4.0' );
define( 'GOABROADHQ_MINIMUM_WP_VERSION', '3.1' );
define( 'GOABROADHQ_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'GOABROADHQ_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'GOABROADHQ_DELETE_LIMIT', 100000 );

register_activation_hook( __FILE__, array( 'GoAbroadHQ', 'plugin_activation' ) );
register_deactivation_hook( __FILE__, array( 'GoAbroadHQ', 'plugin_deactivation' ) );

require_once( GOABROADHQ_PLUGIN_DIR . 'class.goabroadhq.php' );
require_once( GOABROADHQ_PLUGIN_DIR . 'class.goabroadhq-widget.php' );

add_action( 'init', array( 'GoAbroadHQ', 'init' ) );

if ( is_admin() ) {
  require_once( GOABROADHQ_PLUGIN_DIR . 'class.goabroadhq-admin.php' );
  add_action( 'init', array( 'GoAbroadHQ_Admin', 'init' ) );
}
