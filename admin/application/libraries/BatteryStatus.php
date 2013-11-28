<?php
/**
 * BatteryStatus handles incoming notifications about battery statuses
 * for different devices and takes appropriate actions
 */

class BatteryStatus {


    /**
     * @param RedBean_OODBBean $device
     * @param int $low_battery
     */
    public function update_device(RedBean_OODBBean $device, $low_battery)
    {
        throw new Exception('Device ' . $device->name . ' battery status is: ' . $low_battery);
    }

} 