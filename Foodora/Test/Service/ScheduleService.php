<?php
namespace Foodora\Test\Service;

use \Foodora\Test\Data\ScheduleManager;
use \Foodora\Test\Data\SpecialDayManager;
use \Foodora\Test\Data\VendorManager;
use \Foodora\Test\Data\Model\Schedule;

class ScheduleService {

    private $scheduleManager;
    private $specialDayManager;
    private $vendorManager;

    public function __construct($appConfiguration) {

        $this->scheduleManager = new ScheduleManager($appConfiguration);
	$this->specialDayManager = new SpecialDayManager($appConfiguration);
	$this->vendorManager = new VendorManager($appConfiguration);
    }

    public function activateVendorSpecialDays($vendorId) {

	$this->scheduleManager->beginTransaction();
	foreach ($this->specialDayManager->findSpecialDays($vendorId) as $specialDay) {

	    $schedule = Schedule::fromSpecialDay($specialDay);

	    $this->scheduleManager->backupVendorSchedule($vendorId, $schedule->weekday);
	    $this->scheduleManager->deleteVendorSchedule($vendorId, $schedule->weekday);

	    if ($specialDay->isOpened()) {

	        $this->scheduleManager->addSchedule($schedule);
	    }
	}
	$this->scheduleManager->commitTransaction();
    }

    public function activateAllSpecialDays() {

	foreach($this->vendorManager->findAllVendors() as $vendor) {

	    $this->activateVendorSpecialDays($vendor->id);
	}
    }

    public function restoreVendorSpecialDays($vendorId) {

	$this->scheduleManager->beginTransaction();
	foreach ($this->specialDayManager->findSpecialDays($vendorId) as $specialDay) {

	    $schedule = Schedule::fromSpecialDay($specialDay);
	    $this->scheduleManager->deleteVendorSchedule($vendorId, $schedule->weekday);
        }

	$this->scheduleManager->restoreVendorSchedule($vendorId);
	$this->scheduleManager->deleteVendorBackupSchedule($vendorId);
	$this->scheduleManager->commitTransaction();
    }

    public function restoreAllSpecialDays() {

	foreach ($this->vendorManager->findAllVendors() as $vendor) {

	    $this->restoreVendorSpecialDays($vendor->id);
	}
    }
}

