<?php

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

if (!class_exists('StoreSlotsAdmin')) {
    class StoreSlotsAdmin
    {


        public $utils;
        public $db;
        public $storeslot_settings = array();
        public $delivery_dates  = array();
        public $pickup_dates    = array();
        public $delivery_times  = array();
        public $pickup_times    = array();

        public function __construct()
        {
            $this->utils = new StoreSlotsUtils();

            if (in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
                add_action("admin_menu", array($this, 'store_slots_admin_menu'));
                add_action('admin_enqueue_scripts', array($this, 'store_slots_admin_enqueue'));
                add_action('plugin_action_links_' . STORESLOTS_BASE_PATH, array($this, 'store_slots_action_links'));
                $this->db = new StoreSlotsDB($this);
                new StoreSlotsAdminAjax($this);

                $this->storeslot_settings = get_option('storeslot_settings', false);
                $this->delivery_dates     = get_option('storeslot_delivery_dates', false);
                $this->pickup_dates       = get_option('storeslot_pickup_dates', false);
                $this->delivery_times     = get_option('storeslots_delivery_times', false);
                $this->pickup_times       = get_option('storeslots_pickup_times', false);

                add_action('add_meta_boxes', [$this, 'storeslots_order_meta_boxes']);
                add_action('save_post', [$this, 'storeslots_save_order_meta_boxes'], 10, 2);    
            }else{
                add_action( 'admin_init', array($this, 'storeslots_free_plugin_activation') );
            }
            

            
        }

        public function storeslots_free_plugin_activation() {
            if ( is_admin() && current_user_can( 'activate_plugins' ) &&  !is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
                add_action( 'admin_notices', array( $this, 'storeslots_free_woo_plugin_notice') );
            }
        }

        public function storeslots_free_woo_plugin_notice(){
            $main_plugin  = __( 'StoreSlots-Free', 'store-slots' );
            $lite_plugin = __( 'WooCommerce', 'store-slots' );

            echo '<div class="notice notice-error is-dismissible"><p>' . sprintf( esc_html__( '%1$s requires %2$s to be installed and activated to function properly. %3$s', 'store-slots' ),
                    '<strong>' . esc_html( $main_plugin ). '</strong>',
                    '<strong>' . esc_html( $lite_plugin ) . '</strong>',
                    '<a href="' . esc_url( admin_url( 'plugin-install.php?s=WooCommerce&tab=search&type=term' ) ) . '">' . __( 'Please click on this link and install WooCommerce from WordPress.', 'store-slots' ) . '</a>' )
                . '</p></div>';
        }

        public function store_slots_action_links($links)
        {
            $settings_url = add_query_arg('page', 'store-slots', get_admin_url() . 'admin.php');
            $setting_arr = array('<a href="' . esc_url($settings_url) . '">Dashboard</a>');
            $links = array_merge($setting_arr, $links);
            return $links;
        }

        public function store_slots_admin_menu()
        {
            $icon_url = STORESLOTS_IMG_DIR . "storeslots_icon.png";
            add_menu_page("StoreSlots", "StoreSlots", 'manage_options', "storeslots", array($this, 'storeslots_admin_dashboard'), $icon_url, 6);
        }

        public function store_slots_admin_enqueue($page)
        {
            $screen = get_current_screen();

            if ( in_array( $screen->id, ["toplevel_page_storeslots", "shop_order"] ) ) {
                
                $this->utils->enqueue_style('flatpickr', 'flatpickr.min.css');
                $this->utils->enqueue_style('select2', 'select2.min.css');
                $this->utils->enqueue_style('toastr', 'toastr.min.css');
                $this->utils->enqueue_style('admin', 'admin.css');


                $this->utils->enqueue_script('flatpickr', 'flatpickr.js', array('jquery'),'',true);
                $this->utils->enqueue_script('select2', 'select2.min.js', array('jquery'));
                $this->utils->enqueue_script('toastr', 'toastr.min.js', array('jquery'));
                $this->utils->enqueue_script('admin', 'admin.js', array('jquery'), '', true);

                // create localize
                wp_localize_script( "store-slots-admin", 'storeslot_admin_object', array(
                    'ajaxurl'                => admin_url( 'admin-ajax.php' ),
                    'security'               => wp_create_nonce( 'storeslotsfnd_hashkey' ),
                    'storeslot_settings'     => !empty( $this->storeslot_settings) ? json_encode ( $this->storeslot_settings) : json_encode( array() ),
                    'delivery_dates'         => !empty( $this->delivery_dates) ? json_encode ( $this->delivery_dates) : json_encode( array() ),
                    'pickup_dates'           => !empty( $this->pickup_dates) ? json_encode ( $this->pickup_dates) : json_encode( array() ),

                ));
                
            }

        }


        public function storeslots_admin_dashboard()
        {
            include_once STORESLOTS_PATH . "backend/templates/dashboard.php";
        }

        public function storeslots_order_meta_boxes($post_type)
        {
            add_meta_box(
                'storeslots_metabox',
                __('Delivery Date & Time', 'store-slots'),
                [$this, 'storeslots_meta_box_markup'],
                'shop_order',
                'advanced',
                'high',
                null
            );
        }

        public function storeslots_meta_box_markup($post) {
            wp_nonce_field('storeslot_metabox', 'storeslot_metabox_nonce');

            $order_type     = get_post_meta($post->ID, 'delivery_type', true);
            $delivery_date  = get_post_meta($post->ID, 'storeslots_delivery_dates', true);
            $delivery_time  = get_post_meta($post->ID, 'storeslots_delivery_times', true);

            $pickup_date    = get_post_meta($post->ID, 'storeslots_pickup_dates', true);
            $pickup_time    = get_post_meta($post->ID, 'storeslots_pickup_times', true);

            ?>
                <div class="storeslot-wrapper">

                    <select class="storeslots-admin-ordertype-selection-box" name="storeslots_ordertype_selection_box" id="storeslots_admin_ordertype_selection_box" style="width:100%;">
                        <option value="">Please select order type</option>
                        <option <?php echo ( $order_type == 'storeslots_delivery' ) ? 'selected' : ''; ?> value="storeslots_delivery">Delivery</option>
                        <option <?php echo ( $order_type == 'storeslots_pickup' ) ? 'selected' : ''; ?> value="storeslots_pickup">Pickup</option>
                    </select>

                    <div id="storeslots_admin_delivery_date_time">
                        <input data-delivery_date="<?php echo $delivery_date; ?>" class="storeslots-admin-order-delivery-dates" name="storeslots_order_delivery_dates" id="storeslots_admin_order_delivery_dates" placeholder="Select delivery date" style="width:100%; margin-top:15px" />
                        
                        <select class="storeslots_select2 storeslots-admin-order-delivery-times" name="storeslots_order_delivery_times" id="storeslots_admin_order_delivery_times" style="width:100%; margin-top:15px">
                            <?php 
                                if( !empty( $this->delivery_times ) ){
                                    foreach( $this->delivery_times as $dtime ){ ?>
                                        <option <?php echo ($delivery_time == $dtime) ? 'selected' : ''; ?> value="<?php echo $dtime; ?>"><?php echo $dtime; ?></option>
                                   <?php }
                                }
                            ?>
                            
                        </select>
                    </div>

                    <div id="storeslots_admin_pickup_date_time" style="display:none;">
                        <input data-pickup_date="<?php echo $pickup_date; ?>" class="storeslots-admin-order-pickup-dates" name="storeslots_order_pickup_dates" id="storeslots_admin_order_pickup_dates" placeholder="Select pickup date" style="width:100%; margin-top:15px" />
                        
                        <select class="storeslots_select2 storeslots-admin-order-pickup-times" name="storeslots_order_pickup_times" id="storeslots_admin_order_pickup_times" style="width:100%; margin-top:15px">
                            <?php 
                                if( !empty( $this->pickup_times ) ){
                                    foreach( $this->pickup_times as $ptime ){ ?>
                                        <option <?php echo ($pickup_time == $ptime) ? 'selected' : ''; ?> value="<?php echo $ptime; ?>"><?php echo $ptime; ?></option>
                                   <?php }
                                }
                            ?>
                        </select>
                    </div>

                </div>

            <?php

        }

        public function storeslots_save_order_meta_boxes ( $post_id ) {

            if (!isset($_POST['storeslot_metabox_nonce'])) {
                return $post_id;
            }

            $nonce = $_POST['storeslot_metabox_nonce'];

            if (!wp_verify_nonce($nonce, 'storeslot_metabox')) {
                return $post_id;
            }

            if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
                return $post_id;
            }

            if ( !empty($_POST['storeslots_ordertype_selection_box']) ) {
                update_post_meta($post_id, 'delivery_type', $_POST['storeslots_ordertype_selection_box']);
            }

            if ( !empty($_POST['storeslots_order_delivery_dates']) ) {

                update_post_meta($post_id, 'storeslots_delivery_dates', sanitize_text_field($_POST['storeslots_order_delivery_dates']));
            }

            if ( !empty($_POST['storeslots_order_delivery_times']) ) {

                update_post_meta($post_id, 'storeslots_delivery_times', sanitize_text_field($_POST['storeslots_order_delivery_times']));
            }
            
            if ( !empty($_POST['storeslots_order_pickup_dates']) ) {

                update_post_meta($post_id, 'storeslots_pickup_dates', sanitize_text_field($_POST['storeslots_order_pickup_dates']));
            }

            if ( !empty($_POST['storeslots_order_pickup_times']) ) {

                update_post_meta($post_id, 'storeslots_pickup_times', sanitize_text_field($_POST['storeslots_order_pickup_times']));
            }
        }

    }
}


new StoreSlotsAdmin();
