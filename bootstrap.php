<?php

$db_user = 'root';
$db_password = '';
$db_host = 'localhost';
$db_name = 'doctrine';

// bootstrap.php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

$entitiesPath = dirname(__FILE__)."/src";

require_once $entitiesPath."/Number.php";
require_once "vendor/autoload.php";

// Create a simple "default" Doctrine ORM configuration for Annotations
$isDevMode = true;
$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/src"), $isDevMode);

// database configuration parameters
$conn = array(
    'driver' => 'pdo_mysql',
    'user' => $db_user,
    'password' => $db_password,
    'host' => $db_host,
    'dbname' => $db_name
);

// obtaining the entity manager
$entityManager = EntityManager::create($conn, $config);
