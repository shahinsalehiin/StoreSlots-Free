
'use strict';
var $ = jQuery;

var $storeslotsFrontend = {
  storeslot_jaxurl        : storeslot_frontend_object.ajaxurl,
  storeslots_security     : storeslot_frontend_object.security,
  storeslot_settings      : JSON.parse(storeslot_frontend_object.storeslot_settings),
  delivery_dates          : JSON.parse(storeslot_frontend_object.delivery_dates),
  pickup_dates            : JSON.parse(storeslot_frontend_object.pickup_dates),

  init_storeslots_frontend: function () {

    jQuery(document).ready(function ($) {

      $('#storeslots_order_delivery_times').select2();
      $('#storeslots_order_pickup_times').select2();

      var $auto_select_ddate = ( $storeslotsFrontend.storeslot_settings.hasOwnProperty('ssd_enable_autoselect_first_date') ) ? 'yes' : 'no';
      var $auto_select_pdate = ( $storeslotsFrontend.storeslot_settings.hasOwnProperty('enable_pickup_autoselect_first_date') ) ? 'yes' : 'no';

      var $deliveryDateFormat = 'Y-m-d';
      var $pickupDateFormat = 'Y-m-d';

      // for delivery dates
      $("#storeslots_order_delivery_dates").flatpickr({
          altInput: true,
          altFormat: $deliveryDateFormat,
          dateFormat: "Y-m-d",
          enable: $storeslotsFrontend.delivery_dates,
          defaultDate: ($auto_select_ddate == 'yes') ? $storeslotsFrontend.delivery_dates[0] : [''],
          "locale": {
            "firstDayOfWeek": 0  // start week on Monday
          },
      });

      //for pickup dates
      $('#storeslots_order_pickup_dates').flatpickr({
          altInput: true,
          altFormat: $pickupDateFormat,
          dateFormat: "Y-m-d",
          enable: $storeslotsFrontend.pickup_dates,
          defaultDate: ($auto_select_pdate == 'yes') ? $storeslotsFrontend.pickup_dates[0] : [''],
          "locale": {
            "firstDayOfWeek": 0  // start week on Monday 
          },
      });

    });


    //init local obj here...
    $storeslotsFrontend.toggle_delivery_date_time();

    $storeslotsFrontend.storeslots_get_customer_delivery_total_orders();
    $storeslotsFrontend.storeslots_get_customer_pickup_total_orders();

  },

  toggle_delivery_date_time : function(){
    
    $('#storeslots_ordertype_selection_box').on('change', function(){

      let $this = $(this);
      let $type = $this.val();

      if( $type == 'storeslots_delivery' ){
          var $delivery_date = $('#storeslots_order_delivery_dates').val();
          if( $delivery_date ){
            $('#storeslots_order_delivery_dates').trigger("change");
          }
          $('#storeslots_checkout_pickup_date_time').fadeOut('slow');
          $('#storeslots_checkout_delivery_date_time').fadeIn('slow');
      }else if( $type == 'storeslots_pickup' ){
          var $pickup_date = $('#storeslots_order_pickup_dates').val();
          if( $pickup_date ){
            $('#storeslots_order_pickup_dates').trigger("change");
          }
          $('#storeslots_checkout_delivery_date_time').fadeOut('slow');
          $('#storeslots_checkout_pickup_date_time').fadeIn('slow');
      }else{
          var $delivery_date = $('#storeslots_order_delivery_dates').val();
          if( $delivery_date ){
            $('#storeslots_order_delivery_dates').trigger("change");
          }
          $('#storeslots_checkout_delivery_date_time').hide();
          $('#storeslots_checkout_pickup_date_time').hide();
      }
      
    });
      
  },

  // define delivery order total
  storeslots_get_customer_delivery_total_orders : function(){
      $('#storeslots_order_delivery_dates').on('change', function(){

          var $selected_date = new Date($('#storeslots_order_delivery_dates').val());
          var $getselected_date = $selected_date.getFullYear() + '-' + ($selected_date.getMonth() + 1 ) + '-' + $selected_date.getDate();
          
          var $data = {
            'request_date'  : $getselected_date,
            'ordertype'     : $('#storeslots_ordertype_selection_box').val()
          };

          let $post_data = {'action': 'storeslots_get_customer_total_order', 'security': $storeslotsFrontend.storeslots_security, 'data': $data};

          $.ajax({
              url: $storeslotsFrontend.storeslot_jaxurl,
              type: "POST",
              data: $post_data,
              success: function(res){
                  var $obj = JSON.parse(res);
                  if ($obj.status == 'true') {
                    $storeslotsFrontend.storeslots_manage_time_slots('delivery', $getselected_date, $obj.res_data);
                  }
              }
          });
      });

  },

  // define pickup order totals
  storeslots_get_customer_pickup_total_orders : function(){
    $('#storeslots_order_pickup_dates').on('change', function(){

      var $selected_date = new Date($('#storeslots_order_pickup_dates').val());
      var $getselected_date = $selected_date.getFullYear() + '-' + ($selected_date.getMonth() + 1 ) + '-' + $selected_date.getDate();
      var $data = {
        'request_date' : $getselected_date,
        'ordertype' : $('#storeslots_ordertype_selection_box').val()
      };
        let $post_data = {'action': 'storeslots_get_customer_total_order', 'security': $storeslotsFrontend.storeslots_security, 'data': $data};

        $.ajax({
            url: $storeslotsFrontend.storeslot_jaxurl,
            type: "POST",
            data: $post_data,
            success: function(res){
                var $obj = JSON.parse(res);
                if ($obj.status == 'true') {
                  $storeslotsFrontend.storeslots_manage_time_slots('pickup', $getselected_date, $obj.res_data);
                }
            }
        });
    });

  },

  storeslots_manage_time_slots : function($type='delivery', $getselected_date, response){
      
      var $date = new Date(); 
      var $todate = $date.getFullYear() + '-' + ($date.getMonth() + 1 ) + '-' + $date.getDate();

      var $current_time = $storeslotsFrontend.stotSlotsTimeFormatInternational($date);  
      var $get_current_time = (new Date($todate +" " +$current_time).getTime()/1000);
      var $count_result = Object.entries(response.result).map(([key, value]) => ({key,value}));

      $("#storeslots_order_"+$type+"_times option").each(function($k, $v){
          var $thisOptionValue = $(this).val();
          var $optionVal = $thisOptionValue.split('-')[1];

          if( $getselected_date == $todate){

            var $getSlotTime = (new Date($todate +" " + $optionVal).getTime()/1000);
            
            if( $get_current_time > $getSlotTime ){

              $(this).prop('disabled', true);

            }

          }else{

            $(this).prop('disabled', false);

          }
          
      });
  },

  stotSlotsTimeFormatAMPM : function(date) {
    var hours = date.getHours();
    var minutes = date.getMinutes();
    var ampm = hours >= 12 ? 'PM' : 'AM';
    hours = hours % 12;
    hours = hours ? hours : 12; // the hour '0' should be '12'
    var thour = hours < 10 ? '0'+hours : hours;
    minutes = minutes < 10 ? '0'+minutes : minutes;
    var strTime = thour + ':' + minutes + ' ' + ampm;
    return strTime;
  },
  
  stotSlotsTimeFormatInternational : function(date) {
    var hours = date.getHours();
    var minutes = date.getMinutes();
    var thour = hours < 10 ? '0'+hours : hours;
    minutes = minutes < 10 ? '0'+minutes : minutes;
    var strTime = thour + ':' + minutes;
    return strTime;
  }


};

//load js for backend
$storeslotsFrontend.init_storeslots_frontend();
