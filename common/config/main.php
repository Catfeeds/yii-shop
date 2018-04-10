<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'db' => [
	        'class' => yii\db\Connection::className(),
	        'dsn' => 'mysql:host=localhost;port=56643;dbname=fecshop',
	        'username' => 'root',
	        'password' => '1+1=10001$%',
	        'charset' => 'utf8mb4',
        ],
        'adminDB' => [
	        'class' => yii\db\Connection::className(),
	        'dsn' => 'mysql:host=localhost;port=56643;dbname=user',
	        'username' => 'root',
	        'password' => '1+1=10001$%',
	        'charset' => 'utf8mb4',
        ],
        'shop' => [
        	'class' => yii\db\Connection::className(),
        	'dsn' => 'mysql:host=localhost;port=56643;dbname=shop',
        	'username' => 'root',
        	'password' => '1+1=10001$%',
        	'charset' => 'utf8mb4',
        ],
        'mongodbShop' => [
        	'class' => 'yii\mongodb\Connection',
        	'dsn' => 'mongodb://127.0.0.1:27017/shop',
        ],
        'queue' => [
        	'class' => 'yii\queue\redis\Queue',
        ],
        'redis' => [
        	'class' => 'yii\redis\Connection',
            'hostname' => 'localhost',  
            'port' => 6379, 
            'database' => 0,
        ],
        'mailer' => [
	        'class' => yii\swiftmailer\Mailer::className(),
	        'viewPath' => '@common/mail',
	        'useFileTransport' => false,//false发送邮件，true只是生成邮件在runtime文件夹下，不发邮件
	        'transport' => [
		        'class' => 'Swift_SmtpTransport',
		        'host' => 'smtp.163.com',  //每种邮箱的host配置不一样
		        'username' => 'cl335905@163.com',
		        'password' => '*****',
		        'port' => '25',
		        'encryption' => 'tls',
        	],
        	'messageConfig' => [
        		'charset' => 'UTF-8',
        		'from' => ['cl335905@163.com' => 'Shop Team']
        	],
        ],
    ],
];
