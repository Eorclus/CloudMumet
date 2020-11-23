<?php
$dbopts = parse_url(getenv('DATABASE_URL'));
$connection ->register(new Csanquer\Silex\PdoServiceProvider\Provider\PDOServiceProvider('pdo'),
               array(
                'pdo.server' => array(
                   'driver'   => 'pgsql',
                   'user' => $dbopts["eahoyfmznokkdb"],
                   'password' => $dbopts["29116c045b75e0e039064e2f54a47a040265b0ee395e8eb1ed425190d7c833cb"],
                   'host' => $dbopts["ec2-54-166-114-48.compute-1.amazonaws.com"],
                   'port' => $dbopts["5432"],
                   'dbname' => ltrim($dbopts["path"],'/')
                   )
               )
);
?>
