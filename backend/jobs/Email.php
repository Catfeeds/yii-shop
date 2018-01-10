<?php

namespace backend\jobs;
use Yii;
/**
 * Class Download.
 */
class Email extends \yii\base\BaseObject implements \yii\queue\RetryableJobInterface
{
    public $email;

    /**
     * @inheritdoc
     */
    public function execute($queue)
    {	
    	$mail= Yii::$app->mailer->compose();
    	
    	$mail->setTo($this->email);
    	$mail->setSubject("邮件测试");
    	//$mail->setTextBody('zheshisha ');   //发布纯文字文本
    	$mail->setHtmlBody("<br>问我我我我我");    //发布可以带html标签的文本
    	if($mail->send())
    	{
    		return true;
    	}
    	return false;
    }

    /**
     * @inheritdoc
     */
    public function getTtr()
    {
        return 60;
    }

    /**
     * @inheritdoc
     */
    public function canRetry($attempt, $error)
    {
        return $attempt < 3;
    }
}
