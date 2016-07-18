<?php
namespace Foodora\Test\Service;

use Foodora\Test\Data\SchemaManager;

class SchemaService {

    private $schemaManager;
    private $appConfiguration;

    public function __construct($appConfiguration) {

        $this->schemaManager = new SchemaManager($appConfiguration);
	$this->appConfiguration = $appConfiguration;
    }

    public function checkAndMigrateDbSchema() {

	$currentVersion = $this->schemaManager->findCurrentSchema();
	$runScripts = array();
	
	foreach (glob($this->appConfiguration['database']['schemasDir'] . DIRECTORY_SEPARATOR . 'V*__*.sql') as $dbScript) {

	    $scriptVersion = (int) substr(basename($dbScript), 1, strpos(basename($dbScript), '__') - 1);
	    
	    if ($scriptVersion > $currentVersion) {

	        $runScripts[$scriptVersion] = $dbScript;
	    }
	}
	ksort($runScripts);
	foreach ($runScripts as $scriptVersion => $runScript) {

	    $this->schemaManager->addNewVersion($scriptVersion, file_get_contents($runScript));
        }
    }
}
