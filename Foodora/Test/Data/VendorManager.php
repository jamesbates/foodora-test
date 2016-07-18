<?php
namespace Foodora\Test\Data;

use \PDO;

class VendorManager extends DataManager {

    public function findAllVendors() {

	$stmt = $this->pdo()->prepare('SELECT * FROM vendor');
	if (!$stmt->execute()) {

	    $this->dberror($stmt->errorInfo(), "Can't read vendors");
	}

	return $stmt->fetchAll(PDO::FETCH_CLASS,'\Foodora\Test\Data\Model\Vendor');
    }
}
