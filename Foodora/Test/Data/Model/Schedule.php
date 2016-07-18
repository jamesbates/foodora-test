<?php
namespace Foodora\Test\Data\Model;

class Schedule {

    public $id;
    public $vendor_id;
    public $weekday;
    public $all_day;
    public $start_hour;
    public $stop_hour;

    public static function fromSpecialDay($specialDay) {

	$result = new Schedule();
	$result->vendor_id = $specialDay->vendor_id;
	$result->weekday = date('N', strtotime($specialDay->special_date));
	$result->all_day = $specialDay->all_day;
	$result->start_hour = $specialDay->start_hour;
	$result->stop_hour = $specialDay->stop_hour;

	return $result;
    }
}

