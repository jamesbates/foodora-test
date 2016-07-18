<?php
namespace Foodora\Test\Data;

use \PDO;

abstract class DataManager {

    // We share the PDO accross all instances of DataManager, in order to
    // ensure global transactional behaviour
    private static $pdo = null;

    public function __construct($appConfiguration) {

	self::initDb($appConfiguration);
    }

    public function pdo() {

        return self::$pdo;
    }

    private static function initDb($appConfiguration) {

	if (self::$pdo == null) {

	    self::$pdo = new PDO(
		'mysql:host=' . $appConfiguration['database']['dbhost'] . ';dbname=' . $appConfiguration['database']['dbname'],
		$appConfiguration['database']['username'],
		$appConfiguration['database']['password']
	    );
	}
    }

    protected function dberror($errorInfo, $msg)
    {
	error_log($msg . ': ' . $errorInfo[2]);
	if ($this->pdo()->inTransaction() && !$this->pdo()->rollback()) {

	    $errorInfo = $this->pdo()->errorInfo();
	    error_log('Rollback failed: ' . $errorInfo[2]);
	}

	die();
    }

    public function beginTransaction() {

        if (!$this->pdo()->beginTransaction()) {

	    $this->dberror($this->pdo()->errorInfo(), "Can't start transaction");
	}
    }

    public function commitTransaction() {

        if (!$this->pdo()->commit()) {

	    $this->dberror($this->pdo()->errorInfo(), "Can't commit transaction");
	}
    }
}

