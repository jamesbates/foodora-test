<?php
namespace Foodora\Test\Data;

use \PDO;

class SchemaManager extends DataManager {

    public function findCurrentSchema() {

        $stmt = $this->pdo()->prepare('SELECT MAX(version) FROM db_schema');
	if (!$stmt->execute()) {
           
	    // If no db_schema table is present, we are at version 0.
	    return 0;
        }

	return $stmt->fetchColumn(0); 
    }

    public function addNewVersion($newVersion, $ddlSql) {

	$stmt = $this->pdo()->prepare($ddlSql);
	if (!$stmt->execute()) {

	    $this->dberror($stmt->errorInfo(), 'could not upgrade database to version ' . $newVersion);
	}

	$stmt = $this->pdo()->prepare('INSERT INTO db_schema (version) values (:newVersion)');
	$stmt->bindParam(':newVersion',$newVersion,PDO::PARAM_INT);
	if (!$stmt->execute()) {

	    $this->dberror($stmt->errorInfo(), 'could not upgrade database to version ' . $newVersion);
	}
    }
}
