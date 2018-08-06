<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log','queue'],
    'controllerNamespace' => 'console\controllers',
    'controllerMap' => [
        'fixture' => [
            'class' => 'yii\console\controllers\FixtureController',
            'namespace' => 'common\fixtures',
          ],
        'websocket' => [
          'class' => 'jianyan\websocket\console\WebSocketController',
   		  'server' => 'jianyan\websocket\server\WebSocketServer', // 可替换为自己的业务类继承该类即可
          'host' => '0.0.0.0',// 监听地址
          'type' => 'ws', // 默认为ws连接，可修改为wss
          'port' => 8080,// 监听端口
          'config' => [// 标准的swoole配置项都可以再此加入
	          'daemonize' => false,// 守护进程执行
	          'task_worker_num' => 4,//task进程的数量
	          'ssl_cert_file' => '',
	          'ssl_key_file' => '',
	          'pid_file' => __DIR__ . '/../runtime/logs/server.pid',
	          'log_file' => __DIR__ . '/../runtime/logs/swoole.log',
	          'log_level' => 0,
         ],
		]
    ],
    'components' => [
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ]
    ],
    'params' => $params,
];
