<?php

namespace backend\modules\user\controllers;

use yii;
use Exception;
use common\models\Comment;
use backend\models\LoginForm;
use common\libs\ServerInfo;
use backend\models\Article as ArticleModel;
use backend\models\Comment as BackendComment;
use common\models\FriendLink;
use frontend\models\User;
use yii\base\UserException;
use yii\db\Query;
use yii\web\HttpException;
use yii\captcha\CaptchaAction;
use common\service\code\Verify;
class SiteController extends \yii\web\Controller
{

   

    public function actionLogin()
    {
        if (!Yii::$app->getUser()->getIsGuest()) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->getRequest()->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->renderPartial('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * @inheritdoc
     */
    public function actionIndex()
    {	
        return $this->renderPartial('index');
    }


    public function actionMain()
    {
        switch (yii::$app->getDb()->driverName) {
            case "mysql":
                $dbInfo = 'MySQL ' . (new Query())->select('version()')->one()['version()'];
                break;
            case "pgsql":
                $dbInfo = (new Query())->select('version()')->one()['version'];
                break;
            default:
                $dbInfo = "Unknown";
        }
        $info = [
            'OPERATING_ENVIRONMENT' => PHP_OS . ' ' . yii::$app->getRequest()->getServerName(),
            'PHP_RUN_MODE' => php_sapi_name(),
            'DB_INFO' => $dbInfo,
            'PROGRAM_VERSION' => "1.0",
            'UPLOAD_MAX_FILESIZE' => ini_get('upload_max_filesize'),
            'MAX_EXECUTION_TIME' => ini_get('max_execution_time') . "s"
        ];
        $obj = new ServerInfo();
        $serverInfo = $obj->getinfo();
        error_reporting(E_ALL);
        $status = [
            'DISK_SPACE' => [
                'NUM' => ceil($serverInfo['diskTotal'] - $serverInfo['freeSpace']) . 'G' . ' / ' . ceil($serverInfo['diskTotal']) . 'G',
                'PERCENTAGE' => (floatval($serverInfo['diskTotal']) != 0) ? round(($serverInfo['diskTotal'] - $serverInfo['freeSpace']) / $serverInfo['diskTotal'] * 100, 2) : 0,
            ],
            'MEM' => [
                'NUM' => $serverInfo["UsedMemory"] . ' / ' . $serverInfo['TotalMemory'],
                'PERCENTAGE' => $serverInfo["memPercent"],
            ],
            'REAL_MEM' => [
                'NUM' => $serverInfo["memRealUsed"] . "(Cached {$serverInfo['CachedMemory']})" . ' / ' . $serverInfo['TotalMemory'],
                'PERCENTAGE' => $serverInfo['memRealPercent'] . '%',
            ],
        ];
        return $this->render('main', ['info' => $info, 'status' => $status]);
    }


    /**
     * 管理员退出登陆
     *
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        Yii::$app->getUser()->logout(false);

        return $this->goHome();
    }
	
    
    public function actionCaptcha()
    {
    	$verify = new Verify();
    	ob_clean();
    	return $verify->entry(); exit;
    }
}
