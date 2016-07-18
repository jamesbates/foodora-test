<?php
namespace Foodora\Test\Data;

use \PDO;

class SpecialDayManager extends DataManager {

    public function findSpecialDays($vendorId) {

        $stmt = $this->pdo()->prepare('SELECT * FROM vendor_special_day WHERE vendor_id = :vendorId');
	$stmt->bindValue(':vendorId', $vendorId);
	if (!$stmt->execute()) {

	    $this->dberror($stmt->errorInfo(), "Can't read vendor special days");
	}

	return $stmt->fetchAll(PDO::FETCH_CLASS, "\Foodora\Test\Data\Model\SpecialDay");
    }
}
