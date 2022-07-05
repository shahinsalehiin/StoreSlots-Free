<?php

    check_ajax_referer( 'storeslotsfnd_hashkey', 'security' );

    $post_data  = array();
    $res_data   = array();

    if (isset($_REQUEST) && $_REQUEST['data']) {
        $post_data = $_REQUEST['data'];
    } else {
        $result = array("status" => 'false');
    }

    $res_data = $this->frontend_class->storeslots_get_customer_orders_count ($post_data);

    if (!empty($res_data)) {
        $result = array("status" => 'true', 'res_data' => $res_data);
    } else {
        $result = array("status" => 'false', 'res_data' => $res_data);
    }



echo json_encode ($result, JSON_UNESCAPED_UNICODE);