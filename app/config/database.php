<?php

$databaseurl = isset($_ENV["DATABASE_URL"]) ? $_ENV["DATABASE_URL"] : (isset($_SERVER["DATABASE_URL"]) ? $_SERVER["DATABASE_URL"] : FALSE);

if($databaseurl === FALSE) {
    $container->setParameter('database_driver', 'pdo_sqlite');
    $container->setParameter('database_host', null);
    $container->setParameter('database_port', null);
    $container->setParameter('database_name', 'db.sqlite');
    $container->setParameter('database_user', null);
    $container->setParameter('database_password', null);
    $container->setParameter('database_path', '%kernel.root_dir%/db.sqlite');
} else {

    $parsedurl = parse_url($databaseurl);

    switch($parsedurl['scheme']) {
        case 'postgres': {

            $container->setParameter('database_driver', 'pdo_pgsql');
            $container->setParameter('database_host', $parsedurl['host']);
            $container->setParameter('database_port', $parsedurl['port']);
            $container->setParameter('database_name', substr($parsedurl['path'], 1));   # stripping slash prefix
            $container->setParameter('database_path', null);
            $container->setParameter('database_user', $parsedurl['user']);
            $container->setParameter('database_password', $parsedurl['pass']);
            break;
        }
        case 'sqlite': {

            $container->setParameter('database_driver', 'pdo_sqlite');
            $container->setParameter('database_host', null);
            $container->setParameter('database_port', null);
            $container->setParameter('database_name', basename(substr($parsedurl['path'], 1)));
            $container->setParameter('database_path', $parsedurl['path']);
            $container->setParameter('database_user', null);
            $container->setParameter('database_password', null);

            break;
        }
    }
    
    #var_dump($parsedurl);
    #die();

    unset($parsedurl);
}

unset($databaseurl);