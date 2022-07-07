<?php
/**
 * Plugin Name:       StoreSlots-Free
 * Plugin URI:        https://storeslots.com
 * Description:       StoreSlots is one of the top wp plugin for delivery products on schedule.
 * Version:           1.0.1
 * Author:            StoreSlots
 * Author URI:        https://storeslots.com/author.html
 * License:           GPL-2.0+
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       store-slots
 * Domain Path:       /languages
 */


// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

define(  'STORESLOTS_VERSION', '1.0.1' );
defined( 'STORESLOTS_PATH' ) or define( 'STORESLOTS_PATH', plugin_dir_path( __FILE__ ) );
defined( 'STORESLOTS_URL' ) or define( 'STORESLOTS_URL', plugin_dir_url( __FILE__ ) );
defined( 'STORESLOTS_BASE_FILE' ) or define( 'STORESLOTS_BASE_FILE', __FILE__ );
defined( 'STORESLOTS_BASE_PATH' ) or define( 'STORESLOTS_BASE_PATH', plugin_basename(__FILE__) );
defined( 'STORESLOTS_IMG_DIR' ) or define( 'STORESLOTS_IMG_DIR', plugin_dir_url( __FILE__ ) . 'assets/img/' );
defined( 'STORESLOTS_CSS_DIR' ) or define( 'STORESLOTS_CSS_DIR', plugin_dir_url( __FILE__ ) . 'assets/css/' );
defined( 'STORESLOTS_JS_DIR' ) or define( 'STORESLOTS_JS_DIR', plugin_dir_url( __FILE__ ) . 'assets/js/' );



function store_slots_check_premium_activation() {
    if ( !in_array( 'StoreSlots-Pro/store-slots-pro.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

        require_once STORESLOTS_PATH . 'includes/StoreSlotsUtils.php';
        require_once STORESLOTS_PATH . 'includes/StoreSlotsDB.php';
        require_once STORESLOTS_PATH . 'backend/class-store-slots-ajax.php';
        require_once STORESLOTS_PATH . 'backend/class-store-slots-admin.php';
        require_once STORESLOTS_PATH . 'frontend/class-storeslots-frontend-ajax.php';
        require_once STORESLOTS_PATH . 'frontend/class-storeslots-frontend.php';

    }

}
add_action( 'storeslots_pro_check_init', 'store_slots_check_premium_activation', 10, 2 );
do_action( 'storeslots_pro_check_init');

 