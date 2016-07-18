<?php
namespace Foodora\Test\Data\Model;

class SpecialDay {

    public $id;
    public $vendor_id;
    public $special_date;
    public $event_type;
    public $all_day;
    public $start_hour;
    public $stop_hour;

    public function isOpened() {

	return $this->event_type == 'opened';
    }
}

