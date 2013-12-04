<?php
/**
 * BatteryStatus handles incoming notifications about battery statuses
 * for different devices and takes appropriate actions
 *
 * @property Notify_model $notify_model
 */

class BatteryStatus {

    /**
     * @param RedBean_OODBBean $device
     * @param int $low_battery
     */
    public function update_device(RedBean_OODBBean $device, $low_battery)
    {
        $ref = 'BATTERY.LOW.' . $device->id;

        $CI =& get_instance();
        $CI->load->model('notify_model');

        if ($low_battery) {
            $message = "Battery status for device '{$device->name}' ({$device->location}) is low";
            $CI->notify_model->create(array(
                'content' => $message,
                'ref' => $ref,
                'account_id' => $device->account_id,
                'email_frequency' => 'weekly'
            ));

        } else {
            // remove any low battery status for this device
            $CI->notify_model->remove_by_ref($ref, $device->account_id);
        }
    }

} 