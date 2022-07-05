<?php

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

if (!class_exists('StoreSlotsAdminAjax')) {
    class StoreSlotsAdminAjax {

        public $admin_class;

        public function __construct( $admin_obj ) {
            $this->admin_class = $admin_obj;
            add_action( 'wp_ajax_storeslot_save_settings', array($this, 'storeslot_save_settings') );
        }

        public function storeslot_save_settings() {
            include_once STORESLOTS_PATH . "backend/api/save_settings.php";
            wp_die();
        }

        

    }
}
