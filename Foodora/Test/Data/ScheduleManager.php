<?php
namespace Foodora\Test\Data;

use \PDO;

class ScheduleManager extends DataManager {

    public function backupVendorSchedule($vendorId, $weekday) {

	$stmt = $this->pdo()->prepare(
	    'INSERT INTO vendor_schedule_backup (vendor_id, weekday, all_day, start_hour, stop_hour) '
	    . 'SELECT vendor_id, weekday, all_day, start_hour, stop_hour FROM vendor_schedule WHERE vendor_id = :vendorId AND weekday = :weekday'
	);
	$stmt->bindValue(':vendorId', $vendorId);
	$stmt->bindValue(':weekday', $weekday);
	if (!$stmt->execute()) {

	    $this->dberror($stmt->errorInfo(), "Can't backup vendor schedule");
	}
    }

    public function restoreVendorSchedule($vendorId) {

	$stmt = $this->pdo()->prepare(
	    'INSERT INTO vendor_schedule (vendor_id, weekday, all_day, start_hour, stop_hour) '
	    . 'SELECT vendor_id, weekday, all_day, start_hour, stop_hour FROM vendor_schedule_backup WHERE vendor_id = :vendorId'
	);
	$stmt->bindValue(':vendorId', $vendorId);
	if (!$stmt->execute()) {

	    $this->dberror($stmt->errorInfo(), "Can't restore vendor schedule");
	}
    }

    public function deleteVendorSchedule($vendorId, $weekday) {

	$stmt = $this->pdo()->prepare('DELETE FROM vendor_schedule WHERE vendor_id = :vendorId AND weekday = :weekday');
	$stmt->bindValue(':vendorId', $vendorId);
	$stmt->bindValue(':weekday', $weekday);
	if (!$stmt->execute()) {

	    $this->dberror($stmt->errorInfo(), "Can't delete vendor schedule");
	}
    }

    public function deleteVendorBackupSchedule($vendorId) {

	$stmt = $this->pdo()->prepare('DELETE FROM vendor_schedule_backup WHERE vendor_id = :vendorId');
	$stmt->bindValue(':vendorId', $vendorId);
	if (!$stmt->execute()) {

	    $this->dberror($stmt->errorInfo(), "Can't delete vendor backup schedule");
	}
    }

    public function addSchedule($schedule) {

        $stmt = $this->pdo()->prepare(
	    'INSERT INTO vendor_schedule (vendor_id, weekday, all_day, start_hour, stop_hour) '
	    . 'VALUES (:vendorId, :weekday, :allDay, :startHour, :stopHour)'
	);
	$stmt->bindValue(':vendorId', $schedule->vendor_id);
	$stmt->bindValue(':weekday', $schedule->weekday);
	$stmt->bindValue(':allDay', $schedule->all_day);
	$stmt->bindValue(':startHour', $schedule->start_hour);
	$stmt->bindValue(':stopHour', $schedule->stop_hour);
	if (!$stmt->execute()) {

	    $this->dberror($stmt->errorInfo(), 'Could not add schedule for vendor');
	}
    }
}
