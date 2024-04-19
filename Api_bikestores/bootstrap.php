<?php
# bootstrap.php

require_once join(DIRECTORY_SEPARATOR, [__DIR__, 'vendor', 'autoload.php']);

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

function getEntityManager() {
    $entitiesPath = [
        join(DIRECTORY_SEPARATOR, [__DIR__, "src", "Entity"])
    ];

    $isDevMode = true;
    $proxyDir = null;
    $cache = null;
    $useSimpleAnnotationReader = false;

    // Connexion à la base de données
    // $dbParams = [
    //     'driver'   => 'pdo_mysql',
    //     'host'     => 'localhost',
    //     'charset'  => 'utf8',
    //     'user'     => 'root',
    //     'password' => 'YW$4%i4Nz8zWHuv',
    //     'dbname'   => 'SAE_401',
    // ];
    $dbParams = [
        'driver'   => 'pdo_mysql',
        'host'     => 'mysql.info.unicaen.fr:3306',
        'charset'  => 'utf8',
        'user'     => 'vallee211',
        'password' => 'eo5Ahpamaighieph',
        'dbname'   => 'vallee211_8',
    ];

    $config = Setup::createAnnotationMetadataConfiguration(
        $entitiesPath,
        $isDevMode,
        $proxyDir,
        $cache,
        $useSimpleAnnotationReader
    );

    return EntityManager::create($dbParams, $config);
}

$entitiesPath = [
    join(DIRECTORY_SEPARATOR, [__DIR__, "src", "Entity"])
];

$isDevMode = true;
$proxyDir = null;
$cache = null;
$useSimpleAnnotationReader = false;

// Connexion à la base de données
// $dbParams = [
//     'driver'   => 'pdo_mysql',
//     'host'     => 'mysql.info.unicaen.fr:3306',
//     'charset'  => 'utf8',
//     'user'     => 'vallee211',
//     'password' => 'eo5Ahpamaighieph',
//     'dbname'   => 'vallee211_8',
// ];
$dbParams = [
    'driver'   => 'pdo_mysql',
    'host'     => 'localhost',
    'charset'  => 'utf8',
    'user'     => 'root',
    'password' => 'YW$4%i4Nz8zWHuv',
    'dbname'   => 'SAE_401',
];

$config = Setup::createAnnotationMetadataConfiguration(
    $entitiesPath,
    $isDevMode,
    $proxyDir,
    $cache,
    $useSimpleAnnotationReader
);
$entityManager = EntityManager::create($dbParams, $config);

return $entityManager;