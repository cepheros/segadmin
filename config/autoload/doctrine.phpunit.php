<?php
return array(
        'doctrine' => array(
                'connection' => array(
                        'orm_default' => array(
                                'driverClass' =>'Doctrine\DBAL\Driver\PDOMySql\Driver',
                                'params' => array(
                                        'host'     => 'localhost',
                                        'port'     => '3306',
                                        'user'     => 'root',
                                        'password' => '@p0q1o9w2',
                                        'dbname'   => 'segadmin_testes',
                                )
                        )
                )
        )
 );
