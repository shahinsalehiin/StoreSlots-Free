<?php

// If this file is called directly, abort.
if (!defined ('WPINC')) {
    die;
}

if (!class_exists ('StoreSlotsFrontendAjax')) {

    class StoreSlotsFrontendAjax {

        public $frontend_class;

        public function __construct ($frontend_obj) {
            $this->frontend_class = $frontend_obj;

            add_action ('wp_ajax_storeslots_get_customer_total_order', array($this, 'storeslots_get_customer_total_order'));
            add_action( 'wp_ajax_nopriv_storeslots_get_customer_total_order', array($this, 'storeslots_get_customer_total_order') );

        }

        public function storeslots_get_customer_total_order() {
            include_once STORESLOTS_PATH . "/frontend/api/customer-orders.php";
            wp_die ();
        }



    }

}