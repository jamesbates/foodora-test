<?php
namespace Foodora\Test\Cli;

use \Foodora\Test\Service\SchemaService;
use \Foodora\Test\Service\ScheduleService;

class Cli {

    private $mode;
    private $schemaService;
    private $scheduleService;

    public function __construct($argc, $argv) {

        if ($argc != 2) {

	    self::usage();
        }

    	if ($argv[1] == '-activate') {

	    $this->mode = 'activate';
    	} else if ($argv[1] == '-restore') {

	    $this->mode = 'restore';
    	} else {
									
	   self::usage();
        }

	$appConfiguration = parse_ini_file('app_configuration.ini', TRUE);
	$this->schemaService = new SchemaService($appConfiguration);
	$this->scheduleService = new ScheduleService($appConfiguration);
    }

    public function run() {

	$this->schemaService->checkAndMigrateDbSchema();
    
   	if ($this->mode == 'activate') {

	    $this->scheduleService->activateAllSpecialDays();
	}

	if ($this->mode == 'restore') {

	    $this->scheduleService->restoreAllSpecialDays();
	}
    }

    private static function usage() {

        error_log('Usage: php run.php (-activate | -restore)');
	die();
    }
}

