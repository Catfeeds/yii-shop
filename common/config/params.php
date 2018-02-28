<?php
return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'user.passwordResetTokenExpire' => 3600,
    'image' => ' http://p301ah80l.bkt.clouddn.com/',//图片域名七牛 http://p301ah80l.bkt.clouddn.com
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
    'qiniu' => [
    	'access_key' =>'TbfM4OnIUAwAy5jS1WqIvBMf-3r6OCVxO5NDM69k',
    	'secret_key' => 'Sct5H7M3_G_ujjwYoOl5MCrFVBkrsWC5CGVUOHrn',
    	'bucket' => 'teavideo'
    ]
];
