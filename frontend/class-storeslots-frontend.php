<?php
// If this file is called directly, abort.
if (!defined ('WPINC')) {
    die;
}

if (!class_exists ('StoreSlotsFrontend')) {
    class StoreSlotsFrontend {

        public $utils;
        public $storeslot_settings = array();
        public $delivery_dates = array();
        public $pickup_dates = array();
        public $delivery_times = array();
        public $pickup_times = array();

        public function __construct (){
            $this->utils = new StoreSlotsUtils();
            
            new StoreSlotsFrontendAjax($this);
            add_action ('wp_enqueue_scripts', array($this, 'store_slots_frontend_enqueue'));
            add_action('woocommerce_after_order_notes', array($this, 'storeslots_add_custom_field'));
            add_action('woocommerce_checkout_process', array($this, 'storeslots_checkout_field_process'));
            add_action('woocommerce_checkout_update_order_meta', array( $this,'storeslots_checkout_field_update_order_meta'));

            $this->storeslot_settings   = get_option('storeslot_settings', false);
            $this->delivery_dates       = get_option('storeslot_delivery_dates', false);
            $this->pickup_dates         = get_option('storeslot_pickup_dates', false);
            $this->delivery_times       = get_option('storeslots_delivery_times', false);
            $this->pickup_times         = get_option('storeslots_pickup_times', false);

        }

        public function store_slots_frontend_enqueue ($page) {           
            $this->utils->enqueue_style('flatpickr', 'flatpickr.min.css');
            //$this->utils->enqueue_style('select2', 'select2.min.css');
            $this->utils->enqueue_style('frontend', 'frontend.css');

          
            $this->utils->enqueue_script('flatpickr', 'flatpickr.js', array('jquery'),'',true);
            $this->utils->enqueue_script('select2', 'select2.min.js', array('jquery'),'',true);
            $this->utils->enqueue_script('frontend', 'frontend.js', array('jquery'),'',true);

            // create localize
            wp_localize_script( "store-slots-frontend", 'storeslot_frontend_object', array(
                'ajaxurl' => admin_url( 'admin-ajax.php' ),
                'security' => wp_create_nonce( 'storeslotsfnd_hashkey' ),
                'storeslot_settings' => !empty( $this->storeslot_settings) ? json_encode ( $this->storeslot_settings) : json_encode( array() ),
                'delivery_dates' => !empty( $this->delivery_dates) ? json_encode ( $this->delivery_dates) : json_encode( array() ),
                'pickup_dates' => !empty( $this->pickup_dates) ? json_encode ( $this->pickup_dates) : json_encode( array() ),
            ));

        }

        public function storeslots_add_custom_field($checkout){

            $order_type_label = 'Order Type';
            $order_type_delivery = 'Delivery';
            $order_type_pickup = 'Pickup';
            $delivery_date_label = 'Delivery Date';
            $delivery_time_label = 'Delivery Time';
            $pickup_delivery_label = 'Pickup Time';
            $pickup_time_label = 'Pickup Time';

            if( isset($this->storeslot_settings['storeslots_enable_delivery_or_pickup']) && $this->storeslot_settings['storeslots_enable_delivery_or_pickup'] == 'yes' ){
                echo '<div id="storeslots_checkout_field">';

                woocommerce_form_field(
                    'storeslots_ordertype_selection_box',
                    array(
                        'type' => 'select',
                        'class' => array(
                            'storeslots_ordertype_selection_box'
                        ),
                        'label' => __($order_type_label, 'store-slots'),
                        'placeholder' => __('Order Type', 'store-slots'),
                        
                        'options' => array(
                            '' => __('Choose Order type'),
                            'storeslots_delivery' => __($order_type_delivery, 'store-slots'),
                            'storeslots_pickup' => __($order_type_pickup, 'store-slots')
                        ),

                        'required' => true,
                    ),
                    $checkout->get_value('storeslots_ordertype_selection_box')
                );

                echo '</div>';

            // for delivery dates & times
            echo '<div id="storeslots_checkout_delivery_date_time" style="display:none;">';

                if( isset( $this->storeslot_settings['storeslots_enable_delivery_date'] ) && $this->storeslot_settings['storeslots_enable_delivery_date'] == 'yes' ){
                    woocommerce_form_field(
                        'storeslots_order_delivery_dates',
                        array(
                            'type' => 'text',
                            'class' => array(
                                'storeslots-order-delivery-dates'
                            ),
                            'label' => __( $delivery_date_label, 'store-slots'),
                            'placeholder' => __('Delivery Date', 'store-slots'),
                            'required' => true,
                        ),
                        $checkout->get_value('storeslots_order_delivery_dates')
                    );
                }

                if( isset( $this->storeslot_settings['storeslots_enable_delivery_time'] ) && $this->storeslot_settings['storeslots_enable_delivery_time'] == 'yes' ){
                    woocommerce_form_field(
                        'storeslots_order_delivery_times',
                        array(
                            'type' => 'select',
                            'class' => array(
                                'storeslots-order-delivery-times'
                            ),
                            'label' => __($delivery_time_label, 'store-slots'),
                            'placeholder' => __('Delivery Time', 'store-slots'),
                            'options' => $this->delivery_times,
                            'required' => true,
                        ),
                        $checkout->get_value('storeslots_order_delivery_times')
                    );
                }

            echo '</div>';

            // for pickup dates & times
            echo '<div id="storeslots_checkout_pickup_date_time" style="display:none;">';
                if( isset( $this->storeslot_settings['storeslots_enable_pickup_date'] ) && $this->storeslot_settings['storeslots_enable_pickup_date'] == 'yes' ){
                    woocommerce_form_field(
                        'storeslots_order_pickup_dates',
                        array(
                            'type' => 'text',
                            'class' => array(
                                'storeslots-order-pickup-dates'
                            ),
                            'label' => __($pickup_delivery_label, 'store-slots'),
                            'placeholder' => __('Pickup Date', 'store-slots'),
                            'required' => true,
                        ),
                        $checkout->get_value('storeslots_order_pickup_dates')
                    );
                }
                
                if( isset( $this->storeslot_settings['storeslots_enable_pickup_time'] ) && $this->storeslot_settings['storeslots_enable_pickup_time'] == 'yes' ){
                    woocommerce_form_field(
                        'storeslots_order_pickup_times',
                        array(
                            'type' => 'select',
                            'class' => array(
                                'storeslots-order-pickup-times'
                            ),
                            'label' => __($pickup_time_label, 'store-slots'),
                            'placeholder' => __('Pickup Time', 'store-slots'),
    
                            'options' => $this->pickup_times,
    
                            'required' => true,
                        ),
                        $checkout->get_value('storeslots_order_pickup_times')
                    );
                }
                

            echo '</div>';

            }else{
               
                echo '<div id="storeslots_checkout_delivery_date_time">';
                    if( isset( $this->storeslot_settings['storeslots_enable_delivery_date'] ) && $this->storeslot_settings['storeslots_enable_delivery_date'] == 'yes' ){
                        woocommerce_form_field(
                            'storeslots_order_delivery_dates',
                            array(
                                'type' => 'text',
                                'class' => array(
                                    'storeslots-order-delivery-dates'
                                ),
                                'label' => __($delivery_date_label, 'store-slots'),
                                'placeholder' => __('Delivery Date', 'store-slots'),
                                'required' => true,
                            ),
                            $checkout->get_value('storeslots_order_delivery_dates')
                        );
                    }

                    if( isset( $this->storeslot_settings['storeslots_enable_delivery_time'] ) && $this->storeslot_settings['storeslots_enable_delivery_time'] == 'yes' ){
                        woocommerce_form_field(
                            'storeslots_order_delivery_times',
                            array(
                                'type' => 'select',
                                'class' => array(
                                    'storeslots-order-delivery-times'
                                ),
                                'label' => __($delivery_time_label, 'store-slots'),
                                'placeholder' => __('Delivery Time', 'store-slots'),

                                'options' => $this->delivery_times,

                                'required' => true,
                            ),
                            $checkout->get_value('storeslots_order_delivery_times')
                        );
                    }

                echo '</div>';
                
            }
                

        }

        public function storeslots_checkout_field_process(){
            // Show an error message if the field is not set.
            if (!$_POST['storeslots_ordertype_selection_box']) wc_add_notice(__('Please enter value!'), 'error');

            if (!empty($_POST['storeslots_ordertype_selection_box']) && $_POST['storeslots_ordertype_selection_box'] == 'storeslots_delivery') {
                
                if (!$_POST['storeslots_order_delivery_dates']) wc_add_notice(__('Please enter delivery date value!'), 'error');
                if (!$_POST['storeslots_order_delivery_times']) wc_add_notice(__('Please enter delivery time value!'), 'error');
            
            }else if(!empty($_POST['storeslots_ordertype_selection_box']) && $_POST['storeslots_ordertype_selection_box'] == 'storeslots_pickup') {
                
                if (!$_POST['storeslots_order_pickup_dates']) wc_add_notice(__('Please enter pickup date value!'), 'error');
                if (!$_POST['storeslots_order_pickup_times']) wc_add_notice(__('Please enter pickup time value!'), 'error');
            
            }else{
                
                if (!$_POST['storeslots_order_delivery_dates']) wc_add_notice(__('Please enter delivery date value!'), 'error');
                if (!$_POST['storeslots_order_delivery_times']) wc_add_notice(__('Please enter delivery time value!'), 'error');

            }
            
        }

        public function storeslots_checkout_field_update_order_meta( $order_id ){
            $order_type_val = '';

            if (!empty($_POST['storeslots_ordertype_selection_box'])) {
                
                update_post_meta($order_id, 'delivery_type', sanitize_text_field($_POST['storeslots_ordertype_selection_box']));
            }

            if (!empty($_POST['storeslots_order_delivery_dates'])) {

                update_post_meta($order_id, 'storeslots_delivery_dates', sanitize_text_field($_POST['storeslots_order_delivery_dates']));
            }

            if (!empty($_POST['storeslots_order_delivery_times'])) {

                update_post_meta($order_id, 'storeslots_delivery_times', sanitize_text_field($_POST['storeslots_order_delivery_times']));
            }
            
            if (!empty($_POST['storeslots_order_pickup_dates'])) {

                update_post_meta($order_id, 'storeslots_pickup_dates', sanitize_text_field($_POST['storeslots_order_pickup_dates']));
            }

            if (!empty($_POST['storeslots_order_pickup_times'])) {

                update_post_meta($order_id, 'storeslots_pickup_times', sanitize_text_field($_POST['storeslots_order_pickup_times']));
            }


        }

        /**
         * define get customer total orders
         * @param $data[]
         * 
         */
        public function storeslots_get_customer_orders_count($data = []) {

            $result = [];
            $request_date    = ( !empty($data) && isset($data['request_date']) ) ? date('Y-m-d', strtotime( $data['request_date'] )): date('Y-m-d');
            $meta_key_date   = ( !empty($data) && isset($data['ordertype']) && $data['ordertype'] == 'storeslots_pickup' ) ? 'storeslots_pickup_dates' : 'storeslots_delivery_dates' ;
            $meta_key_type   = ( !empty($data) && isset($data['ordertype']) ) ? $data['ordertype'] : 'storeslots_delivery';

            $customer_orders = get_posts( 
                array(
                    'numberposts' => - 1,
                    'post_type'   => array( 'shop_order' ),
                    'post_status' => array( 'wc-processing' ),

                    'meta_query' => array(
                        'relation' => 'AND',
                        array(
                            'compare' => '=',
                            'key'     => $meta_key_date,
                            'value'   => $request_date
                        ),
                        array(
                            'compare' => '=',
                            'key'     => 'delivery_type',
                            'value'   => $meta_key_type
                        )
                    ),

                ) 
            );
        
            $order_count = array();
            $i = 0;        
            foreach ( $customer_orders as $customer_order ) { $i++;
                $order      = wc_get_order( $customer_order );
                $order_time = ($meta_key_type == 'storeslots_pickup') ? $order->get_meta('storeslots_pickup_times') : $order->get_meta('storeslots_delivery_times');

                if( !empty( $order_time ) ){
                    $order_count[$i] = $order_time;
                }
                
            }

            $result = array_count_values(array_map(function($item) {
                return $item;
            }, $order_count));

            return [ 'result' => $result ];

        }


    }
}

new StoreSlotsFrontend();