<div class="tab_body_title">
    <h1><?php echo __('Delivery Date Settings', 'store-slots'); ?></h1>
</div>

<div class="storeslots_form_group">
    <div class="label_title">
        <h4><?php echo __('Delivery Date Label', 'store-slots'); ?><span class="storeslots_get_pro">(Pro)</span></h4>
    </div>

    <div class="label_content ">
        <div class="storeslots_list_items">
            <div class="storeslots_item">
                <input class="storeslots_text_control h50" type="text" id="storeslots_delivery_date_label" readonly>
            </div>
            <small class="storeslots-hints"><?php __('Delivery date input field.', 'store-slots'); ?></small>
        </div>
    </div>
</div>

<div class="storeslots_form_group">
    <div class="label_title">
        <h4><?php echo __('Delivery in Next Available Days', 'store-slots'); ?></h4>
    </div>

    <div class="label_content ">
        <div class="storeslots_list_items">
            <div class="storeslots_item">
                <input class="storeslots_text_control h50" type="number" name="ssd_available_days"
                    id="storeslots_delivery_available_days"
                    value="<?php echo !empty($this->storeslot_settings) && !empty($this->storeslot_settings['ssd_available_days']) ? esc_attr($this->storeslot_settings['ssd_available_days']) : ''; ?>"
                    placeholder="">
            </div>
            <small
                class="storeslots-hints"><?php echo __('User can specify next available days.', 'store-slots'); ?></small>
        </div>
    </div>
</div>


<div class="storeslots_form_group">
    <div class="label_title">
        <h4><?php echo __('Week Starts From', 'store-slots'); ?><span class="storeslots_get_pro">(Pro)</span></h4>
    </div>

    <div class="label_content ">
        <div class="storeslots_list_items">
            <div class="storeslots_item">

                <select class="storeslots_select_control storeslots_select2">
                    <option value="" disabled>Select Day</option>
                    <option value="" disabled>Saturday</option>
                    <option value="" selected disabled>Sunday</option>
                    <option value="" disabled>Monday</option>
                    <option value="" disabled>Tuesday</option>
                    <option value="" disabled>Wednesday</option>
                    <option value="" disabled>Thursday</option>
                    <option value="" disabled>Friday</option>
                </select>
            </div>
        </div>
        <small> <?php echo __('Delivery dates will be start from the day that is selected.', 'store-slots');?></small>
    </div>
</div>

<div class="storeslots_form_group">
    <div class="label_title">
        <h4><?php echo __('Delivery Date Format', 'store-slots'); ?><span class="storeslots_get_pro">(Pro)</span></h4>
    </div>

    <div class="label_content ">
        <div class="storeslots_list_items">
            <div class="storeslots_item">
                
                <select id="ssd_date_formet" class="storeslots_select_control storeslots_select2">
                    <option disabled>Select Date format</option>
                    <option selected disabled>Y-m-d ( ex. <?php echo date( 'Y-m-d' ); ?> )</option>
                    <option disabled>F j, Y ( ex. <?php echo date( 'F j, Y' ); ?> )</option>
                    <option disabled>d-m-Y (ex. <?php echo date( 'd-m-y' ); ?> )</option>
                    <option disabled>m/d/Y (ex. <?php echo date( 'm/d/Y' ); ?> )</option>
                    <option disabled>d.m.Y (ex. <?php echo date( 'd.m.Y' ); ?> )</option>
                </select>
            </div>
        </div>
        <small><?php echo __('Select delivery date format.', 'store-slots'); ?></small>
    </div>
</div>

<div class="storeslots_form_group">
    <div class="label_title">
        <h4><?php echo __('Auto Select 1st Available Date ?', 'store-slots'); ?></h4>
    </div>

    <div class="label_content ">
        <div class="storeslots_list_items">
            <div class="storeslots_item">
                <label class="toggle_switch">
                    <input id="storeslots_enable_autoselect_first_date" class=""
                        name="ssd_enable_autoselect_first_date" type="checkbox" value="yes"
                        <?php echo !empty($this->storeslot_settings) && isset($this->storeslot_settings['ssd_enable_autoselect_first_date']) ? esc_attr('checked') : ''; ?>>
                    <span class="slider round"></span>
                </label>
            </div>
            <small
                class="storeslots-hints"><?php echo __('Enable the option if you want to select the first available date.', 'store-slots');?></small>
        </div>
    </div>
</div>

<div class="storeslots_form_group">
    <div class="label_title">
        <h4><?php echo __('Delivery Days ?', 'store-slots'); ?></h4>
    </div>

    <div class="label_content ">
        <div class="storeslots_list_items">
            <div class="storeslots_item">
                <?php                                                                                 
                    $storeslots_delivery_days = !empty($this->storeslot_settings) && !empty($this->storeslot_settings['storeslots_delivery_days']) ? explode(',', esc_attr($this->storeslot_settings['storeslots_delivery_days'])) : array();
                ?>
                <div class="delivery_days_wrapper">
                    <input type="checkbox" name="storeslots_delivery_days" value="saturday"
                        <?php echo (!empty($storeslots_delivery_days) && in_array('saturday', $storeslots_delivery_days)) ? 'checked' : ''; ?>>
                    <label class="storeslots_delivery_days_label">Saturday</label><br>
                    <input type="checkbox" name="storeslots_delivery_days" value="sunday"
                        <?php echo (!empty($storeslots_delivery_days) && in_array('sunday', $storeslots_delivery_days)) ? 'checked' : ''; ?>>
                    <label class="storeslots_delivery_days_label">Sunday</label><br>
                    <input type="checkbox" name="storeslots_delivery_days" value="monday"
                        <?php echo (!empty($storeslots_delivery_days) && in_array('monday', $storeslots_delivery_days)) ? 'checked' : ''; ?>>
                    <label class="storeslots_delivery_days_label">Monday</label><br>
                    <input type="checkbox" name="storeslots_delivery_days" value="tuesday"
                        <?php echo (!empty($storeslots_delivery_days) && in_array('tuesday', $storeslots_delivery_days)) ? 'checked' : ''; ?>>
                    <label class="storeslots_delivery_days_label">Tuesday</label><br>
                    <input type="checkbox" name="storeslots_delivery_days" value="wednesday"
                        <?php echo (!empty($storeslots_delivery_days) && in_array('wednesday', $storeslots_delivery_days)) ? 'checked' : ''; ?>>
                    <label class="storeslots_delivery_days_label">Wednesday</label><br>
                    <input type="checkbox" name="storeslots_delivery_days" value="thursday"
                        <?php echo (!empty($storeslots_delivery_days) && in_array('thursday', $storeslots_delivery_days)) ? 'checked' : ''; ?>>
                    <label class="storeslots_delivery_days_label">Thursday</label><br>
                    <input type="checkbox" name="storeslots_delivery_days" value="friday"
                        <?php echo (!empty($storeslots_delivery_days) && in_array('friday', $storeslots_delivery_days)) ? 'checked' : ''; ?>>
                    <label class="storeslots_delivery_days_label">Friday</label><br>
                </div>
            </div>

            <small
                class="storeslots-hints"><?php echo __('Delivery is only available in those days that are checked.', 'store-slots'); ?></small>
        </div>
    </div>
</div>