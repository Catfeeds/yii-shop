<?php
return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'user.passwordResetTokenExpire' => 3600,
    'image' => ' http://p301ah80l.bkt.clouddn.com/',//图片域名七牛 http://p301ah80l.bkt.clouddn.com
    'goods.cart'=>'xiwenkeji',//value不能含有. cookie获取不到,不登录临时保存购物车
    'goods.selectcart' => 'selectcart',//临时保存选中购物车
    'site' => [
    	'url' => '',
    	'sign' => '',//数据库中保存的本站地址，展示时替换成正确url
    ],
    'upload' => [
    	'url'  => '',// 服务器解析到/web/目录时，uploads目录
    	'path' => Yii::getAlias('@image/'), // 上传目录
    ],
    'kuaidi_100' => '09aba6b79e788f4f',//物流
    'qiniu' => [//七牛云
    	'access_key' =>'TbfM4OnIUAwAy5jS1WqIvBMf-3r6OCVxO5NDM69k',
    	'secret_key' => 'Sct5H7M3_G_ujjwYoOl5MCrFVBkrsWC5CGVUOHrn',
    	'bucket' => 'teavideo'
    ],
    'qq'=>[//qq登录
    	'appid' =>'101140351',
    	'appkey' =>'f080f76ad8cb5b88abdd0af09973a68f',
    	'callback' =>'http://www.wenbangtea.com/user/auth',
    	'scope' =>''
     ],
    'weixin'=>[//微信登录,微信开放平台只设置回调域名即可 
        'appid' =>'wxfc78ab1472d039fd',
        'appsecret' =>'f080f76ad8cb5b88abdd0af09973a68f',
        'callback' =>'http://www.wenbangtea.com/user/weixin',
    ],
    'weixin.notify' => 'http://www.wenbangtea.com/pay/weixinnotify/',//微信支付回调
    'aliyun_sms' =>[//阿里短信
    	'accessKeyId' =>'LTAIUloKarS76KjI',
    	'accessKeySecret' =>'D26FYz9pDKazgi4SBwDQtaxGQLwVGY',
    	'SignName' =>'深圳文榜茶业有限公司',
    	'Template_Register' =>'SMS_130745225',
    	'Template_Resetpwd' =>'SMS_130995048'
    ]
];
