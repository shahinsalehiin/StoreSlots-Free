'use strict';
var $ = jQuery;

var $storeslotsAdmin = {
    storeslot_settings_form : "#storeslots_settings_form",
    storeslots_switchers    : ".storeslots_default_checked",
    storeslot_settings      : JSON.parse(storeslot_admin_object.storeslot_settings),
    delivery_dates          : JSON.parse(storeslot_admin_object.delivery_dates),
    pickup_dates            : JSON.parse(storeslot_admin_object.pickup_dates),
    
    init_storeslots_admin: function(){

        jQuery(document).ready(function($) {

            $storeslotsAdmin.storeslots_handle_switcher();

            let $defaultDeliveryDate = $('#storeslots_admin_order_delivery_dates').attr('data-delivery_date');
            let $defaultPickupDate = $('#storeslots_admin_order_pickup_dates').attr('data-pickup_date');

            var $ssa_auto_select_addate = ( $storeslotsAdmin.storeslot_settings.hasOwnProperty('ssd_enable_autoselect_first_date') ) ? 'yes' : 'no';
            var $ssa_auto_select_apdate = ( $storeslotsAdmin.storeslot_settings.hasOwnProperty('enable_pickup_autoselect_first_date') ) ? 'yes' : 'no';

            var $ssaDeliveryDateFormat = 'Y-m-d';
            var $ssapickupDateFormat = 'Y-m-d';
            
            //console.log( 'delivery_dates ', $storeslotsAdmin.delivery_dates );

            $('.storeslots_select2').select2();

            // toaster configuration
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };
            
            $(".storeslots_right_content .storeslots_tab_body").hide();
            $(".storeslots_right_content .storeslots_tab_body[data-id='order_settings']").show();

            $(".storeslots_data_tabs .tab_item").unbind("click");
            $(".storeslots_data_tabs .tab_item").bind("click", function () {

                $(".storeslots_data_tabs .tab_item").removeClass('tab_item_active');
                $(this).addClass('tab_item_active');

                $(".storeslots_right_content .storeslots_tab_body").hide();
                $(".storeslots_right_content .storeslots_tab_body[data-id='" + $(this).data('target') + "']").show();
            });


            // for dashboard delivery dates
            $("#storeslots_admin_order_delivery_dates").flatpickr({
                altInput: true,
                altFormat: $ssaDeliveryDateFormat,
                dateFormat: "Y-m-d",
                //enable: $storeslotsAdmin.delivery_dates,
                defaultDate: ($defaultDeliveryDate) ? $defaultDeliveryDate : (($ssa_auto_select_addate == 'yes') ? $storeslotsAdmin.delivery_dates[0] : ['']),
                "locale": {
                "firstDayOfWeek": 0  // start week on Monday 
                },
            });

            //for dashboard pickup dates
            $('#storeslots_admin_order_pickup_dates').flatpickr({
                altInput: true,
                altFormat: $ssapickupDateFormat,
                dateFormat: "Y-m-d",
                //enable: $storeslotsAdmin.pickup_dates,
                defaultDate: ($defaultPickupDate) ? $defaultPickupDate : (($ssa_auto_select_apdate == 'yes') ? $storeslotsFrontend.pickup_dates[0] : ['']),
                "locale": {
                "firstDayOfWeek": 0  // start week on Monday 
                },
            });


            // submit One click checkout setting form
            $($storeslotsAdmin.storeslot_settings_form).on( 'submit', function(e){
                $storeslotsAdmin.submit_storeslot_settings(e);
            });

            // trigger
            if( $('#storeslots_admin_ordertype_selection_box').val() ){
                $('#storeslots_admin_ordertype_selection_box').trigger("change");
            }
                               
        });

        //init local admin object here...
        $storeslotsAdmin.toggle_ssa_delivery_date_time();

    },

    //handle switcher
    storeslots_handle_switcher : function(){
        if( $storeslotsAdmin.storeslot_settings.length <= 0 ){
            $($storeslotsAdmin.storeslots_switchers).prop('checked', true);
        }
    },

    // submit settings from
    submit_storeslot_settings : function (e) {
        e.preventDefault();
        let $submit_button = $('.storeslots-btn');
        $submit_button.text( 'Please Wait....' );
        $submit_button.addClass( '.storefusion-fcss-btn-disabled' );
        $submit_button.prop( 'disabled', true );

        let $post_data = {'action': 'storeslot_save_settings', 'data': $($storeslotsAdmin.storeslot_settings_form).serializeArray()};

        $.ajax({
            url: ajaxurl,
            type: "POST",
            data: $post_data,
            success: function(res){
                var $obj = JSON.parse(res);
                if ($obj.status == 'true') {
                    Command: toastr["success"]("Settings Saved Successfully!");
                    $submit_button.text('Save Settings');
                    $submit_button.removeClass('.storefusion-fcss-btn-disabled');
                    $submit_button.prop('disabled', false);
                }else{
                    Command: toastr["error"]("Failed, Please try again!");
                    $submit_button.text('Save Settings');
                    $submit_button.removeClass('.storefusion-fcss-btn-disabled');
                    $submit_button.prop('disabled', false);
                    console.log('Oops: something is wrong please try later!');
                }
            }
        });
    },

    toggle_ssa_delivery_date_time : function(){

        $('#storeslots_admin_ordertype_selection_box').on('change', function(){

            let $this = $(this);
            let $type = $this.val();
      
            if( $type == 'storeslots_delivery' ){
                var $delivery_date = $('#storeslots_order_delivery_dates').val();
                if( $delivery_date ){
                  //$('#storeslots_order_delivery_dates').trigger("change");
                }
                $('#storeslots_admin_pickup_date_time').fadeOut('slow');
                $('#storeslots_admin_delivery_date_time').fadeIn('slow');
            }else if( $type == 'storeslots_pickup' ){
                var $pickup_date = $('#storeslots_order_pickup_dates').val();
                if( $pickup_date ){
                  //$('#storeslots_order_pickup_dates').trigger("change");
                }
                $('#storeslots_admin_delivery_date_time').fadeOut('slow');
                $('#storeslots_admin_pickup_date_time').fadeIn('slow');
            }else{
                var $delivery_date = $('#storeslots_order_delivery_dates').val();
                if( $delivery_date ){
                  //$('#storeslots_order_delivery_dates').trigger("change");
                }
                $('#storeslots_admin_delivery_date_time').hide();
                $('#storeslots_admin_pickup_date_time').hide();
            }
            
          });

    },

};

//load js for backend
$storeslotsAdmin. init_storeslots_admin();