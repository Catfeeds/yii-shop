<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'language' => 'zh-CN',//默认语言
    'basePath' => dirname(__DIR__),
    'defaultRoute' => 'user/site/index',
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
    	'cms' => [
    		'class'=>'backend\modules\cms\Module'
    	] ,
    	'customer' => [
    		'class'=>'backend\modules\customer\Module'
    	] ,
    	'user' => [
    		'class'=>'backend\modules\user\Module'
    	],
    	'goods' => [
    		'class'=>'backend\modules\goods\Module'
    	]
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
            'cookieValidationKey' => 'ZQwmdZgB3dzzt7BHUsejZzM7p58ldRLL',
        ],
         'user' => [
            'identityClass' => backend\models\User::className(),
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_backend_identity'],
            'idParam' => '__backend__id',
            'returnUrlParam' => '_backend_returnUrl',
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'rbac' => [
	        'class' => backend\components\Rbac::className(),
		        'superAdministrators' => [//超级管理员用户，不受权限管理的控制
			        'admin',
			        'administrator',
		        ],
		        'noNeedAuthentication' => [//无需权限管理的控制器/操作，任意角色、用户，包括未登录均可访问
		        'site/index',
		        'site/login',
		        'site/logout',
		        'site/main',
		        'site/captcha',
		        'site/error',
		        'site/language',
		        'admin-user/update-self',
		        'error/forbidden',
		        'error/not-found',
		        'debug/default/toolbar',
		        'debug/default/view',
		        'assets/ueditor'
	        		],
        		],
        'i18n' => [
        	'translations' => [//多语言包设置
        		'app*' => [
        			'class' => yii\i18n\PhpMessageSource::className(),
        			'basePath' => '@backend/messages',
        			'sourceLanguage' => 'en-US',
        			'fileMap' => [
        				'app' => 'app.php',
        				'app/error' => 'error.php',
        			],
        		],
        		'menu' => [
        			'class' => yii\i18n\PhpMessageSource::className(),
        			'basePath' => '@backend/messages',
        			'sourceLanguage' => 'zh-CN',
        			'fileMap' => [
        				'app' => 'menu.php',
        				'app/error' => 'error.php',
        			],
        		],
        	],
        ],
        
    ],
    'params' => $params,
    'on beforeAction' => [backend\components\Rbac::className(), 'checkPermission'],
];
