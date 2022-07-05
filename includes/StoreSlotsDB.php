<?php

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

if (!class_exists('StoreSlotsDB')) {
    class StoreSlotsDB {

        public $admin_class;
        public $wpdb;

        public function __construct($admin_obj) {
            $this->admin_class = $admin_obj;
        }
    }
}
