<?php

use Doctrine\DBAL\DriverManager;
use Doctrine\Migrations\Configuration\Configuration;
use Doctrine\Migrations\Tools\Console\Helper\ConfigurationHelper;

// Load the CodeIgniter database configuration
// require_once __DIR__.'/../application/config/database.php';
$dbConfig = array(
	'driver' => 'pdo_mysql',
	'host' => 'localhost',
	'dbname' => 'bus_booking',
	'user' => 'alitelsit-mysql',
	'password' => '1234Abcde',
	'charset' => 'utf8',
	'collate' => 'utf8_unicode_ci',
);

$config = new Configuration(
    DriverManager::getConnection($dbConfig),
    new ConfigurationHelper()
);
$config->setName('CodeIgniter Migrations');
$config->setMigrationsDirectory(APPPATH . 'migrations');
$config->setMigrationsNamespace('Application\Migrations');
$config->setMigrationsTableName('migrations');
$config->setAllOrNothing(true);

return $config;
