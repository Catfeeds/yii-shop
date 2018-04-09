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
    'logistics' => [//物流
    	'appid' => '1280787',
    	'appkey'=>'17b64807-ceb2-457e-b797-02d15156ae84',
    	'search' => 'http://api.kdniao.cc/Ebusiness/EbusinessOrderHandle.aspx',
    ],
    'qiniu' => [//七牛云
    	'access_key' =>'TbfM4OnIUAwAy5jS1WqIvBMf-3r6OCVxO5NDM69k',
    	'secret_key' => 'Sct5H7M3_G_ujjwYoOl5MCrFVBkrsWC5CGVUOHrn',
    	'bucket' => 'teavideo'
    ],
    'qq'=>[//qq登录
    	'appid' =>'101140351',
    	'appkey' =>'3f8f54666cc0cc549ac98f28c33cf005',
    	'callback' =>'http://yii-shop.xiwenkeji.com/user/auth',
    	'scope' =>''
     ],
    'weixin'=>[//微信登录
        'appid' =>'wx4a027a66879fd224',
        'appsecret' =>'6a3facc08da612495421efb22f153735',
        'callback' =>'http://tea.reallytalent.cn/user/weixin',
    ],
    'weixin.notify' => 'http://tea.reallytalent.cn/pay/weixinnotify/',//微信支付回调
    'aliyun_sms' =>[//阿里短信
    	'accessKeyId' =>'LTAIUloKarS76KjI',
    	'accessKeySecret' =>'D26FYz9pDKazgi4SBwDQtaxGQLwVGY',
    	'SignName' =>'深圳文榜',
    	'TemplateCode' =>'SMS_130745225'
    ]
];
